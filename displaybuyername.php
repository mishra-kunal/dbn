<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/mishra-kunal
 * @since             1.0.0
 * @package           Displaybuyername
 *
 * @wordpress-plugin
 * Plugin Name:       DisplayBuyerName
 * Plugin URI:        https://github.com/mishra-kunal/dbn
 * Description:       Display Customer name and email in page. Built to display buyer name for woocommerce.
 * Version:           1.0.0
 * Author:            Kunal
 * Author URI:        https://github.com/mishra-kunal
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       displaybuyername
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('DISPLAYBUYERNAME_VERSION', '1.0.0');
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-displaybuyername-activator.php
 */
function activate_displaybuyername() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-displaybuyername-activator.php';
    Displaybuyername_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-displaybuyername-deactivator.php
 */
function deactivate_displaybuyername() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-displaybuyername-deactivator.php';
    Displaybuyername_Deactivator::deactivate();
}
register_activation_hook(__FILE__, 'activate_displaybuyername');
register_deactivation_hook(__FILE__, 'deactivate_displaybuyername');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-displaybuyername.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_displaybuyername() {
    $plugin = new Displaybuyername();
    $plugin->run();
}
run_displaybuyername();
add_shortcode('userlist', 'userf');
function userf() {
    $args = array('role' => 'customer',);
    $users = get_users($args);
    $i = 1;
    echo '<div class="support-grid"></div>';
    echo '<div class="band">';
    foreach ($users as $user) {
        $sname = esc_html($user->display_name);
        $semail = esc_html($user->user_email);
        $picture_id = get_user_meta($user->ID, 'profile_pic', true);
        if (trim($picture_id) == '') {
            $simage = get_avatar_url($user->ID, array('size' => $wpp_right_col_avatar_size));
        } else {
            $simage = wp_get_attachment_image_src($picture_id, 'full');
            $simage = $simage[0];
        }
        echo '<div class="item-' . $i++ . '">';
        echo '<a href="#" class="card">
            <div class="thumb" style="background-image: url(' . $simage . ');"></div>';
        echo '            <article>
              <h1>' . $sname . '</h1>
              <span>' . $semail . '</span>
            </article>
          </a>
    </div>';
    }
    echo '</div>';
}
