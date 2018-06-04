<?php

namespace App\Http\Controllers\Api\v1\Users;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Mail;

use App\User\User;
use App\User\PushToken;

class UsersController extends BaseController
{
    public function users(Request $request)
    {
        if ($request->user()->tokenCan('users-read-all')) {
            if ($request->user()->tokenCan('users-read-emails')) {
                return User::all();
            } else {
                return User::exclude(['email'])->get();
            }
        } else {
            return response(['error' => 'unauthorized', 'message' => 'Unauthorized'], 403);
        }
    }

    public function self(Request $request)
    {
        if ($request->user()->tokenCan('users-read-self')) {
            return Auth::guard('api')->user();
        } else {
            return response(['error' => 'unauthorized', 'message' => 'Unauthorized'], 403);
        }
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $user = new User();

        $errors = $user->validate($data);
        if ($errors->isEmpty()) {
            $userData = $user->sanitize($data);
            $userData['password'] = \Hash::make($userData['password']);
            $user->fill($userData);
            $user->language = 'en'; // Todo:

            // Default location Röstånga
            $user->setLocation('56.002490 13.293257');
            $user->save();

            \App\Helpers\SlackHelper::message('notification', $user->name . ' (' . $user->email . ')' . ' signed up as a user.');

            $this->sendActivationLink($user);

            return $user;
        } else {
            return response([
                'error' => 'create_user_failed',
                'message' => join(' ', $errors->all())
            ], 400);
        }
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

            \App\Helpers\SlackHelper::message('error', 'Token ' . $token . ' created for user id ' . $user->id);
        } else {
            \App\Helpers\SlackHelper::message('error', 'Token ' . $token . ' already exists for user id ' . $user->id);
        }

        Mail::send('email.activate-user', ['user' => $user, 'token' => $token], function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject(trans('public/email.activate_your_account'));
        });
    }

    public function update(Request $request)
    {
        $user = User::find($request->input('id'));

        foreach ($request->input('fields') as $key => $value) {
            $user->{$key} = $value;
        }

        $user->save();

        return $user;
    }

    /**
     * Pay membership route
     */
    public function membership(Request $request)
    {
        $user = Auth::user();

        $token = $request->input('stripeToken');
        $amount = $request->input('amount');

        $status = $user->processMembershipPayment($token, $amount);

        if ($status['error']) {
            return response('invalid_amount', 400);
        }

        return User::find($user->id); // Reload user
    }

    public function pushToken(Request $request)
    {
        $user = Auth::user();
        $token = $request->input('token');

        $pushToken = PushToken::where('token', $token)->first();
        if (!$pushToken) {
            $pushToken = new PushToken();
            $pushToken->fill([
                'user_id' => $user->id,
                'token' => $token,
            ]);
            $pushToken->save();
        }
    }
}
