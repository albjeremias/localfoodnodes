@extends('new.account.layout',
[
    'bread_type'   => __('User'),
    'bread_result' => __('Approve privacy policy'),
    'nav_active'   => 0
])

@section('title', __('Create node'))

<div class="bg-accent-light-24">
    <div class="container py-5">
        <div class="row pb-5 terms_intro">
            <div class="col-xl-8">
                <h2>{{ __('GDPR Policy')  }}</h2>
                <p>{{ __('
                    It\'s important for us that you feel safe with us handling your personal information, that\'s why we are transparent with what information we collect and how we use it. We never sell your information to third parties.
                    Personal information is all the information that can be used to identify a person, like name, email, IP address and orders.
                    We always makes sure your information is safe with us. On this page we describe what information we save and why. Your information is stored until you change or delete them or delete your account.
                ') }}</p>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row my-5 terms_text">
        <div class="col-md-8">
            <h2>This is what we store</h2>
            <p>This is the information connected to your user account:</p>

            <h3>Email</h3>
            <p>Necessary to create an account on localfoodnodes.org. It's used a unique identifier for your account, for order confirmations, and communication from your nodes and producers as well as from us. We don't send markering emails.</p>

            <h3>Password</h3>
            <p>Necessary to create an account on localfoodnodes.org. Your password is stored encrypted in our database.</p>

            <h3>Name</h3>
            <p>We ask for your name to help make the producers and node admins work a bit easier so they can identidy you when you place and order, but you are free to use an alias if you like</p>

            <h3>Phone number</h3>
            <p>Optional. Phone numbers have been requested by producers and node admins as a way to get in contact with you before a delivery, or if there's a problem with your product.</p>

            <h3>Street name, zip and city</h3>
            <p>Optional. Your address is used by our maps to show delivery locations near you.</p>

            <h3>Photo</h3>
            <p>Optional. Make your profile more personal so producers and node admins know who you are. This is not implemented at the moment.</p>

            <p>You can change information or delete your account whenever you like directly from the site.</p>

            <h2>Data Protection Representative</h2>
            Local Food Nodes - David Ajnered - info@localfoodnodes.org
        </div>
        <div class="col-md-8">
            <h2>External services</h2>

            <h3>Digital Ocean</h3>
            <p>We run our web servers and databases on digitalocean.com.</p>

            <h3>Google Analytics</h3>
            <p>We use Google Analytics to get som statistics about page views and what devices are used. It's used by us to improve localfoodnodes.org and your experience of the site. We do not collect your IP address.</p>

            <h3>Sentry</h3>
            <p>Sentry collects error logs from the site, so when something crashes we get an email. It's possible that personal information is included in the error. We are only interested in solving the bugs. An error is stored for 30 days.</p>

            <h3>Amazon S3</h3>
            <p>Uploaded images are stored on S3 to relieve our web server. They are stored there until you delete them form the site or delete your account.</p>

            <h3>MailChimp</h3>
            <p>On some occations we have to communicate with you about updated policies or other important issues. We send our emails with MailChimp. You can unsubscribe from these emails by clicking the link at the bottom of the email, but we might have to re-add you so you get the important information you need. We will look over this routine in the future. We never send marketing emails.</p>

            <h3>Stripe</h3>
            <p>Payments are processed by Stripe and they collect your name and card information.</p>
        </div>

        <div class="col text-right my-5">
            <a class="rc text-uppercase mr-4" href="{{ route('en_account_user_delete') }}">{{ __('Delete account') }}</a>
            <a class="btn btn-secondary" href="{{ route('account_user_gdpr_confirm') }}">{{ __('Accept') }}</a>
        </div>
    </div>
</div>
