@include('new.components.progress',
[
    'active' => 0,
    'steps'  =>
        [
            __('Read terms'),
            __('Create account'),
            __('Sale channels'),
            __('Create products')
        ]
])

<div class="bg-accent-light-24">
    <div class="container py-5">
        <div class="row pb-5 terms_intro">
            <div class="col-xl-8">
                {{ __('Whoop, we salute you great food producer, saviours of the world. Before setting up your producer account you need to read and agree to these terms of use. Make sure you fully understand them. Then hit agree and you are set to go.') }}
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-5 terms_text">
        <div class="col-md-8">
            <h2>{{ __('General') }}</h2>
            <p>{{ __('It is always free to use Local Food nodes as producer. You will and shall never pay any kind of fee to anybody to be at any delivery occasion, or any fee for selling any of your product. If this is required of you at any time, contact us immediately.') }}</p>

            <h2>{{ __('Products') }}</h2>
            <p>{{ __('Node admin and/or Local Food Nodes are not a selling part. Me as producer and only me am always the selling part of my product.') }}</p>
            <p>{{ __('Me as a producer have the full responsibility for my product. This means all the way from how it is produced, what it contains, and that it is correct declared and marked.') }}</p>
            <p>{{ __('It\'s me as producer that has the full responsibility that my product is transported and delivered in a safe and legal way before handed over to the consumer.') }}</p>
            <p>{{ __('It\'s my responsibility as producer to know my domestic laws regarding food production, and what laws there are around my product regarding producing and selling to end consumer.') }}</p>

            <h2>{{ __('Delivery') }}</h2>
            <p>{{ __('My product may never be delivered to a third part before handed out to end consumers. If necessary, you can make an agreement with the customer that you leave the product for him/her to pick up later on. This goes only for product that is not needed to keep a certain temperature before delivery.') }}</p>
            <p>{{ __('I may only deliver products that has been pre-booked for the delivery occasion.') }}</p>
            <p>{{ __('I may not sell any additional products that has not been pre-booked before delivery. In case of the delivery spot has a permit that allowes additional sales, you may sell additional products that has not been pre-booked in advance. Check out with the node admin if so.') }}</p>
            <p>{{ __('I as producer have the full responsibility to administrate my orders for my products, and to make sure I show up, and that pre-ordered products are delivered to the right persons at the right occasions.') }}</p>

            <h2>{{ __('Payments') }}</h2>
            <p>{{ __('It\'s my responsibility as producer to know what ways are legal to charge for my products') }}</p>
            <p>{{ __('It\'s my responsibility as producer to make sure my products is payed for, in the way that suits my best.') }}</p>
            <p>{{ __('It\'s my responsibility as producer to make sure I keep needed receipts and that all my transactions are accounted for.') }}</p>
            <p>{{ __('It\'s my responsibility as producer that I follow domestic laws when it comes to sales, declaration and taxes regarding my selling.') }}</p>
            <p>{{ __('It\'s my responsibility to know what legal terms I have to follow regarding sales of my products.') }}</p>
        </div>
        <div class="col-md-8">
            {{ __('') }}
        </div>

        <div class="col text-right my-5">
            <a class="rc text-uppercase mr-4" href="#">{{ __('Cancel') }}</a>
            <a class="btn btn-secondary" href="/account/producer/create?terms=approved">{{ __('Accept') }}</a>
        </div>
    </div>
</div>
