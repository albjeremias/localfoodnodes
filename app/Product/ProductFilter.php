<?php

namespace App\Product;

use Illuminate\Support\Collection;
use App\Product\ProductNodeDeliveryLink;

class ProductFilter
{
    /**
     * @var Collection
     */
    private $products;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var string
     */
    private $date;

    /**
     * Constructor.
     *
     * @param Collection $products
     * @param Request $request
     */
    public function __construct($products, $request)
    {
        $this->products = $products;
        $this->request = $request;
        $this->date = $request->has('date') ? $request->get('date') : date('Y-m-d');
    }

    /**
     * All available product tags.
     *
     * @return array
     */
    public static function tags() {
        return collect([
            trans('public/tags.beverage'),
            trans('public/tags.cheese'),
            trans('public/tags.dairy'),
            trans('public/tags.eggs'),
            trans('public/tags.fish'),
            trans('public/tags.fruit_berries'),
            trans('public/tags.jam_marmelade'),
            trans('public/tags.meat'),
            trans('public/tags.mushroom'),
            trans('public/tags.poultry'),
            trans('public/tags.vegetable'),
        ])->sort();
    }

    /**
     * Filter products on date.
     *
     * @return ProductFilter
     */
    public function filterDate()
    {
        if ($this->request->has('date')) {
            $date = $this->request->get('date');
            $prodId = ProductNodeDeliveryLink::where('date', $date)->get()->map->product_id;
            $this->products = $this->products->whereIn('id', $prodId);
        }

        return $this;
    }

    /**
     * Filter produts on tags.
     *
     * @return ProductFilter
     */
    public function filterTags()
    {
        $selectedTags = $this->getSelectedTags();
        if ($selectedTags->count() > 0) {
            $this->products = $this->products->whereIn('id', ProductTag::whereIn('tag', $selectedTags)->get()->map->product_id);
        }

        return $this;
    }

    /**
     * Return filter date.
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Return filter month.
     *
     * @return string
     */
    public function getMonthDate()
    {
        return date('Y-m-01', strtotime($this->date));
    }

    /**
     * Get filtered products.
     *
     * @return [type] [description]
     */
    public function get()
    {
        return $this->products;
    }

    /**
     * Get all tags with additional filter data from request.
     *
     * @param Request $request
     * @return Collection
     */
    public function getTagFilter($request)
    {
        $tags = new Collection();

        foreach (self::tags() as $tag) {
            // In loop to it's resetted for every tag
            $selectedTags = $this->getSelectedTags($request);

            if ($selectedTags->contains($tag)) {
                $active = true;
                $selectedTags = $selectedTags->reject(function ($t) use ($tag) {
                    return $t === $tag;
                });
            } else {
                $active = false;
                $selectedTags->push($tag);
            }

            $url = $this->buildQuery('tag', $selectedTags->implode(','));

            $tags->put($tag, [
                'active' => $active,
                'url' => '?' . $url
            ]);
        }

        return $tags;
    }

    /**
     * Get selected tags from request.
     *
     * @param Request $request
     * @return Collection
     */
    private function getSelectedTags($request = null)
    {
        if (!$request && !$this->request) {
            return new Collection();
        }

        if (!$request) {
            $request = $this->request;
        }

        return $request->has('tag') ? collect(explode(',', $request->get('tag'))) : new Collection();
    }

    /**
     * Get query parts.
     *
     * @param string $resetKey
     * @return sting
     */
    private function getQueryParts($resetKey)
    {
        $queryString = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : null;

        $query = [];
        if ($queryString) {
            $queryParts = explode('&', $queryString);

            foreach ($queryParts as $part) {
                if (strpos($part, '=')) {
                    list($key, $value) = explode('=', $part);
                    $query[$key] = $value;
                }
            }

            if (isset($query[$resetKey])) {
                unset($query[$resetKey]);
            }
        }

        return $query;
    }

    /**
     * Build query.
     *
     * @param string $key
     * @param string $param
     * @return string
     */
    private function buildQuery($key, $param)
    {
        $queryParts = $this->getQueryParts($key);

        if (!empty($param)) {
            $queryParts[$key] = $param;
        }

        return http_build_query($queryParts);
    }
}