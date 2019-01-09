<?php

return [
    'payment_widget' => [
        'amount' => 'Amount',
        'amount_info_before' => 'We will reach our annual goal with',
        'amount_info_after' => 'members when donating...',
        'annual' => 'Annual',
        'average_fee' => 'Average fee',
        'become_member' => 'Become a member',
        'card_details' => 'Card details',
        'choose_amount' => 'Choose amount',
        'choose_currency' => 'Choose currency',
        'create_account' => 'Create account',
        'donation_info' => 'Your donation will be invested into development of the platform Local Food Nodes. Any surplus will be invested in projects that help develop local food. No money will hit the pockets of private interests. Not now, not ever.',
        'error_login_failed' => 'Login failed',
        'error_signup_required_failed' => 'Required fields are missing',
        'error_signup_gdpr_failed' => 'You need to approve our terms and GDPR policy',
        'gdpr_consent' => 'I accept the <a href="/gdpr" target="_blank">terms</a> and consent to my peronsal information being stored by Local Food Nodes.',
        'goal' => 'Goal',
        'goal_0_header' => 'At he speed of Bolt',
        'goal_0_desc' => 'Parttime developing and fully financed.
            <ul class="list">
                <li>Team of three people</li>
                <li>54h/week</li>
                <li>54h financed</li>
            </ul>
        ',
        'goal_1_header' => 'Half and half',
        'goal_1_desc' => 'Pacing the project with even more workdays. Part time bro bono, part time financed.
            <ul class="list">
                <li>Team of three people</li>
                <li>54h/week</li>
                <li>27h financed</li>
            <ul>
        ',
        'goal_2_header' => 'Pocket money',
        'goal_2_desc' => 'Pacing the project by working some days a week together. Main time bro bono. Some hours financed.
            <ul class="list">
                <li>Team of three people</li>
                <li>36h/week</li>
                <li>Some hours financed</li>
            </ul>
        ',
        'goal_3_header' => 'Getting organized',
        'goal_3_desc' => 'Be able to hire office space and working a few days a week together.
            <ul class="list">
                <li>Team of three people</li>
                <li>18h/week</li>
                <li>Pro bono</li>
                <li>Office</li>
            </ul>
        ',
        'goal_4_header' => 'Couch coding',
        'goal_4_desc' => 'Reaching this milestone makes it possible for the project to develope at a low pace whenever finding spare hours, and to pay for its necessary licenses and fees.
            <ul class="list">
                <li>Team of three people<li>
                <li>Random hours</li>
                <li>Pro bono</li>
                <li>Operational costs covered</li>
            </ul>
        ',
        'have_become_members' => 'have become members.',
        'lets_go_to' => 'Lets go to',
        'link_create_account' => 'Create an account?',
        'link_login' => 'Already have an account?',
        'login' => 'Login',
        'members' => 'members',
        'monthly' => 'Monthly',
        'other' => 'Other',
        'phonenumber_info' => 'Only needed if a producer need to reach you about a ordered product or an upcoming pickup.',
        'subscription' => 'Subscription',
        'subscription_help' => 'Monthly subscription will charge your account every month while annual subscription is a one time payment.',
        'supporting_members' => 'Supporing members',
        'value_card_title' => 'Value driven and gift based',
        'value_card_body' => '
            <p>We build this platform since we believe in an internet where we can engage in real relations, where social connections can thrive and flourish without giving up our personal integrity, instead of us being the product that is sold to unknown third parties. We cheer for an Internet that enhance and drive real human relations where we as individuals feel secure in never being tools for unknown purposes, tracked in our behaviours and used to make money and impact without our knowledge.</p>
            <p>We believe none of us has to be the product in order to connect.</p>
            <p>In order to be able to do this, instead of traditional online business models, Local Food Nodes is build on transparency and a gift economy. So, wanna get hooked up with great locally produce, digitally supported and eased by this smooth tool, support as with us much as suits you, and we will try to make magic.</p>
        ',
        'your_email' => 'Your email',
        'your_name' => 'Your name',
        'your_password' => 'Your password',
        'choose_password' => 'Choose a password',
        'your_phone' => 'Your phone number',
    ],

    // All js metrics widgets
    'metrics' => [
        'available_balance' => 'Available balance',
        'category' => 'Category',
        'change_currency' => 'Change currency',
        'currency' => 'Currency',
        'date' => 'Date',
        'description' => 'Description',
        'in' => 'In',
        'money_circulated' => 'Money circulation',
        'items_sold' => 'Items sold',
        'out' => 'Out',
        'unique_products' => 'Unique products',
        'ref' => 'Reference',

        // Transaction categories
        'all' => 'All',
        'all_incomes' => 'All incomes',
        'all_costs' => 'All costs',
        'category_1' => 'Memberships',
        'category_2' => 'Other incomes',
        'category_3' => 'Operation',
        'category_4' => 'Saleries',
        'category_5' => 'Other costs',
    ],

    // Stripe errors
    'stripe' => [
        'balance_insufficient' => 'The transfer or payout could not be completed because the associated account does not have a sufficient balance available. Create a new transfer or payout using an amount less than or equal to the account’s available balance.',
        'card_declined' => 'The card has been declined. This is usually because the card has restrictions for online purchases. We recommend that you check the settings for your card in your internet bank and try again. If you still experience problems, please contact your bank.',
        'expired_card' => 'The card has expired. Check the expiration date or use a different card.',
        'incorrect_cvc' => 'The card’s security code is incorrect. Check the card’s security code or use a different card.',
        'incorrect_number' => 'The card number is incorrect. Check the card’s number or use a different card.',
        'invalid_card_type' => 'The card provided as an external account is not a debit card. Provide a debit card or use a bank account instead.',
        'invalid_charge_amount' => 'The specified amount is invalid. The charge amount must be a positive integer in the smallest currency unit, and not exceed the minimum or maximum amount.',
        'invalid_cvc' => 'The card’s security code is invalid. Check the card’s security code or use a different card.',
        'invalid_expiry_month' => 'The card’s expiration month is incorrect. Check the expiration date or use a different card.',
        'invalid_expiry_year' => 'The card’s expiration year is incorrect. Check the expiration date or use a different card.',
        'invalid_number' => 'The card number is invalid. Check the card details or use a different card.',
        'missing_amount' => 'Amount is missing',
        'missing_currency' => 'Currency is missing',
        'missing_recurring' => 'Donation type is missing',
        'missing_token' => 'Token is missing. Refresh page and try again, or contact info@localfoodnodes.org',
    ]
];
