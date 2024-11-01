<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tandora.co
 * @since             1.0.0
 * @package           Tandora
 *
 * @wordpress-plugin
 * Plugin Name:       Tandora
 * Description:       Tandora is a SaaS app, which will be the first of its kind app built out of India that helps you to post product updates, change log, notifications, alerts and much more to your customers.
 * Version:           1.1
 * Author:            Tandora
 * Author URI:        https://tandora.co/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tandora
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

if ( ! defined( 'WPINC' ) ) {
	die;
}

class wp_tandora{
				
	//magic function (triggered on initialization)
	public function __construct(){
		add_action('media_buttons', array($this, 'addTandoraButton'), 11);  // add tandora button to new / edit post page
		add_action('admin_print_footer_scripts', array($this, 'addTandoraButtonJs'), 199); // add js that will insert tandora shortcode when button is clicked.
		register_activation_hook(__FILE__, array($this,'plugin_activate')); //activate hook
		register_deactivation_hook(__FILE__, array($this,'plugin_deactivate')); //deactivate hook
	}

	//triggered on activation of the plugin (called only once)
	public function plugin_activate(){
		//call our custom content type function
	 	$this->register_tandora_plugin();
	}
	
	//trigered on deactivation of the plugin (called only once)
	public function plugin_deactivate(){
	}

	public function register_tandora_plugin() {
		//Labels for post type
		 $labels = array(
            'name'               => 'Tandora',
            'singular_name'      => 'Tandora',
            'menu_name'          => 'Tandora',
            'name_admin_bar'     => 'Tandora',
        );
        //arguments for post type
        $args = array(
            'labels'            => $labels,
            'public'            => true,
            'publicly_queryable'=> true,
            'show_ui'           => true,
            'show_in_nav'       => true,
            'query_var'         => true,
            'hierarchical'      => false,
            'supports'          => array('title','thumbnail','editor'),
            'has_archive'       => true,
            'menu_position'     => 20,
            'show_in_admin_bar' => true,
            'menu_icon'         => 'dashicons-location-alt',
            'rewrite'			=> array('slug' => 'tandora', 'with_front' => 'true')
        );
		register_post_type('wp_tandora', $args);
	}
	
    public function addTandoraButton() {
        echo '<a title="Insert Tandora Widget" class="button" id="insert-tandora-widget" href="#">Add Tandora Widget</a>';
	}
	
	public function addTandoraButtonJs() {
 		echo '<script type="text/javascript">
              jQuery(document).ready(function(){
                 jQuery("#insert-tandora-widget").click(function() {
                    send_to_editor("[tandora widget_url=\"\"]");
                    return false;
                 });
              });
              </script>';
	}
}

$wp_tandora = new wp_tandora;

//include shortcodes
include(plugin_dir_path(__FILE__) . 'inc/tandora_shortcode.php');

?>