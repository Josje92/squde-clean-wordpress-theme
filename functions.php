<?php
/**
 * Squde Clean functions and definitions
 *
 * @package Squde Clean
 * @since 1.0.0
 */

require_once 'admin/admin.php';
require_once 'api.php';
require_once 'updater.php';
require_once 'woocommerce/api.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function twentytwenty_theme_support()
{
    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');


    /*
     * Add menu support
     */
    add_theme_support( 'menus' );


    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');


    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on Twenty Twenty, use a find and replace
     * to change 'twentytwenty' to the name of your theme in all the template files.
     */
    load_theme_textdomain('squdeclean');
}

add_action( 'after_setup_theme', 'twentytwenty_theme_support' );