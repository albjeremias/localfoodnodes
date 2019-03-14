let mix = require('laravel-mix');
mix.disableSuccessNotifications();

// Styles
mix.sass('resources/assets/sass/public.sass', 'public/css').version();

// Public
mix.js('resources/assets/js/admin-transaction-list/admin-transaction-list.js', 'public/js').version();
mix.js('resources/assets/js/economy-in-out/economy-in-out.js', 'public/js').version();
mix.js('resources/assets/js/economy-circulation/economy-circulation.js', 'public/js').version();
mix.js('resources/assets/js/transactions/transactions.js', 'public/js').version();
mix.js('resources/assets/js/payment-widget/payment-widget.js', 'public/js').version();

// Admin
mix.js('resources/assets/js/node-map/node-map.js', 'public/js').version();
mix.js('resources/assets/js/account/producers/producer-map/producer-map.js', 'public/js').version();
mix.js('resources/assets/js/account/products/stock-and-variants/stock-and-variants.js', 'public/js').version();

// --- Vue views ---
// Consumer product
mix.js('resources/assets/js/views/consumer-product/index.js', 'public/js/consumer-product.js').version();
// Pickup dates
mix.js('resources/assets/js/views/account/node/create/pickup-dates/index.js', 'public/js/pickup-dates.js').version();
    // .sass('resources/assets/sass/new/vue/modules/calendar.scss', 'public/css').version();


mix.js([
    'resources/assets/js/new/index.js',
    'node_modules/slick-carousel/slick/slick.min.js'
], 'public/js/new.js').version();
