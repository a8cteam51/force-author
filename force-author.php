<?php
/*
 * Plugin Name: Force Author
 * Description: Forces the author of new posts to always be a specific author you set.
 * Version: 1.0.0
 * Author: WordPress.com Special Projects
 * Author URI: https://wpspecialprojects.wordpress.com
 * Text Domain: force-author
 * License: GPLv3
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'FORCE_AUTHOR_PATH', plugin_dir_path( __FILE__ ) );
define( 'FORCE_AUTHOR_URL', plugin_dir_url( __FILE__ ) );
define( 'FORCE_AUTHOR_BASENAME', plugin_basename(__FILE__) );

require_once __DIR__ . '/includes/admin.php';
