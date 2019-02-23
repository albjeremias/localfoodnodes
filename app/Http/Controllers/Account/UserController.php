<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;
use Illuminate\Database\QueryException;
use GuzzleHttp\Client;

use Mail;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\User\User;
use App\User\UserMembershipPayment;
use App\User\GdprConsent;
use App\User\UserNodeLink;
use App\Image\Image;
use App\Node\Node;
use App\Producer\Producer;
use App\Order\Order;

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

        return view('new.account.user.index', [
            'breadcrumbs' => [
                $user->name => '',
                __('Dashboard') => ''
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

        return view('new.public.register', [
            'breadcrumbs' => [
                __('Create account') => ''
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

            return route('account_user');
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
        $currencies = Db::table('currencies')->where('enabled', true)->get();

        return view('new.account.user.edit', [
            'user' => $user,
            'currencies' => $currencies,
            'breadcrumbs' => [
                $user->name => 'user',
                __('My profile') => ''
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

            \App::setLocale($user->language);
            $request->session()->flash('message', [trans('admin/messages.user_account_updated')]);
            return redirect()->route('account_user_edit');
        }

        return redirect()->route('account_user_edit')->withInput()->withErrors($errors);
    }

    /**
     * User delete action.
     */
    public function delete(Request $request)
    {
        $user = Auth::user();

        if ($request->has('confirmed')) {
            Auth::logout();
            $user->delete();
            $request->session()->flash('message', [trans('admin/messages.user_account_deleted')]);
            return redirect('/');
        } else {
            return view('new.account.user.delete', [
                'breadcrumbs' => [
                    $user->name => 'user',
                    __('Delete') => ''
                ]
            ]);
        }
    }

    /**
     * Approve gdpr.
     */
    public function gdpr(Request $request)
    {
        $user = Auth::user();
        return view('new.account.user.gdpr', [
            'user' => $user,
        ]);
    }
    /**
     * Approve gdpr.
     */
    public function gdprConfirm(Request $request)
    {
        $user = Auth::user();
        GdprConsent::create(['user_id' => $user->id, 'name' => $user->name]);

        return redirect('/account/user');
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
                __('Change password') => ''
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

        return view('new.account.user.pickups', [
            'user' => $user,
            'breadcrumbs' => [
                $user->name => 'user',
                __('Pickups') => ''
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

        return view('new.account.user.producer-orders', [
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

        return view('new.account.user.order', [
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

        return view('new.account.user.product-orders', [
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

        return view('account.user.membership', [
            'breadcrumbs' => [
                $user->name => 'user',
                trans('admin/user-nav.membership') => '',
            ],
            'members' => $members,
            'averageMembership' => round($averageMembershipPayments)
        ]);
    }

    /**
     * Handle membership callback action.
     */
    public function membershipCallback(Request $request)
    {
        $token = $request->input('stripeToken');
        if (!$token) {
            return response()->json([
                'message' => 'missing_token',
                'section' => null,
            ], 400);
        }

        $amount = $request->input('amount');
        if (!$amount) {
            return response()->json([
                'message' => 'missing_amount',
                'section' => 'amount',
            ], 400);
        }

        $currency = $request->input('currency');
        if (!$currency) {
            return response()->json([
                'message' => 'missing_currency',
                'section' => 'currency',
            ], 400);
        }

        $recurring = $request->input('recurring');
        if (!$recurring) {
            return response()->json([
                'message' => 'missing_recurring',
                'section' => 'recurring',
            ], 400);
        }

        $user = Auth::user();

        if (!$user) {
            // Login
            if ($request->input('user-action') === 'login') {
                if (!$request->input('login-email') || !$request->input('login-password')) {
                    return response()->json([
                        'message' => 'error_login_failed',
                        'section' => 'submit',
                    ], 401);
                } else {
                    $authenticated = Auth::attempt([
                        'email' => $request->input('login-email'),
                        'password' => $request->input('login-password')
                    ]);

                    if ($authenticated) {
                        $user = Auth::user();
                    } else {
                        return response()->json([
                            'message' => 'error_login_failed',
                            'section' => 'submit',
                        ], 401);
                    }
                }
            }

            // Create
            if ($request->input('user-action') === 'signup') {
                if (!$request->input('signup-name') || !$request->input('signup-email') || !$request->input('signup-password')) {
                    return response()->json([
                        'message' => 'error_signup_required_failed',
                        'section' => 'submit',
                    ], 401);
                } else if (!$request->input('signup-gdpr')) {
                    return response()->json([
                        'message' => 'error_signup_gdpr_failed',
                        'section' => 'submit',
                    ], 401);
                } else {
                    $data = [
                        'name' => $request->input('signup-name'),
                        'email' => $request->input('signup-email'),
                        'password' => $request->input('signup-password'),
                        'phone' => $request->input('signup-phone'),
                    ];

                    $user = new User();
                    $userData = $user->sanitize($data);
                    $userData['password'] = \Hash::make($userData['password']);
                    $user->fill($userData);
                    $user->language = $this->getLang();

                    // Default location Röstånga
                    $user->setLocation('56.002490 13.293257');
                    $user->save();

                    GdprConsent::create(['user_id' => $user->id, 'name' => $user->name]);

                    \App\Helpers\SlackHelper::message('notification', $user->name . ' (' . $user->email . ')' . ' signed up as a user through membership payment form.');

                    $this->sendActivationLink($user);

                    Auth::login($user);
                }
            }
        }

        $status = $user->processMembershipPayment($token, $amount, $currency, $recurring);
        $errorKey = null;

        if ($status['error']) {
            return response()->json(trans('admin/messages.user_membership_error'), 400);
        }

        // Save currency to user
        if (!$user->currency) {
            $user->currency = $currency;
            $user->save();
        }

        if ($status['code'] === 'amount_too_small') {
            return response()->json(false, 200);
        } else {
            return response()->json(true, 200);
        }
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
