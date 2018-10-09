<?php

return [
    'payment_widget' => [
        'amount' => 'Summa',
        'average_fee' => 'Genomsnitt medlemsavgift',
        'become_member' => 'Bli medlem',
        'supporting_members' => 'Stöttande medlemmar',
    ],

    // All js metrics widgets
    'metrics' => [
        'available_balance' => 'Tillgänliga medel',
        'category' => 'Kategori',
        'change_currency' => 'Ändra valuta',
        'currency' => 'Valuta',
        'date' => 'Datum',
        'description' => 'Beskrivning',
        'in' => 'In',
        'money_circulated' => 'Pengacirkulation',
        'orders' => 'Beställningar',
        'out' => 'Ut',
        'products' => 'Produkter',
        'ref' => 'Referens',

        // Transaction categories
        'all' => 'Alla',
        'all_incomes' => 'Alla intäkter',
        'all_costs' => 'Alla kostnader',
        'category_1' => 'Medlemskap',
        'category_2' => 'Övriga instäkter',
        'category_3' => 'Driftkostnader',
        'category_4' => 'Arvoden',
        'category_5' => 'Övriga kostnader',
    ],

    // Stripe errors
    'stripe' => [
        'balance_insufficient' => 'Betalningen kunde inte genomföras då det finns för lite pengar på kortet.',
        'card_declined' => 'Ditt kort godkändes ej. Detta beror oftast på att kortet har begränsningar för köp på internet. Vi rekommenderar dig att logga in på din internetbank, ändra inställningarna och prova igen. Om du fortfarande upplever problem behöver du kontakta din bank.',
        'expired_card' => 'Ditt kort har gått ut. Kontrollera utgångsdatum eller prova med ett annat kort.',
        'incorrect_cvc' => 'Den angivna CVC-koden är felaktig. Kontrollera kortet CVC-kod eller prova me ett annat kort.',
        'incorrect_number' => 'Kortnumret är felaktigt. Kontrollera kortnumret eller prova med ett annat kort.',
        'invalid_card_type' => 'Kortet är av en ogiltig typ och kan inte debiteras. Prova med ett annat kort.',
        'invalid_charge_amount' => 'Summan är felaktig. Kontrollera så att summan är en positiv siffra.',
        'invalid_cvc' => 'Den angivna CVC-koden är felaktig. Kontrollera kortet CVC-kod eller prova me ett annat kort.',
        'invalid_expiry_month' => 'Kortets utgångsmånad är felaktigt. Kontrollera utgångsdatumet eller prova med ett annat kort.',
        'invalid_expiry_year' => 'Kortets utgångsår är felaktigt. Kontrollera utgångsdatumet eller prova med ett annat kort.',
        'invalid_number' => 'Kortnumret är felaktigt. Kontrollera kortnumret eller prova med ett annat kort.',
    ]
];
