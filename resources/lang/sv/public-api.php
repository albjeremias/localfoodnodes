<?php

return [
    'payment_widget' => [
        'amount' => 'Summa',
        'amount_info_before' => 'Vi når det årliga målet med',
        'amount_info_after' => 'medlemmar när du donerar...',
        'annual' => 'Årligen',
        'average_fee' => 'Genomsnitt medlemsavgift',
        'become_member' => 'Bli medlem',
        'card_details' => 'Kortinformation',
        'choose_amount' => 'Välj belopp',
        'choose_currency' => 'Välj valuta',
        'create_account' => 'Skapa konto',
        'donation_info' => 'Din donation kommer att investeras i utvecklingen av plattformen Local Food Nodes. Eventuellt överskott kommer att investeras i projekt som hjälper till att utveckla lokal mat. Inga pengar kommer att hamna i fickorna på privata vinstintressen. Inte nu, inte någonsin.',
        'error_login_failed' => 'Inloggningen misslyckades',
        'error_signup_required_failed' => 'Obligatoriska fält saknas',
        'error_signup_gdpr_failed' => 'Du måste godkänna våra villkor och GDPR-policy',
        'gdpr_consent' => 'Jag accepterar <a href="/gdpr" target="_blank">användarvillkoren</a> och godkänner att mina personliga uppgifter lagras av Local Food Nodes.',
        'goal' => 'Mål',
        'goal_0_header' => 'Snabba som blixten',
        'goal_0_desc' => 'Utveckling på deltid och fullt finansierade.
            <ul class="list">
                <li>Team på tre personer</li>
                <li>54h/veckan</li>
                <li>54h finansierade</li>
            </ul>
        ',
        'goal_1_header' => '50/50',
        'goal_1_desc' => 'Ökar utveckling med yttligare fler arbetsdagar. Halva tiden pro bono, halva tiden finansierad.
            <ul class="list">
                <li>Team på tre personer</li>
                <li>54h/veckan</li>
                <li>27h finansierade</li>
            <ul>
        ',
        'goal_2_header' => 'Fickpengar',
        'goal_2_desc' => 'Ökar utvecklingen med fler arbetsdagar tillsammans. Mestadels pro bono med några timmar finansierade.
            <ul class="list">
                <li>Team på tre personer</li>
                <li>36h/veckan</li>
                <li>Några timmar betalda</li>
            </ul>
        ',
        'goal_3_header' => 'Komma igång',
        'goal_3_desc' => 'Möjlighet att hyra kontor och sitta tillsammans några dagar i veckan.
            <ul class="list">
                <li>Team på tre personer</li>
                <li>18h/veckan på dagtid</li>
                <li>Pro bono</li>
                <li>Kontorsplats</li>
            </ul>
        ',
        'goal_4_header' => 'Soffkodning',
        'goal_4_desc' => 'Vi utvecklar plattformen i ett långsamt tempo när vi hittar tid.
            <ul class="list">
                <li>Team på tre personer</li>
                <li>Jobb på kvällar och helger</li>
                <li>Pro bono</li>
                <li>Driftkostnader betalda</li>
            </ul>
        ',
        'have_become_members' => 'har blivit medlemmar.',
        'lets_go_to' => 'Nu siktar vi på',
        'link_create_account' => 'Vill du skapa ett konto?',
        'link_login' => 'Har du redan ett konto?',
        'login' => 'Logga in',
        'members' => 'medlemmar',
        'monthly' => 'Månatligen',
        'other' => 'Annat',
        'phonenumber_info' => 'Används endast om en producent behöver få kontakt med dig i samband med en utlämning.',
        'subscription' => 'Välj donationsform',
        'subscription_help' => 'Månatlig prenumeration debiterar ditt konto varje månad medan årlig prenumeration är en engångsbetalning.',
        'supporting_members' => 'Stöttande medlemmar',
        'value_card_title' => 'Gåvoekonomi - en del av vår värdegrund.',
        'value_card_body' => '
            <p>Ett av huvudskälen till att vi utvecklar plattformen LFN, och på det sätt vi gör det, är för att vi tror på ett Internet där mänskliga relationer skall kunna knytas, blomstra och utvecklas utan att vi som individer skall behöva ge upp vår personliga integritet. Där vi som användare inte utgör handelsvaran som säljs till okänd tredjepart. Istället sporras vi av tanken på ett Internet som stärker våra mänskliga band och där vi känner oss trygga i vetskapen att aldrig bli redskap för att någon skall tjäna pengar eller användas oss som verktyg i för oss okända sammanhang.</p>
            <p>För att kunna göra detta bygger Local Food Nodes, till skillnad från traditionella online-affärsmodeller, på öppenhet och en gåvoekonomi.</p>
            <p>Så, vill du hooka upp med grymt bra lokalt producerade mat, helt utan mellanhänder, med hjälp av ett grymt digitalt verktyg är du välkommen att  support oss med så stor eller liten summa du känner för, så skall vi försöka göra sjukt bra grejer med det förtroendet.</p>
        ',
        'your_email' => 'Din E-postadress',
        'your_name' => 'Ditt namn',
        'your_password' => 'Ditt lösenord',
        'choose_password' => 'Ange ett lösenord',
        'your_phone' => 'Ditt telefonnummer',
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
        'items_sold' => 'Sålda varor',
        'out' => 'Ut',
        'unique_products' => 'Unika produkter',
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

    // Stripe and payment errors
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
        'missing_amount' => 'Summa saknas.',
        'missing_currency' => 'Valuta saknas.',
        'missing_recurring' => 'Donationstyp saknas',
        'missing_token' => 'Token saknas. Ladda om sidan och prova igen, annars kontakta info@localfoodnodes.org',
    ],

    // Membership
    'membership' => [

    ]
];