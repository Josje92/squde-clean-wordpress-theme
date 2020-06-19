<?php
/**
 * Retrieve a product
 */
add_action('rest_api_init', function() {
    register_rest_route(
        'squde/v1', '/products(?:/(?P<id>\d+))?',
        [
            'methods' => 'GET',
            'callback' => 'squde_woocommerce_api_products_request',
            'args' => [
                'id'
            ]
        ]
    );
});

function squde_get_woocommerce_client() {
    require dirname(__DIR__) . '/vendor/autoload.php';

    $key = SqudeCleanWordpressThemeAdminSettings::getSetting('wc_key');
    $secret = SqudeCleanWordpressThemeAdminSettings::getSetting('wc_secret');

    if (empty($key) || empty($secret)) {
        throw new Exception('Headless WooCommerce not setup properly', 500);
    }

    $url = get_home_url();
    $woocommerce = new \Automattic\WooCommerce\Client(
        $url,
        $key,
        $secret,
        [
            'wp_api' => true, // Enable the WP REST API integration
            'version' => 'wc/v3' // WooCommerce WP REST API version
        ]
    );

    return $woocommerce;
}
function squde_woocommerce_api_products_request(WP_REST_Request $request) {
    try {
        $woocommerce = squde_get_woocommerce_client();
    } catch (Exception $e) {
        return new WP_Error($e->getCode(), $e->getMessage());
    }
    $singleResult = $request->has_param('id');
    $args = [];

    if ($singleResult) {
        $args['include'] = [$request->get_param('id')];
    }

    $result = $woocommerce->get('products', $args);

    if ($singleResult) {
        return !empty($result[0]) ? $result[0] : null;
    }
    return $result;
}
