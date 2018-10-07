<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

use App\User\User;
use App\User\UserMembershipPayment;

class PageController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware(function ($request, $next) {
            view()->composer('*', function($view) {
                $view_name =  'page ' . str_replace('.', '-', $view->getName());
                view()->share('viewName', $view_name);
            });
            return $next($request);
        });
    }

    public function findOutMore()
    {
        return view('public.pages.find-out-more');
    }

    public function membership()
    {
        $users = User::with(['membershipPaymentsRelationship'])->get();
        $members = $users->filter(function($user) {
            return $user->isMember(true);
        })->count();

        $allPayments = UserMembershipPayment::get();
        $totalMembershipPayments = $allPayments->map(function($payment) {
            return ($payment->amount > 2) ? $payment->amount : null;
        })->filter()->sum();

        $totalPayingMembers = $allPayments->unique('user_id')->count();
        $averageMembershipPayments = $members === 0 ? 0 : $totalMembershipPayments / $totalPayingMembers;

        return view('public.pages.membership', [
            'members' => $members,
            'averageMembership' => round($averageMembershipPayments)
        ]);
    }

    public function economy()
    {
        return view('public.pages.economy');
    }

    public function transactions()
    {
        return view('public.pages.transactions');
    }

    public function team()
    {
        return view('public.pages.team');
    }

    public function statistics(Request $request)
    {
        $currencyQuery = '';
        if ($request->has('currency')) {
            $currencyQuery = '?currency=' . $request->get('currency');
        }

        $client = new Client();
        $res = $client->request('GET', 'https://api.localfoodnodes.org/v1.0/orders/amount/node' . $currencyQuery);
        $orders = json_decode($res->getBody());

        $res = $client->request('GET', 'https://api.localfoodnodes.org/v1.0/nodes/names');
        $nodes = json_decode($res->getBody());

        $res = $client->request('GET', 'https://api.localfoodnodes.org/v1.0/currency/rates');
        $currencies = json_decode($res->getBody());

        $res = $client->request('GET', 'https://api.localfoodnodes.org/v1.0/currency/labels');
        $currencyLabels = json_decode($res->getBody());

        return view('public.pages.statistics', [
            'orders' => $orders->data,
            'nodes' => $nodes->data,
            'currencies' => $currencies->data,
            'currencyLabels' => $currencyLabels->data,
        ]);
    }

    public function gdpr()
    {
        return view('public.pages.gdpr');
    }

    public function app()
    {
        return view('public.pages.app');
    }
}
