<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Orderable_Org
 * @subpackage Orderable_Org/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Orderable_Org
 * @subpackage Orderable_Org/public
 * @author     Your Name <email@example.com>
 */
class Orderable_Org_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $orderable_org    The ID of this plugin.
	 */
	private $orderable_org;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $orderable_org       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $orderable_org, $version ) {

		$this->orderable_org = $orderable_org;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Orderable_Org_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Orderable_Org_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		// Disabled because unused
		//wp_enqueue_style( $this->orderable_org, plugin_dir_url( __FILE__ ) . 'css/orderable-org-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Orderable_Org_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Orderable_Org_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('orderable-org-ui', get_option('orderable_org_setting_api_url').'/assets/js/embed.js', array(), $this->version, true );
		add_filter('script_loader_tag', array($this, 'add_attributes_to_scripts'), 10, 2);
	}

	/**
	 * Typical wordpress crap, you can't easily add attributes to script without
	 * doing some string replacement in a hook
	 *
	 * @since    1.0.0
	 */
	public function add_attributes_to_scripts($tag, $handle) {

		if ($handle === 'orderable-org-ui') {
			$tag = str_replace(' src=', ' defer onload="Orderable.init(\''.get_option('orderable_org_setting_api_url').'/api/public\');" src=', $tag);
		}
		return $tag;

	}

	/**
	 * Embedded UI shortcode implementation
	 *
	 * @since    1.0.0
	 */
	public function do_ui_shortcode($attributes) {

		$ui = new stdClass();
		$ui->id = 'orderable_org_ui_'.bin2hex(openssl_random_pseudo_bytes(4));
		$ui->theme = $attributes['theme'];
		return '<div data-orderable-org-ui="'.base64_encode($ui->theme).'" id="'.$ui->id.'"></div>';

	}
}
