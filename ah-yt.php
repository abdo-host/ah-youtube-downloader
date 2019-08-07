<?php

/*
 * @link              #
 * @since             1.0.0
 * @package           AH-YouTube Downloader
 *
 * @wordpress-plugin
 * Plugin Name:       AH-YouTube Downloader
 * Plugin URI:        #
 * Description:       Youtube videos and playlist grabber and download multi types
 * Version:           1.0.0
 * Author:            Tatwerat Team
 * Author URI:        http://www.tatwerat.com
 * License:           General Public License 2.0
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ah-yt
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// don't load directly
if (!defined('ABSPATH'))
    die;

define('AH_VERSION', '1.0.0');
define('AH_URL', plugins_url('', __FILE__));
define('AH_PATH', plugin_dir_path(__FILE__));
define('AH_KEY', 'AIzaSyCIuVnDuCtVW6IPvOKEC59Wxwn829mqpEk');

/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */
function ah_load_textdomain() {
    load_plugin_textdomain('ah_yt', false, basename(dirname(__FILE__)) . '/languages/');
}

add_action('plugins_loaded', 'ah_load_textdomain');


// require plugin widgets
require_once (AH_PATH . '/includes/ah-widget.php');
require_once (AH_PATH . '/includes/ah-vc.php');

// require plugin class
require_once (AH_PATH . '/includes/AHYT.php');

// visual composer initialize
new AH_YT_VCExtendAddonClass();