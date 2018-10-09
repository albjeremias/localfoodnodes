<?php

return [
    'payment_widget' => [
        'amount' => 'Amount',
        'average_fee' => 'Average fee',
        'become_member' => 'Become a member',
        'supporting_members' => 'Supporing members',
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
        'orders' => 'Orders',
        'out' => 'Out',
        'products' => 'Products',
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
    ]
];
