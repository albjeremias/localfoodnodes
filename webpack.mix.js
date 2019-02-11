let mix = require('laravel-mix');
mix.disableSuccessNotifications();
mix.options({
    uglify: false,
});

// Styles
mix.sass('resources/assets/sass/public.sass', 'public/css').version();

// Vue
mix.js('resources/assets/js/payment-widget/payment-widget.js', 'public/js').version();

// Frontpage
mix.js('resources/assets/js/economy-in-out/economy-in-out.js', 'public/js').version();
mix.js('resources/assets/js/economy-circulation/economy-circulation.js', 'public/js').version();

mix.js('resources/assets/js/transactions/transactions.js', 'public/js').version();
mix.js('resources/assets/js/admin-transaction-list/admin-transaction-list.js', 'public/js').version();

mix.js('resources/assets/js/producer-map/producer-map.js', 'public/js').version();
mix.js('resources/assets/js/node-map/node-map.js', 'public/js').version();

mix.js([
    'resources/assets/js/new/index.js',
    'node_modules/slick-carousel/slick/slick.min.js'
], 'public/js/new.js').version();
