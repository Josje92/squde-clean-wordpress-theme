<?php
class SqudeCleanWordpressThemeAdminSettings {
    function __construct() {
        add_action( 'admin_menu', [$this, 'register_options_page']);
        add_action( 'admin_init', [$this, 'save_settings_if_needed']);
    }

    /**
     * Save the squde contact settings if asked for
     */
    public function save_settings_if_needed() {
        if (!(basename($_SERVER['REQUEST_URI']) === 'options-general.php?page=squde-clean-wordpress-theme-options' && isset($_POST) && count($_POST) > 0)) {
            return;
        }

        foreach($_POST as $key => $value) {
            $value = self::parseSetting($key, $value);
            if (!is_string($value) || trim($value) !== trim(self::getDefaultSettingFor($key))) {
                if (is_string($value) && empty($value)) {
                    delete_option("squde_clean_wordpress_theme_{$key}");
                } else {
                    $value = str_replace('\"', '"', $value);
                    $value = str_replace("\'", "'", $value);
                    update_option("squde_clean_wordpress_theme_{$key}", $value);
                }
            }
        }
    }

    /**
     * Register the menu button
     */
    public function register_options_page() {
        add_options_page('Squde Clean - settings', 'Squde Clean', 'manage_options', 'squde-clean-wordpress-theme-options', [$this, 'options_page']);
    }

    /**
     * Return the options page
     */
    public function options_page() {
        ob_start();
        require_once dirname(__FILE__) . '/templates/admin-options.php';
        $html = ob_get_contents();
        ob_end_clean();

        echo $html;
    }

    /**
     * Retrieve the saved setting or the default one
     *
     * @param $key
     * @return mixed
     */
    public static function getSetting($key) {
        return static::parseSetting($key, get_option("squde_clean_wordpress_theme_{$key}", static::getDefaultSettingFor($key)));
    }


    /**
     * Return the default settings
     *
     * @param $key
     * @return mixed
     */
    public static function getDefaultSettingFor($key) {
        $settings = [
            'wc_key' => '',
            'wc_secret' => '',
        ];
        if (isset($settings[$key])) {
            return $settings[$key];
        }
        return null;
    }

    /**
     * Parse certain settings to wanted value types (string to boolean etc).
     *
     * @param $key
     * @param $value
     * @return mixed
     */
    public static function parseSetting($key, $value) {
        $parsings = [
            'save_messages' => function($value) { return (bool)((int)$value); },
            'send_notifications' => function($value) { return (bool)((int)$value); },
            'send_confirmations' => function($value) { return (bool)((int)$value); },
            'use_way_of_contact' => function($value) { return (bool)((int)$value); },
            'request_timeout' => function($value) { return (int)$value; },
        ];
        if (isset($parsings[$key])) {
            return call_user_func_array($parsings[$key], [$value]);
        }
        return $value;
    }
}
new SqudeCleanWordpressThemeAdminSettings();