<?php

namespace App\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use App\Mail\ResetPassword as ResetPasswordNotification;

use Mail;
use App\Traits\Excludable;
use App\User\UserMembershipPayment;
use App\User\UserMembershipSubscription;

class User extends \App\User\BaseUser
{
    use Excludable;

    protected $with = ['membershipPaymentsRelationship'];

    protected $appends = ['location'];

    protected $validationRules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:8',
        'address' => '',
        'zip' => '',
        'city' => '',
        'phone' => '',
        'language' => '',
        'currency' => '',
        'active' => '',
        'stripe_customer_id' => '',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'zip',
        'city',
        'phone',
        'language',
        'currency',
        'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Lifecycle events.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($user) {
            if ($user->cartDateItemLinks()->count()) {
                $user->cartDateItemLinks()->each->delete();
            }

            $user->orderDateItemLinks()->each->delete();
            $user->membershipPayments()->each->delete();
            $user->nodeLinks()->each->delete();
            $user->nodeAdminLinks()->each->delete();
            $user->nodeAdminInvites()->each->delete();
            $user->producerAdminLinks()->each->delete();
            $user->images()->each->delete();
        });
    }

    protected function modifyTableColumnsBeforeQuery($tableColumns)
    {
        return $tableColumns;
    }

    /**
     * Get all address fields.
     *
     * @return array
     */
    public function getAddressFields()
    {
        return array_filter($this->attributes, function($value, $key) {
            $addressFields = ['address', 'city', 'zip', 'country'];
            return in_array($key, $addressFields);
        }, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * Custom setter for location.
     *
     * @param string $value
     */
    public function setLocation($value)
    {
        $insertValue = '"POINT(' . $value . ')"';
        $this->attributes['location'] = DB::raw('GeomFromText(' . $insertValue . ')');
    }

    /**
     * Get location.
     */
    public function getLocationAttribute()
    {
        if (isset($this->attributes['location'])) {
            $location = substr($this->attributes['location'], 6);
            $location = substr($location, 0, strpos($location, ')'));
            list($lat, $lng) = explode(' ', $location);

            return ['lat' => $lat, 'lng' => $lng];
        } else {
            return null; // Needs to be null for location by IP address to work
        }
    }

    /**
     * Add location select to query.
     */
    public function newQuery($excludeDeleted = true)
    {
        $raw = 'astext(location) as location';
        return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
    }

    /**
     * Get language name.
     *
     * @return string
     */
    public function getLanguageName()
    {
        if ($this->language) {
            return trans('lang.' . $this->language);
        } else {
            return 'English';
        }
    }

    /**
     * Custom validation rules for update.
     *
     * @param array $data
     * @return array
     */
    public function validateUpdate($data)
    {
        $rules = $this->validationRules;
        $rules['email'] .= ',email,' . $this->id;
        $rules['password'] = '';

        return parent::validate($data, $rules);
    }

    /**
     * Custom validation rules for update password.
     *
     * @param array $data
     * @return array
     */
    public function validateUpdatePassword($data)
    {
        $rules = $this->validationRules;
        $rules['name'] = '';
        $rules['email'] = '';

        return parent::validate($data, $rules);
    }

    /**
     * Get active boolean.
     *
     * @return bool
     */
    public function getActiveAttribute()
    {
        return (bool) $this->attributes['active'];
    }

    /**
     * Define relationship with Gdpr Consent.
     *
     * @return Collection
     */
    public function gdprConsent()
    {
        return $this->hasOne('App\User\GdprConsent')->first();
    }

    /**
     * Cart dates.
     *
     * @param array $dates Filter on dates.
     * @return Collection
     */
    public function cartDates($dates = [])
    {
        $cartDates = $this->hasMany('App\Cart\CartDate');

        if (!empty($dates)) {
            $cartDates->whereIn('date', $dates);
        }

        return $cartDates->get();
    }

    /**
     * Cart items.
     *
     * @param int $productId Filter on product id.
     * @return Collection
     */
    public function cartItems($productId = null, $wheres = [])
    {
        $cartItems = $this->hasMany('App\Cart\CartItem', 'user_id', 'id');

        if ($productId) {
            $cartItems = $cartItems->where('product_id', $productId);
        }

        return $cartItems->get();
    }

    /**
     * Cart items.
     *
     * @param int $productId Filter on product id.
     * @return Collection
     */
    public function cartItem($productId, $nodeId, $variantId = null)
    {
        $cartItems = $this->cartItems($productId)->where('node_id', $nodeId);

        if ($variantId) {
            $cartItems = $cartItems->where('variant_id', $variantId);
        }

        return $cartItems->first();
    }

    /**
     * Define relationship with cart date item link.
     *
     * @return Relationship
     */
    public function cartDateItemLinksRelationship()
    {
        return $this->hasMany('App\Cart\CartDateItemLink');
    }

    /**
     * Get cart date item links.
     *
     * @return Collection
     */
    public function cartDateItemLinks()
    {
        return $this->cartDateItemLinksRelationship;
    }

    /**
     * Get specific cart date item link.
     *
     * @param int $cartDateItemLinkId
     * @return CartDateItemLink
     */
    public function cartDateItemLink($cartDateItemLinkId)
    {
        return $this->cartDateItemLinksRelationship->where('id', $cartDateItemLinkId)->first();
    }

    /**
     * Get order dates.
     *
     * @param array $dates Filter on dates.
     * @return Collection
     */
    public function orderDates($dates = [])
    {
        $orderDates = $this->orderDateItemLinks()->map(function($orderDateItemLink) {
            return $orderDateItemLink->getDate() ?: null;
        })->filter()->unique();

        if (!empty($dates)) {
            $orderDates = $orderDates->whereIn('date', $dates);
        }

        $sortedOrderDates = $orderDates->sortByDesc(function($orderDate, $key) {
            return $orderDate->date('Y-m-d');
        });

        return $sortedOrderDates;
    }

    /**
     * Get next order date.
     *
     * @return OrderDate
     */
    public function getNextOrderDate()
    {
        $orderDates = $this->orderDates();

        $orderDates = $orderDates->filter(function($orderDate) {
            return $orderDate->date >= new \DateTime(date('Y-m-d'));
        });

        return $orderDates->count() > 0 ? $orderDates->last() : null;
    }

    /**
     * Define relationship with order date item links.
     *
     * @return Collection
     */
    public function orderDateItemLinksRelationship()
    {
        return $this->hasMany('App\Order\OrderDateItemLink');
    }

    /**
     * Get order date item links.
     *
     * @return Collection
     */
    public function orderDateItemLinks($producerId = null)
    {
        $orderDateItemLinks = $this->orderDateItemLinksRelationship;

        if ($producerId) {
            $orderDateItemLinks = $orderDateItemLinks->where('producer_id', $producerId);
        }

        return $orderDateItemLinks;
    }

    /**
     * Get specific order date item link.
     *
     * @param int $orderDateItemLinkId
     * @return OrderDateItemLink
     */
    public function orderDateItemLink($orderDateItemLinkId)
    {
        return $this->orderDateItemLinksRelationship->where('id', $orderDateItemLinkId)->first();
    }

    /**
     * Define relationship with membership payments.
     */
    public function membershipPaymentsRelationship()
    {
        return $this->hasMany('App\User\UserMembershipPayment');
    }

    /**
     * Get membership payments.
     */
    public function membershipPayments()
    {
        return $this->membershipPaymentsRelationship->sortByDesc('created_at');
    }

    /**
     * Get latest membership payment.
     *
     * @return UserMembershipPayment
     */
    public function getLatestMembershipPayment($forceCheck = false)
    {
        if ($forceCheck === false && env('APP_DISABLE_MEMBERSHIP', false) === true) {
            return new UserMembershipPayment([
                'amount' => 0,
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ]);
        }

        return $this->membershipPayments()->first();
    }

    /**
     * Define relationship with membership payments.
     */
    public function membershipSubscription()
    {
        return $this->hasOne('App\User\UserMembershipSubscription')->first();
    }

    /**
     * Check if user is a member.
     *
     * Todo: implement
     *
     * @return boolean
     */
    public function isMember($forceCheck = false)
    {
        if ($forceCheck === false && env('APP_DISABLE_MEMBERSHIP', false) === true) {
            return true;
        }

        $lastMembershipPayment = $this->getLatestMembershipPayment($forceCheck);

        if ($lastMembershipPayment) {
            return $lastMembershipPayment->expiresInDays() >= 0 ? true : false;
        }

        return false;
    }

    /**
     * Process payments.
     */
    public function processMembershipPayment($token, $amount, $currency, $recurring = false)
    {
        $successMessage = $this->name . ' (' . $this->email . ')' . ' payed ' . $amount . ' ' . $currency . ' to become a member.';

        try {
            \Stripe\Stripe::setApiKey(config('payment.stripe.live.secret_key'));

            if (!is_numeric($amount)) {
                throw new \Exception(trans('admin/messages.user_membership_amount_not_numeric'));
            }

            // If not a zero decimal currency we multiply by 100
            $adjustedAmount = $amount;
            if (!in_array($currency, config('app.zero_decimal_currencies'))) {
                $adjustedAmount = $amount * 100;
            }

            if ($recurring === 'monthly') {
                $membershipSubscription = $this->membershipSubscription();
                $productId = 'prod_Dlg5pEcdYz4TbL'; // Manually created, should only exist one

                // Retreive or create customer
                $customer = null;
                if ($membershipSubscription && $membershipSubscription->customer_id) {
                    $customer = \Stripe\Customer::retrieve($membershipSubscription->customer_id);
                }

                if (!$customer) {
                    $customer = \Stripe\Customer::create([
                        'email' => $this->email,
                        'source'  => $token
                    ]);
                }

                // Retreive or create plan
                $plan = null;
                if ($membershipSubscription && $membershipSubscription->plan_id) {
                    $plan = \Stripe\Plan::retrieve($membershipSubscription->plan_id);
                }

                if (!$plan) {
                    $plan = \Stripe\Plan::create([
                        'currency' => $currency,
                        'interval' => 'month',
                        'product' => $productId,
                        'nickname' => 'Monthly membership',
                        'amount' => $adjustedAmount,
                    ]);
                }

                // Retreive or create subscription
                $subscription = null;
                if ($membershipSubscription && $membershipSubscription->subscription_id) {
                    $subscription = \Stripe\Subscription::retrieve($membershipSubscription->subscription_id);
                }

                if (!$subscription) {
                    $subscription = \Stripe\Subscription::create([
                        'customer' => $customer->id,
                        'items' => [['plan' => $plan->id]],
                    ]);
                }

                if (!$membershipSubscription) {
                    // Create membership subscription record
                    UserMembershipSubscription::create([
                        'user_id' => $this->id,
                        'customer_id' => $customer->id,
                        'product_id' => $productId,
                        'plan_id' => $plan->id,
                        'subscription_id' => $subscription->id,
                    ]);
                }
            } else {
                // Create one time charge
                \Stripe\Charge::create([
                    'amount' => (int) $adjustedAmount,
                    'currency' => $currency,
                    'source' => $token,
                    'description' => $this->name
                ]);
            }

            UserMembershipPayment::create([
                'user_id' => $this->id,
                'amount' => $adjustedAmount,
                'currency' => $currency,
            ]);

            \App\Helpers\SlackHelper::message('notification', $successMessage);

            return ['error' => false, 'code' => null];
        } catch (\Stripe\Error\Base $e) {
            $error = $e->getJsonBody();
            $errorCode = $error['error']['code'];

            if ($errorCode === 'amount_too_small') {
                // Create a payment even if payment was too small
                UserMembershipPayment::create([
                    'user_id' => $this->id,
                    'amount' => $adjustedAmount,
                    'currency' => $currency,
                ]);

                \App\Helpers\SlackHelper::message('notification', $successMessage);

                return [
                    'error' => false,
                    'code' => $errorCode
                ];
            }

            return [
                'error' => true,
                'code' => $errorCode,
            ];
        } catch (\Exception $e) {
            \App\Helpers\SlackHelper::message('error', 'Stripe error: ' . $e->getMessage());

            return [
                'error' => true,
                'code' => 'stripe_error_unknown_php',
            ];
        }
    }

    /**
     * Define user relationship with node links.
     */
    public function nodeLinkRelationship()
    {
        return $this->hasMany('App\User\UserNodeLink');
    }

    /**
     * Node links.
     *
     * @return Collection
     */
    public function nodeLinks()
    {
        return $this->nodeLinkRelationship()->get();
    }

    /**
     * Nodes that the user follows.
     *
     * @return Collection
     */
    public function nodes()
    {
        return $this->nodeLinkRelationship()->get()->map(function($nodeLink) {
            $node = $nodeLink->getNode();

            return $node->is_hidden ? null : $node;
        })->filter();
    }

    /**
     * Check if user is added to node.
     *
     * @param int $nodeId
     * @return boolean
     */
    public function isAddedToNode($nodeId)
    {
        $userNodeLink = $this->nodeLinkRelationship()->where('node_id', $nodeId);
        return $userNodeLink->count() === 1 ? true : false;
    }

    /**
     * Override laravel default reset password email.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        Mail::send('email.reset-password', ['token' => $token], function($message) {
            $message->to($this->email)->subject('Reset password');
        });
    }

    /**
     * Define user relationship with nodes admin links.
     */
    public function nodeAdminLinksRelationship()
    {
        return $this->hasMany('App\Node\NodeAdminLink');
    }

    /**
     * Get nodes admin links.
     */
    public function nodeAdminLinks()
    {
        return $this->nodeAdminLinksRelationship->where('active', 1);
    }

    /**
     * Get a specific node link.
     *
     * @param int $nodeId
     */
    public function nodeAdminLink($nodeId)
    {
        return $this->nodeAdminLinks()->where('node_id', $nodeId)->first();
    }

    /**
     * Node admin invites.
     *
     * @return Collection
     */
    public function nodeAdminInvites()
    {
        return $this->nodeAdminLinksRelationship->where('active', 0);
    }

    /**
     * Node admin invites.
     *
     * @return Collection
     */
    public function nodeAdminInvite($nodeId)
    {
        return $this->nodeAdminInvites()->where('node_id', $nodeId)->first();
    }

    /**
     * Get producer admin links.
     */
    public function producerAdminLinks()
    {
        return $this->hasMany('App\Producer\ProducerAdminLink')->get();
    }

    /**
     * Get a specific producer link.
     *
     * @param int $producerId
     */
    public function producerAdminLink($producerId)
    {
        return $this->producerAdminLinks()->where('producer_id', $producerId)->first();
    }

    /**
     * Producer admin invites.
     *
     * @return Collection
     */
    public function producerAdminInvites()
    {
        $producerAdminInvites = $this->producerAdminLinks()->filter(function($producerAdminLink) {
            return $producerAdminLink->active === 0 ? true : false;
        })->all();

        return collect($producerAdminInvites);
    }

    /**
     * Get images.
     */
    public function images()
    {
        $images = $this->hasMany('App\Image\Image', 'entity_id')->where('entity_type', 'user')->get();

        return collect($images->sortBy('sort')->all());
    }

    /**
     * Get specific image.
     * @param int $imageId
     * @return Image
     */
    public function image($imageId)
    {
        return $this->images()->where('id', $imageId)->first();
    }

    /**
     * Get info to be stored with order.
     *
     * @return array
     */
    public function getInfoForOrder()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'zip' => $this->zip,
            'city' => $this->city,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }

    /**
     * Define user relationship with push token.
     */
    public function pushTokenRelationship()
    {
        return $this->hasMany('App\User\PushToken');
    }

    /**
     * Get push token.
     */
    public function getPushTokens()
    {
        $pushTokens = $this->pushTokenRelationship;

        return $pushTokens->map(function($pushToken) {
            return $pushToken->token;
        });
    }

    /**
     * Define user relationship with notifications.
     */
    public function notificationsRelationship()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Get notifications
     */
    public function notifications()
    {
        return $this->notificationsRelationship;
    }
}
