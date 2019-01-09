let mix = require('laravel-mix');
mix.disableSuccessNotifications();
mix.options({
    uglify: false,
});

// Styles
mix.sass('resources/assets/sass/public.sass', 'public/css').version();
mix.sass('resources/assets/sass/account.sass', 'public/css').version();

// Vue
mix.js('resources/assets/js/vue/payment-widget/payment-widget.js', 'public/js').version();
mix.js('resources/assets/js/vue/economy-in-out/economy-in-out.js', 'public/js').version();
mix.js('resources/assets/js/vue/economy-circulation/economy-circulation.js', 'public/js').version();
mix.js('resources/assets/js/vue/transactions/transactions.js', 'public/js').version();

mix.js('resources/assets/js/vue/admin-transaction-list/admin-transaction-list.js', 'public/js').version();

