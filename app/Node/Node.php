<?php

namespace App\Node;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

use App\BaseModel;
use App\Node\NodeDeliveryDate;

use DateTime;

class Node extends BaseModel
{
    protected $appends = ['location'];

    protected $with = ['permalinkRelationship', 'imageRelationship'];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'name' => 'required',
        'info' => 'required',
        'address' => 'required',
        'zip' => 'required',
        'city' => 'required',
        'email' => 'required',
        'delivery_interval' => 'required|string',
        'delivery_weekday' => 'required',
        'delivery_startdate' => 'required',
        'delivery_time' => 'required',
        'link_facebook' => '',
        'link_facebook_producers' => '',
        'is_hidden' => '',
    ];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name',
        'info',
        'address',
        'zip',
        'city',
        'email',
        'delivery_interval',
        'delivery_weekday',
        'delivery_startdate',
        'delivery_time',
        'link_facebook',
        'link_facebook_producers',
        'is_hidden',
    ];

    /**
     * Node delivery intervals
     * @var array
     */
    public $intervals = [
        'week_1' => '+1 weeks',
        'week_2' => '+2 weeks',
        'week_3' => '+3 weeks',
        'week_4' => '+4 weeks',
        'month_1' => '+1 month',
    ];

    /**
     * Lifecycle events.
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($node) {
            $node->adminLinks()->each->delete();
            $node->userLinks()->each->delete();
            $node->producerLinks()->each->delete();
            $node->images()->each->delete();
            $node->permalink()->delete();
        });

        static::created(function($node) {
            \App\Permalink::create(['entity_type' => 'node', 'entity_id' => $node->id, 'slug' => $node->name]);
        });

        static::updated(function($node) {
            $permalink = $node->permalink();
            $permalink->slug = $node->name;
            $permalink->save();
        });
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
     * Set location.
     *
     * @param string $value
     */
    public function setLocation($value)
    {
        $insertValue = '"POINT(' . $value . ')"';
        $this->attributes['location'] = DB::raw('GeomFromText(' . $insertValue . ')');
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
     * Get location.
     */
    public function getLocationAttribute()
    {
        if (isset($this->attributes['location'])) {
            $location = substr($this->attributes['location'], 6);
            $location = substr($location, 0, strpos($location, ')'));
            list ($lat, $lng) = explode(' ', $location);

            return ['lat' => $lat, 'lng' => $lng];
        }
    }

    /**
     * Get node admin links.
     *
     * @return Collection
     */
    public function adminLinks()
    {
        return $this->hasMany('App\Node\NodeAdminLink')->where('active', 1)->get();
    }

    /**
     * Get node admin invites.
     *
     * @return Collection
     */
    public function adminInvites()
    {
        return $this->hasMany('App\Node\NodeAdminLink')->where('active', 0)->get();
    }

    /**
     * Define producer link relationship.
     *
     * @return Collection
     */
    public function producerLinksRelationship()
    {
        return $this->hasMany('App\Producer\ProducerNodeLink');
    }

    /**
     * Get producer links.
     */
    public function producerLinks()
    {
        return $this->producerLinksRelationship;
    }

    /**
     * Return number of producers connected to this node.
     *
     * @return int
     */
    public function producerCount()
    {
        return $this->producerLinks()->count();
    }

    /**
     * Get user links.
     */
    public function userLinks()
    {
        return $this->hasMany('App\User\UserNodeLink')->get();
    }

    /**
     * Define relationship with permalink.
     */
    public function permalinkRelationship()
    {
        return $this->hasOne('App\Permalink', 'entity_id')->where('entity_type', 'node')->orderBy('id');
    }

    /**
     * Get permalink.
     */
    public function permalink()
    {
        return $this->permalinkRelationship()->first();
    }

    /**
     * Define relationship with images.
     */
    public function imageRelationship()
    {
        return $this->hasMany('App\Image\Image', 'entity_id')->where('entity_type', 'node');
    }

    /**
     * Get images.
     */
    public function images()
    {
        return $this->imageRelationship()->get()->sortBy('sort');
    }

    /**
     * Get specific image.
     *
     * @param int $imageId
     * @return Image
     */
    public function image($imageId)
    {
        return $this->images()->where('id', $imageId)->first();
    }

    /**
     * Define node relationship with product delivery dates.
     */
    public function productNodeDeliveryLinksRelationship()
    {
        return $this->hasMany('App\Product\ProductNodeDeliveryLink');
    }

    /**
     * Get product node delivery links.
     *
     * @return Collection
     */
    public function productNodeDeliveryLinks() {
        return $this->productNodeDeliveryLinksRelationship;
    }

    /**
     * Get products.
     *
     * @return Collection
     */
    public function products()
    {
        $products = $this->productNodeDeliveryLinksRelationship->map(function($productNodeDeliveryLink) {
            return $productNodeDeliveryLink->getProduct();
        });

        if (!$products->isEmpty()) {
            return $products->unique('id')->filter();
        }

        return new Collection();
    }

    /**
     * Load relationship and other data form map ajax responses.
     */
    // public function loadMapData()
    // {
    //     $this->permalink = $this->permalink();

    //     return $this;
    // }

    /**
     * Get all delivery dates where there are products.
     *
     * @return Collection
     */
    public function getDeliveryDatesWithProducts()
    {
        $dates = DB::table('product_node_delivery_links')->distinct()->select('date')->where('node_id', $this->id)->where('date', '>=', date('Y-m-d'))->get();

        $dates = $dates->map(function($date) {
            return $date->date;
        });

        return $dates->unique()->sort();
    }

    /**
     * Get delivery dates for the next 52 weeks.
     *
     * @return Collection
     */
    public function getDeliveryDates($product = null)
    {
        $deliveryDates = new Collection();
        $nextDelivery = $this->getNextDelivery($product);
        $endDelivery = new \DateTime($nextDelivery->format('Y-m-d'));
        $endDelivery->modify('+3 months');
        $deliveryInterval = $this->delivery_interval;

        // Month intervals needs some modification
        if ($this->delivery_interval === '+1 month') {
            $weekOfMonth = $this->weekOfMonth($this->delivery_startdate);
            $deliveryInterval = $weekOfMonth . ' ' . $this->delivery_weekday . ' of next month';
        }

        $interval = \DateInterval::createFromDateString($deliveryInterval);
        $period = new \DatePeriod($nextDelivery, $interval, $endDelivery);

        foreach ($period as $date) {
            $deliveryDates->push($date->format('Y-m-d'));
        }

        return $deliveryDates->sort();
    }

    /**
     * Get delivery dates by months.
     *
     * @return Collection
     */
    public function getDeliveryDatesByMonths($product = null)
    {
        return collect($this->getDeliveryDates($product)->groupBy(function($date) {
            return (int) date('Ym01', strtotime($date));
        }));
    }

    /**
     * Get next delivery date.
     *
     * @return Date
     */
    public function getNextDelivery($product = null)
    {
        $firstDate = $this->getFirstDeliveryDate();

        $firstProductionDate = null;
        if ($product && $product->production_type === 'occasional') {
            $firstProductionDate = $product->productions()->first()->date;
        }

        if ($firstProductionDate && $firstProductionDate > $firstDate) {
            while ($firstProductionDate > $firstDate) {
                $firstDate->modify($this->delivery_interval);
            }
        }

        return $firstDate;
    }

    /**
     * Recursive function that finds the first delivery with regard to current date or start date and product deadline.
     *
     * @param Product $product
     * @param DateTime $currentDate used in loop
     * @return DateTime
     */
    private function getFirstDeliveryDate()
    {
        $today = new \DateTime(date('Y-m-d'));
        $firstDeliveryDate = $this->delivery_startdate->modify('this ' . $this->delivery_weekday); // Make sure it's the correct weekday

        // If first date is in the future just return it.
        if ($today <= $firstDeliveryDate) {
            return $firstDeliveryDate;
        }

        // If the first date is in the past, calculate the closest date based on the first date and the delivery interval
        while ($today >= $firstDeliveryDate) {
            if ($this->delivery_interval === '+1 month') {
                $deliveryInterval = $this->getDeliveryIntervalFormat() . 'next month';
            } else {
                $deliveryInterval = $this->getDeliveryIntervalFormat() . ' ' . $firstDeliveryDate->format('Y-m-d');
            }

            $firstDeliveryDate->modify($deliveryInterval);
        }

        return $firstDeliveryDate;
    }

    /**
     * Get delivery interval.
     * Current date needed for looping to work (moving date forward).
     *
     * @return string
     */
    private function getDeliveryIntervalFormat() {
        if ($this->hasWeeklyDeliveries()) {
            $deliveryInterval = $this->delivery_interval;
        } else {
            $weekOfMonth = $this->weekOfMonth($this->delivery_startdate);
            $deliveryInterval = $weekOfMonth . ' ' . $this->delivery_weekday . ' of';
        }

        return $deliveryInterval;
    }

    /**
     * Get week number of month
     * @param DateTime $date
     * @param Boolean $asInt
     * @return string|int
     */
    private function weekOfMonth(\DateTime $date, $asInt = false) {
        $firstOfMonth = strtotime(date('Y-m-01', $date->getTimestamp()));
        $lastOfMonth = strtotime(date('Y-m-t', $date->getTimestamp()));
        $numberOfWeeksForMonth = intval(date('W', $lastOfMonth)) - intval(date('W', $firstOfMonth)) + 1;

        $week = intval(date('W', $date->getTimestamp())) - intval(date('W', $firstOfMonth)) + 1; // Starts at 1

        if ($asInt) {
            return $week;
        }

        $formats = [
            '1' => 'first',
            '2' => 'second',
            '3' => 'third',
            '4' => 'fourth',
            '5' => 'fifth',
            '6' => 'last'
        ];

        // Make sure every index that is equal or larger
        // than $numberOfWeeksForMonth is 'last'.

        return $formats[$week];
    }

    /**
     * Check if node deliveries have a weekly interval.
     * @return boolean
     */
    private function hasWeeklyDeliveries() {
        return strpos($this->delivery_interval, 'week');
    }

    /**
     * Check if node deliveries have a monthly interval.
     *
     * @return boolean
     */
    private function hasMonthlyDeliveries() {
        return strpos($this->delivery_interval, 'month');
    }

    /**
     * Get distance to provided coordinates.
     *
     * @param float $lat
     * @param float $lng
     * @return float
     */
    public function distance($lat, $lng)
    {
        return 6371 * acos(
            cos(deg2rad($this->location['lat']))
            * cos(deg2rad($lat))
            * cos(deg2rad($lng) - deg2rad($this->location['lng']))
            + sin(deg2rad($this->location['lat']))
            * sin(deg2rad($lat))
        );
    }

    /**
     * Get average producer distance.
     *
     * @return int
     */
    public function getAverageProducerDistance()
    {
        if ($this->producerLinks()->count() <= 0) {
            return 0;
        }

        $averageProducerDistance = $this->producerLinks()->map(function($producerLink)  {
            $distance = $this->distance($producerLink->getProducer()->location['lat'], $producerLink->getProducer()->location['lng']);
            return $distance;
        })->sum();

        return round($averageProducerDistance / $this->producerLinks()->count(), 1);
    }

    /**
     * Format facebook link.
     *
     * @param string $value
     * @return string
     */
    public function getLinkFacebookAttribute($value)
    {
        if ($value && $value !== 'http://') {
            return strpos($value, 'http') === 0 ? $value : 'http://' . $value;
        }
    }

    /**
     * Format facebook link.
     *
     * @param string $value
     * @return string
     */
    public function getLinkFacebookProducersAttribute($value)
    {
        if ($value && $value !== 'http://') {
            return strpos($value, 'http') === 0 ? $value : 'http://' . $value;
        }
    }

    /**
     * Return start date object. Add weekday so startdate is always the correct weekday
     *
     * @param string $value
     * @return Date
     */
    public function getDeliveryStartdateAttribute($value)
    {
        if (!$value) {
            $value = date('Y-m-d', strtotime($this->delivery_interval));
        }

        return $value ? new DateTime($value) : new DateTime(date('Y-m-d', time()));
    }

    /**
     * Return interval.
     *
     * @param string $value
     * @return Date
     */
    public function getDeliveryIntervalAttribute($value)
    {
        return $value ?: '+1 weeks'; // Fallback to +1 weeks interval
    }

    /**
     * Get delivery interval as string
     *
     * @return string
     */
    public function getDeliveryIntervalAsString()
    {
        $deliveryInterval = array_search($this->delivery_interval, $this->intervals);

        return strtolower(trans('admin/node.' . $deliveryInterval));
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
            'delivery_time' => $this->delivery_time,
            'delivery_weekday' => $this->delivery_weekday,
            'delivery_startdate' => $this->delivery_startdate,
            'delivery_interval' => $this->delivery_interval,
        ];
    }
}
