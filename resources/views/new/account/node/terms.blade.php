@include('new.components.progress',
[
    'active' => 0,
    'steps'  =>
        [
            __('Terms'),
            __('Create'),
            __('Pickup dates'),
            __('Invite'),
            __('Finish'),
        ]
])

<div class="bg-accent-light-24">
    <div class="container py-5">
        <div class="row pb-5 terms_intro">
            <div class="col-xl-8">
                {{ __('Great! You want to start a Local Food Node. But first, read these simple terms of running av
                node, and make sure you fully understand them. Then hit agree, and you are good to go.')  }}
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-5 terms_text">
        <div class="col-md-8">
            <h2>{{ __('Location Permits') }}</h2>
            <p>{{ __('I understand that I have to have all legal permits required for the physical spot I have chosen for
            the local food node. When starting a node it is my responsibility as node admin to find out if any legal
            permits are needed for the physical location and acquiring those if needed. If a physical location is used
            on the site as a node without required permits, it is I in the role of the node admin that has the sole
            legal responsibility for this.The platform, Local Food Nodes, takes no legal responsibility for any physical
            location used as a node on the site or any legal responsibility to require or validate permits that might be
            needed for physical locations connected to the nodes on the site.') }}</p>

            <h2>{{ __('Deliveries') }}</h2>
            <p>{{ __('The Platform, Local Food Nodes, does not sell any goods. You, in the role of the node admin, does not
            sell any goods. You, in the role of the node admin, do not have any responsibility for the products being
            delivered at the node that you administrate. All food must be delivered straight from the producers to the
            consumers. During deliveries at the nodes, producers may only deliver the pre-booked goods and can not sell
            additional products unless permission i acquired for direct sales at that location.') }}</p>

            <h2>{{ __('Financial terms') }}</h2>
            <p>{{ __('Its free for all producer to join your node. You may never charge any producer for their
            participation on the platform or for handing out their products at any delivery occasion. You may never take
            a cut of what is sold or delivered on the node. Violations of these terms may exclude you from being a node
            admin, and in worst case have your node removed.') }}</p>
        </div>
        <div class="d-flex w-100">
            <a class="btn btn-primary" href="#">{{ __('Cancel') }}</a>
            <a class="btn btn-secondary ml-auto" href="/account/node/create?terms=approved">{{ __('Accept') }}</a>
        </div>
    </div>
</div>
