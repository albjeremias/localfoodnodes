<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Translation\Translator;

use \App\NotificationEvent;
use \App\Notification;
use \App\Node\Node;
use \App\Order\OrderDateItemLink;

class CronController extends BaseController
{

    public function run(Request $request) {
        $this->generateNextPickupDate();
        $this->generatePickupReminderDay();
        // $this->generatePickupReminderHour();

        $this->sendUserNotifications();
        return 'done';
    }

    public function generateNextPickupDate()
    {
        $nodeIds = DB::table('nodes')->pluck('id');
        while (!$nodeIds->isEmpty()) {
            $nodeId = $nodeIds->shift();
            $node = \App\Node\Node::find($nodeId);
            $deliveryDate = $node->getNextDelivery();

            try {
                NotificationEvent::create([
                    'context' => 'node',
                    'context_id' => $nodeId,
                    'unique' => $deliveryDate->format('Y-m-d'),
                    'title' => 'notification_upcoming_delivery_title',
                    'message' => 'notification_upcoming_delivery_message',
                    'variables' => [
                        'node_name' => $node->name,
                        'date' => $deliveryDate->format('Y-m-d')
                    ]
                ]);
            } catch(\Illuminate\Database\QueryException $e) {
                // Ignore duplicates
            }
        }
    }

    public function generatePickupReminderDay()
    {
        $today = new \DateTime();
        $notificationDate = $today->modify('+1 day');

        $orders = DB::table('order_date_item_links')
        ->join('order_dates', 'order_date_item_links.order_date_id', '=', 'order_dates.id')
        ->join('order_items', 'order_date_item_links.order_item_id', '=', 'order_items.id')
        ->where('order_dates.date', '=', $notificationDate->format('Y-m-d'))->get();

        $orders->each(function($order) {
            $node = json_decode($order->node);

            // Add a notification for producer's user_id, and also handle accounts with multiple producer admins
            $producerAdminLinks = DB::table('producer_admin_links')
            ->where('producer_id', '=', $order->producer_id)->get();

            $producerAdminLinks->each(function($producerAdminLink) use ($order, $node) {
                try {
                    NotificationEvent::create([
                        'context' => 'order',
                        'context_id' => $producerAdminLink->user_id,
                        'unique' => $order->date,
                        'title' => 'notification_reminder_pickup_hour_title',
                        'message' => 'notification_reminder_pickup_hour_message',
                        'variables' => [
                            'node_name' => $node->name,
                            'date' => $order->date,
                            'time' => $node->delivery_time
                        ]
                    ]);
                } catch(\Illuminate\Database\QueryException $e) {
                    // Ignore duplicates
                }
            });

            try {
                NotificationEvent::create([
                    'context' => 'order',
                    'context_id' => $order->user_id,
                    'unique' => $order->date,
                    'title' => 'notification_reminder_pickup_day_title',
                    'message' => 'notification_reminder_pickup_day_message',
                    'variables' => [
                        'node_name' => $node->name,
                        'date' => $order->date,
                        'producer_id' => $order->producer_id,
                    ]
                ]);
            } catch(\Illuminate\Database\QueryException $e) {
                // Ignore duplicates
            }
        });
    }

    private function sendUserNotifications()
    {
        $notificationEvents = NotificationEvent::all();

        $notificationEvents->each(function($notificationEvent) {
            // Get all users for this event
            if ($notificationEvent->context === 'node') {
                $node = Node::find($notificationEvent->context_id);

                if ($node) {
                    $node->userLinks()->map(function($userLink) use ($node, $notificationEvent) {
                        $user = $userLink->getUser();

                        try {
                            Notification::create([
                                'user_id' => $user->id,
                                'title' => $notificationEvent->title,
                                'message' => $notificationEvent->message,
                                'variables' => $notificationEvent->variables,
                            ]);
                        } catch(\Illuminate\Database\QueryException $e) {
                            // Ignore duplicates
                        }
                    });
                } else {
                    // Not doesn't exist any more so remove the notification event
                    $notificationEvent->delete();
                }
            }

            // Order
            if ($notificationEvent->context === 'order') {
                try {
                    Notification::create([
                        'user_id' => $notificationEvent->context_id,
                        'title' => $notificationEvent->title,
                        'message' => $notificationEvent->message,
                        'variables' => $notificationEvent->variables,
                    ]);
                } catch(\Illuminate\Database\QueryException $e) {
                    // Ignore duplicates
                }
            }
        });
    }
}
