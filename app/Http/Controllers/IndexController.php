<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

use App\Http\Requests;
use App\Permalink;
use App\Node\Node;
use App\User\User;
use App\User\UserMembershipPayment;
use App\Producer\Producer;
use App\Producer\ProducerNodeLink;
use App\Product\Product;
use App\Product\ProductNodeDeliveryLink;

use App\Product\ProductFilter;

use DateTime;

class IndexController extends Controller
{
    /**
     * Show all nodes
     */
    public function index(Request $request)
    {
        $metrics = $this->getFrontpageMetrics();

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

        return view('new.public.index', [
            'metrics' => $metrics,
            'members' => $members,
            'averageMembership' => round($averageMembershipPayments)
        ]);
    }

    /**
     * Show content of a node and connected producers
     */
    public function node(Request $request, $slug)
    {
        $nodeId = Permalink::where('slug', $slug)->where('entity_type', 'node')->get()->pluck('entity_id');
        $node = Node::where('id', $nodeId)->with('producerLinksRelationship', 'productNodeDeliveryLinksRelationship')->first();

        if ($node->is_hidden) {
            $request->session()->flash('message', [
                trans('admin/messages.node_doesnt_exist')
            ]);

            return redirect('/');
        }

        $producer = $node->producerLinks()->map->getProducer();
        $products = $node->products();

        $productFilter = new ProductFilter($products, $request);
        $filteredProducts = $productFilter->filterDate($nodeId)->filterTags()->filterVisibility()->get();

        $date = null;
        if ($request->has('date')) {
            $date = new \DateTime($request->get('date'));
        }

        $shareMeta = [
            'shareUrl' => $this->shareUrl($node->permalink()->url),
            'shareTitle' => trim($node->name),
            'shareDescription' => trim(strip_tags($node->info)),
            'shareImage' => $node->images()->count() > 0 ? $node->images()->first()->url('small') : null
        ];

        return view('new.public.node.node', [
            'node' => $node,
            'products' => $filteredProducts->sortBy('name')->values(),
            'date' => $date,
            'tags' => $productFilter->getTagFilter($request),
        ] + $shareMeta);
    }

    /**
     * Node product action.
     */
    public function nodeProduct(Request $request, $nodeId, $productId)
    {
        $node = Node::find($nodeId);
        $product = Product::where('id', $productId)->with('productionsRelationship')->first();

        $producer = Producer::where('id', $product->producer_id)->first();

        $shareMeta = [
            'shareUrl' => $this->shareUrl($node->permalink()->url, $product->permalink()->url),
            'shareTitle' => trim($product->name),
            'shareDescription' => trim(strip_tags($product->info)),
            'shareImage' => $product->images()->count() > 0 ? $product->images()->first()->url('small') : null
        ];

        return view('public.product.product', [
            'node' => $node,
            'product' => $product,
            'producer' => $producer
        ] + $shareMeta);
    }

    /**
     * Producer action.
     */
    public function producer(Request $request, $id)
    {
        $producer = Producer::find($id);

        $shareMeta = [
            'shareUrl' => $this->shareUrl($producer->permalink()->url),
            'shareTitle' => trim($producer->name),
            'shareDescription' => trim(strip_tags($producer->info)),
            'shareImage' => $producer->images()->count() > 0 ? $producer->images()->first()->url('small') : null
        ];

        return view('public.producer.producer', [
            'producer' => $producer,
        ] + $shareMeta);
    }

    /**
     * Producer product action.
     */
    public function producerProduct(Request $request, $producerId, $productId)
    {
        $producer = Producer::find($producerId);
        $product = Product::where('id', $productId)->with('productionsRelationship')->first();

        $shareMeta = [
            'shareUrl' => $this->shareUrl($producer->permalink()->url, $product->permalink()->url),
            'shareTitle' => trim($product->name),
            'shareDescription' => trim(strip_tags($product->info)),
            'shareImage' => $product->images()->count() > 0 ? $product->images()->first()->url('small') : null
        ];

        return view('public.product.product', [
            'product' => $product,
            'producer' => $producer
        ] + $shareMeta);
    }

    /**
     * Get frontpage metrics.
     *
     * @return array
     */
    private function getFrontpageMetrics()
    {
        return [
            'userCount' => User::all()->count(),
            'producerCount' => Producer::all()->count(),
            'nodeCount' => Node::all()->count(),
        ];
    }

    public function findOutMore()
    {
        return view('public.pages.find-out-more');
    }

    /**
     * Get share url with language.
     *
     * @param string $firstUrl
     * @param string $secondUrl
     * @return string
     */
    private function shareUrl($firstUrl, $secondUrl = null)
    {
        $shareUrl = $firstUrl;

        if ($secondUrl) {
            $shareUrl .= $secondUrl;
        }

        $shareUrl .= '?lang=' . $this->getLang();

        return app('url')->to($shareUrl);
    }
}
