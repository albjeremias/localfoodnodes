<?php

return [
    'add_date' => 'Add date',
    'adjust_production_quantity_per_delivery' => 'Adjust production for specific deliveries',
    'adjust_production_quantity_per_week' => 'Adjust production quantity for each week',
    'amount_per_package' => 'Amount per package',
    'back_to_producer' => 'Back to producer',
    'booking_deadline' => 'Booking deadline:',
    'cancel' => 'Cancel',
    'confirm_delete' => 'Confirm delete',
    'confirm_delete_info' => 'You are about to delete a product. Are you sure you cant to continue?',
    'create_variant' => 'Create variant',
    'csa_products' => 'CSA products',
    'csa_products_info' => '
        CSA is products that must be booked for the whole season in advance. CSA works just like the weekly balance, with the difference that you as a customer book an entire season in advance at once.
    ',
    'date' => 'Date',
    'days' => 'days before delivery',
    'delete' => 'Delete',
    'delete_product' => 'Delete product',
    'delete_variant' => 'Delete variant',
    'delivery_dates' => 'Delivery dates',
    'delivery_dates_select_info' => 'To make your product visible on the node page you have to select the dates you will be delivering to the node.',
    'delivery_dates_no_nodes' => 'It looks like you haven\'t selected nodes to delivery to. Delivery dates are defined by the nodes so you have to select at least one to continue. Then you\'ve selected your nodes reload the page to view the delivery calendar.',
    'delivery_dates_recurring_products_info' => '<b>:product_name</b> is a recurring product that is produced continuously for a period of time, and production quantities may change during this time. In this view you have the ability to change the produced quantity for a specific delivery.',
    'edit_delivery_dates' => 'Edit delivery dates',
    'edit_product' => 'Edit product',
    'edit_production' => 'Edit production',
    'edit_variant' => 'Edit variant',
    'edit_variants' => 'Edit variants',
    'enter_content_one_product' => 'Enter the content of one product',
    'enter_price_one_product' => 'Enter the price for one product',
    'enter_total_csa_subscribers' => 'Enter total number of CSA subscribers for this product and season',
    'estimate_package_amount' => 'Estimate content',
    'hg' => 'hg',
    'hide_from_store' => 'Hide product from store',
    'kg' => 'kg',
    'main_variant' => 'Main variant',
    'name' => 'Name',
    'name_first_variant' => 'Name your first variant',
    'number_of_csa_subscribers' => 'Number of CSA subscribers',
    'number_of_products' => 'Number of products',
    'no_variants' => 'No variants',
    'occasional_products' => 'Occasional product',
    'occasional_products_fresh_meat' => 'Occasional product - Fresh meat',
    'occasional_products_info' => '
        For products produced in "batches" with a fixed balance, such as honey, pickling, slaughter, etc.
        <ul class="list mt-3">
            <li>Product balance is set from a fixed date and then counts down until it ends.</li>
            <li>You can create multiple production dates. The aproduct balance for the new date is added to the previous date\'s balance.</li>
            <li>The balance has expired when the product is sold out, regardless of which delivery dates or delivery nodes the product is available on.</li>
        </ul>
    ',
    'occasional_specify_date_quantity' => 'Specify the date and quantity from which the product is available for delivery.',
    'other_options' => 'Other options (optional)',
    'package_amount_info' => '
        You have specified a price in kg or hg. Estimate the weight of the product content so that the total price for the customer is correct in checkout.
    ',
    'price' => 'Price',
    'price_per' => 'Price is set per...',
    'price_on_variants' => 'Your product has variants and it\'s the variant prices that will show in the store.',
    'product' => 'Product',
    'products' => 'Products',
    'product_name' => 'Product name',
    'product_name_placeholder' => 'Example: Eggs, carrots...',
    'product_content' => 'Product content',
    'product_content_specified_in' => 'Product content is specificed in...',
    'product_description' => 'Product description',
    'product_description_placeholder' => 'Example: Eggs from free range chickens...',
    'product_payment_info' => 'Product payment info',
    'product_payment_info_placeholder' => 'Product specific information included in customer order email (optional)',
    'production' => 'Production',
    'production_date' => 'Production date',
    'production_for_week' => 'Production for week',
    'production_type_header' => 'What type of product is this?',
    'quantity' => 'Quantity',
    'quantity_available' => 'Quantity available from the date above',
    'recurring_products_weekly' => 'Recurring product with stock set weekly',
    'recurring_products_per_delivery' => 'Recurring product with stock set per delivery',
    'recurring_products_info' => '
        For products harvested regularly and having a recurring weekly balance. Tex eggs, fast-growing vegetables, etc.
        <ul class="list mt-3">
            <li>Weekly balance renew itself every week.</li>
            <li>The weekly balance is shared with several delivery nodes. This means that you can deliver to multiple delivery nodes the same week, and the balance counts down regardless of the what node it is booked to.</li>
            <li>You can adjust weekly balance individually for each week if you produce more or less certain weeks. Just make sure it\'s done well in advance.</li>
        </ul>
    ',
    'reload_page' => 'Reload page',
    'save' => 'Save',
    'save_product' => 'Save product',
    'save_product_continue' => 'Save product and continue to delivery dates',
    'save_variant' => 'Save variant',
    'select_delivery_dates' => 'Select delivery dates',
    'select_production_type' => 'Select production type',
    'select_product_type' => 'Select product type',
    'select_tags' => 'Select suitable tags for the product',
    'select_unit_product_content' => 'Select unit for product content',
    'set_main_variant' => 'Set as main variant',
    'specify_number_products' => 'Specifiy the number of products for each delivery occasion',
    'title' => 'Product production',
    'update_deliveries' => 'Update deliveries',
    'update_production' => 'Update production',
    'variants' => 'Variants',
    'variant_disabled' => 'You cannot edit a variant at the moment. If you need to change a value, delete it and create a new one.',
    'variant_save_first' => 'You can create more variants after you have saved your product.',
    'variant_name_example' => 'Example: Large box, small box...',
    'visibility' => 'Visibility',
    'week' => 'Week',

    // How does it work
    'how_does_it_work' => 'How does it work',
    'hdiw_intro' => 'Products are created step by step and parameters are selected gradually that best suit the product.',
    'hdiw_item_1' => 'Enter name and description and choose tags for your product. Upload image/s describing the product. Enter payment information and how long before delivery you must have orders for the product.',
    'hdiw_item_2' => 'Choose the type of product and quantity of the product you want to sell.',
    'hdiw_item_3' => 'Enter delivery dates and delivery nodes for your product.',

    'hdiw_intro_variants' => '
        Variants is an optional feature to be used on products that comes in different sizes and packages. For example a big box of eggs and a small box of eggs. A kind of cheese in different sizes, or a box meat in different cuts or box sizes.
    ',
    'hdiw_item_4_1' => 'Enter unit for the content in your variants.',
    'hdiw_item_4_2' => 'Create one or more variants of your product, for example a big box of eggs or a small box of meat.',
    'hdiw_item_4_3' => 'Enter the content of ONE variant, for example 6 (pcs eggs) or 18 (kg meat).',
    'hdiw_item_4_4' => 'Enter a price for the variant.',

    'hdiw_outro' => 'Se även instruktionsfilmer som stegvis går igenom produktskapande här.',

    'delivery_adjustment' => 'Recurring product with stock set per delivery are produced continously and where the stock is set per delivery. Since the quantity of products can change from during the season you can adjust how many products you want to make available for each delivery over the season.',

    'weekly_adjustment' => 'Recurring product with stock set weekly are products that are produced continously for a period of time and where the stock is administered per week. Since the quantity of products available can change from week to week during this period you can adjust the products that are available each week.',

];
