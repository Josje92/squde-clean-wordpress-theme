<?php
/**
 * Return the thumbnail with the api, in all possible sizes
 */
add_action('rest_api_init', function() {
    register_rest_field( array_values(get_post_types(['show_in_rest' => true])), 'featured_image', [
        'get_callback' => function( $args ) {
            if (!empty($args['featured_media'])) {
                $result = [];
                foreach(get_intermediate_image_sizes() as $size) {
                    $result[$size] = wp_get_attachment_image_url($args['featured_media'], $size);
                }

                $xs = 'x';
                foreach($result as $key => $value) {
                    if (is_numeric($key[0])) {
                        unset($result[$key]);
                        $result[$xs . 'large'] = $value;
                        $xs .= 'x';
                    }
                }


                $result['full'] = end($result);
                unset($result[array_keys($result)[count($result) - 2]]);

                return $result;
            }
            return null;
        },
        'schema' => array(
            'description' => __( 'Thumbnail' ),
            'type'        => 'string'
        ),
    ]);
});

/**
 * Retrieve the frontpage
 */
add_action('rest_api_init', function() {
    register_rest_route(
        'wp/v2', '/frontpage',
        [
            'methods' => 'GET',
            'callback' => function ($object) {

                // Get WP options front page from settings > reading.
                $frontpage_id = get_option('page_on_front');

                // Handle if error.
                if (empty($frontpage_id)) {
                    // return error
                    return 'error';
                }

                // Create request from pages endpoint by frontpage id.
                $request = new \WP_REST_Request('GET', '/wp/v2/pages/' . $frontpage_id);

                // Parse request to get data.
                $response = rest_do_request($request);

                // Handle if error.
                if ($response->is_error()) {
                    return 'error';
                }

                return $response->get_data();
            },
        ]
    );

});