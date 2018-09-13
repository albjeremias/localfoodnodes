<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use GuzzleHttp\Client;

use Mail;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User\User;
use App\User\GdprConsent;
use App\User\UserNodeLink;
use App\Image\Image;
use App\Node\Node;
use App\Producer\Producer;
use App\Order\Order;
use App\Event\EventUserLink;

use App\Helpers\GoogleMapsHelper;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        /**
         * Check if requested producer account exist, or if user has permission.
         */
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            $orderId = $request->route('orderId');

            if (!$orderId) {
                return $next($request);
            }

            $orderItemId = $request->route('orderItemId');
            $orderItem = $order->item($orderItemId);
            if (!$orderItem) {
                $request->session()->flash('error', [trans('admin/messages.request_no_order_item')]);
                return redirect('/account/user');
            }

            return $next($request);
        });
    }

    /**
     * Activation screen.
     *
     * @param Request $request
     * @param string $token
     */
    public function activate(Request $request)
    {
        $user = Auth::user();

        if ($user->active) {
            return redirect('/account/user');
        }

        return view('account.user.activate', [
            'breadcrumbs' => [
                $user->name => '',
                trans('admin/user-nav.activate') => ''
            ]
        ]);
    }

    /**
     * Resend activation link.
     *
     * @param Request $request
     * @param string $token
     */
    public function activateResend(Request $request)
    {
        $user = Auth::user();
        $this->sendActivationLink($user);

        $request->session()->flash('message', [trans('admin/messages.user_account_email_sent')]);
        return redirect('/account/user/activate');
    }

    /**
     * Activate user from activation email.
     *
     * @param Request $request
     * @param string $token
     */
    public function activateToken(Request $request, $token)
    {
        $success = false;

        // Get user id from activation table
        $userId = DB::table('user_activations')->select('user_id')->where('token', $token)->value('user_id');

        // Load user
        $user = User::find($userId);

        if ($user) {
            // Activate user
            $user->fill(['active' => 1]);
            $user->save();
            $success = true;

            // Delete user token from database
            DB::table('user_activations')->where('token', $token)->delete();
        }

        // Redirects
        if (Auth::check()) {
            if ($success) {
                // If user is logged in and activation was successful
                $request->session()->flash('message', [trans('admin/messages.user_account_activated')]);
                return redirect('/account/user');
            } else {
                // IF user is logged in and activation failed
                $request->session()->flash('error', [trans('admin/messages.user_account_activation_failed')]);
                return redirect('/account/user/activate?error=activation_failed');
            }
        } else {
            if ($success) {
                // If user is not logged in and activation was successful
                $request->session()->flash('message', [trans('admin/messages.user_account_activated')]);
                return redirect('/login?message=activation_complete');
            } else {
                // If user is not logged in and activation failed
                $request->session()->flash('error', [trans('admin/messages.user_account_activation_failed')]);
                return redirect('/login?error=activation_failed');
            }
        }
    }

    /**
     * User index action.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        return view('account.user.index', [
            'breadcrumbs' => [
                $user->name => '',
                trans('admin/user-nav.dashboard') => ''
            ]
        ]);
    }

    /**
     * User create action.
     */
    public function create(Request $request, $type = null)
    {
        if (Auth::check()) {
            return redirect('/account/user');
        }

        $header = trans('public/create-account.user_header');
        $content = '';

        if ($type) {
            $header = trans('public/create-account.' . $type . '_header');
            $content = trans('public/create-account.' . $type);
        }

        return view('public.user.create', [
            'header' => $header,
            'content' => $content,
            'breadcrumbs' => [
                trans('admin/user-nav.create_account') => ''
            ]
        ]);
    }

    /**
     * User insert action.
     */
    public function insert(Request $request)
    {
        $data = $request->all();
        $user = new User();

        $errors = $user->validate($data);

        if (!isset($data['gdpr'])) {
            $errors->add('gdpr', trans('validation.required'));
        }

        if ($errors->isEmpty()) {
            $userData = $user->sanitize($data);
            $userData['password'] = \Hash::make($userData['password']);
            $user->fill($userData);
            $user->language = $this->getLang();

            // Default location Röstånga
            $user->setLocation('56.002490 13.293257');
            $user->save();

            GdprConsent::create(['user_id' => $user->id, 'name' => $user->name]);

            \App\Helpers\SlackHelper::message('notification', $user->name . ' (' . $user->email . ')' . ' signed up as a user.');

            $this->sendActivationLink($user);

            Auth::login($user);

            $request->session()->flash('message', [trans('admin/messages.user_account_created')]);
            $request->session()->flash('welcome_modal', true);

            return redirect('/account/user');
        }

        return redirect('/account/user/create')->withInput()->withErrors($errors);
    }

    /**
     * User edit action.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        $user->fill($request->old());

        return view('account.user.edit', [
            'user' => $user,
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.edit') => ''
            ]
        ]);
    }

    /**
     * User update action.
     */
    public function update(Request $request, GoogleMapsHelper $googleMapsHelper)
    {
        $user = Auth::user();
        $data = $request->all();

        $errors = $user->validateUpdate($data);
        if ($errors->isEmpty()) {
            $user->fill($user->sanitize($data));

            $latLng = $googleMapsHelper->getLatLngForDb($user->getAddressFields());
            $user->setLocation($latLng);

            $user->save();

            $this->uploadImage($request, $user);

            $request->session()->flash('message', [trans('admin/messages.user_account_updated')]);
            return redirect('/account/user');
        }

        return redirect('/account/user/edit')->withInput()->withErrors($errors);
    }

    /**
     * Confirm delete action.
     */
    public function deleteConfirm(Request $request)
    {
        $user = Auth::user();

        return view('account.user.confirm-delete', [
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.delete') => ''
            ]
        ]);
    }

    /**
     * Approve gdpr.
     */
    public function gdpr(Request $request)
    {
        $user = Auth::user();
        GdprConsent::create(['user_id' => $user->id, 'name' => $user->name]);

        return redirect('/account/user');
    }


    /**
     * Confirm delete action.
     */
    public function gdprDeleteConfirm(Request $request)
    {
        $user = Auth::user();

        return view('account.user.gdpr-confirm-delete');
    }

    /**
     * User delete action.
     */
    public function delete(Request $request)
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();
        $request->session()->flash('message', [trans('admin/messages.user_account_deleted')]);

        return redirect('/');
    }

    /**
     * Upload image.
     *
     * @param Request $request
     * @param Producer $producer
     */
    public function uploadImage(Request $request, $user)
    {
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                Image::create([
                    'entity_id' => $user->id,
                    'entity_type' => 'user',
                    'file' => $file,
                    'sort' => 999
                ]);
            }
        }

        if ($request->input('image_sort_order')) {
            foreach ($request->input('image_sort_order') as $imageId => $sortOrder) {
                $image = $user->image($imageId);
                $image->sort = $sortOrder;
                $image->save();
            }
        }
    }

    /**
     * Edit password action.
     */
    public function editPassword()
    {
        $user = Auth::user();

        return view('account.user.edit-password', [
            'breadcrumbs' => [
                $user->name => 'user/' . $user->id,
                trans('admin/user-nav.change_password') => ''
            ]
        ]);
    }

    /**
     * Update password action.
     */
    public function updatePassword(Request $request, GoogleMapsHelper $googleMapsHelper)
    {
        $user = Auth::user();
        $data = $request->all();

        $errors = $user->validateUpdatePassword($data);
        if ($errors->isEmpty()) {
            $user->password = \Hash::make($data['password']);

            // Fix for migrated users. Update position if user have an address.
            if ($user->address && ($user->city || $user->zip)) {
                $latLng = $googleMapsHelper->getLatLngForDb($user->getAddressFields());
                $user->setLocation($latLng);
            }

            $user->save();

            $request->session()->flash('message', [trans('admin/messages.user_password_changed')]);
            return redirect('/account/user');
        }

        return redirect('/account/user/password/edit')->withErrors($errors);
    }

    /**
     * Pickups action.
     */
    public function pickups()
    {
        $user = Auth::user();

        return view('account.user.pickups', [
            'user' => $user,
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.pickups') => ''
            ]
        ]);
    }

    /**
     * Orders action.
     */
    public function producerOrders(Request $request, $producerId)
    {
        $user = Auth::user();
        $producer = Producer::find($producerId);
        $orderDateItemLinks = $user->orderDateItemLinks($producerId);

        return view('account.user.producer-orders', [
            'orderDateItemLinks' => $orderDateItemLinks,
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.pickups') => 'user/pickups',
                $producer->name => ''
            ]
        ]);
    }

    /**
     * Orders action.
     */
    public function order(Request $request, $orderDateItemLinkId)
    {
        $user = Auth::user();
        $orderDateItemLink = $user->orderDateItemLink($orderDateItemLinkId);

        return view('account.user.order', [
            'user' => $user,
            'orderDateItemLink' => $orderDateItemLink,
            'orderDate' => $orderDateItemLink->getDate(),
            'orderItem' => $orderDateItemLink->getItem(),
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.orders') => 'user/pickups',
                trans('admin/user-nav.order') . ' #' . $orderDateItemLink->ref => ''
            ]
        ]);
    }

    /**
     * Product orders action.
     */
    public function productOrders($productId)
    {
        $user = Auth::user();

        $orderDateItemLinks = $user->orderDateItemLinks()->filter(function($orderDateItemLink) use ($productId) { // null, $producerId
            return $orderDateItemLink->getItem()->product_id == $productId;
        });

        return view('account.user.product-orders', [
            'user' => $user,
            'orderDateItemLinks' => $orderDateItemLinks,
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.orders') => 'user/pickups',
                $orderDateItemLinks->first()->getItem()->getName() => ''
            ]
        ]);
    }

    /**
     * Delete order item action.
     */
    public function deleteOrderItem(Request $request, $orderDateItemLinkId)
    {
        $user = Auth::user();

        $orderDateItemLink = $user->orderDateItemLink($orderDateItemLinkId);
        $orderDateItemLink->delete();
        $request->session()->flash('message', [trans('admin/messages.order_deleted')]);

        return redirect('/account/user/pickups');
    }

    /**
     * Membership action.
     *
     * @param  Request $request
     */
    public function membership(Request $request)
    {
        $user = Auth::user();

        return view('account.user.membership', [
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.membership') => ''
            ]
        ]);
    }

    /**
     * Handle membership callback action.
     */
    public function membershipCallback(Request $request)
    {
        $user = Auth::user();

        $token = $request->input('stripeToken');
        $amount = $request->input('amount');

        $status = $user->processMembershipPayment($token, $amount);

        if ($status['error']) {
            $request->session()->flash('message', [
                trans('admin/messages.user_membership_error', [
                    'errors' => $status['message']
                ])
            ]);

            return redirect('/account/user/membership');
        }

        if ($status['message'] < 3) {
            $request->session()->flash('membership_modal_no_charge', true);
        } else {
            $request->session()->flash('membership_modal_thanks', true);
            $request->session()->flash('message', [trans('admin/messages.user_membership_success')]);
        }

        return redirect('/account/user/membership');
    }

    /**
     * Add or remove node from user.
     */
    public function toggleNode(Request $request, $nodeId)
    {
        $user = Auth::user();
        $userNodeLink = UserNodeLink::where('user_id', $user->id)->where('node_id', $nodeId)->first();
        if ($userNodeLink) {
            $userNodeLink->delete();
        } else {
            UserNodeLInk::create([
                'user_id' => $user->id,
                'node_id' => $nodeId
            ]);
        }

        return redirect()->back();
    }

    /**
     * User event action.
     */
    public function events()
    {
        $user = Auth::user();

        return view('account.user.events', [
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.events') => ''
            ]
        ]);
    }

    /**
     * Add or remove user from event.
     */
    public function toggleEvent(Request $request, $eventId)
    {
        $user = Auth::user();
        $eventUserLink = EventUserLink::where(['user_id' => $user->id, 'event_id' => $eventId])->first();
        if ($eventUserLink) {
            $eventUserLink->delete();
        } else {
            EventUserLInk::create([
                'user_id' => $user->id,
                'event_id' => $eventId
            ]);
        }

        return redirect()->back();
    }

    /**
     * Send activation link.
     *
     * @param User $user
     */
    private function sendActivationLink($user)
    {
        $token = DB::table('user_activations')->select('token')->where('user_id', '=', $user->id)->value('token');

        if (!$token) {
            // Clear.
            DB::table('user_activations')->where('user_id', $user->id)->delete();
            // Create new token and insert to database.
            DB::table('user_activations')->insert(['user_id' => $user->id, 'token' => hash_hmac('sha256', str_random(64), config('app.key'))]);
            // Get token from database to ensure that we send the correct one in the email.
            $token = DB::table('user_activations')->select('token')->where('user_id', '=', $user->id)->value('token');
        }

        Mail::send('email.activate-user', ['user' => $user, 'token' => $token], function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject(trans('public/email.activate_your_account'));
        });
    }

    public function testNotification()
    {
        $user = Auth::user();
        $pushTokens = $user->getPushTokens();
        $pushApiUrl = 'https://exp.host/--/api/v2/push/send';

        $client = new Client();

        foreach($pushTokens as $pushToken) {
            $client->request('POST', $pushApiUrl, [
                'form_params' => [
                    'to' => $pushToken,
                    'title' => 'push test',
                    'body' => 'message',
                ]
            ]);
        }
    }
}
