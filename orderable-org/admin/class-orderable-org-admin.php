<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Orderable_Org
 * @subpackage Orderable_Org/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Orderable_Org
 * @subpackage Orderable_Org/admin
 * @author     Your Name <email@example.com>
 */
class Orderable_Org_Admin {

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
	 * @param      string    $orderable_org       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $orderable_org, $version ) {

		$this->orderable_org = $orderable_org;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function init_settings() {
		add_settings_section('orderable_org_settings_section', 'Orderable.org', array($this, 'do_settings_section'), 'general');
		add_settings_field('orderable_org_setting_api_url', 'API Url', array($this, 'do_settings'), 'general', 'orderable_org_settings_section');
		register_setting('general', 'orderable_org_setting_api_url');
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->orderable_org, plugin_dir_url( __FILE__ ) . 'css/orderable-org-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->orderable_org, plugin_dir_url( __FILE__ ) . 'js/orderable-org-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function do_settings_section() {
		echo '<p>Your orderable.org plugin settings.</p>';
	}

	public function do_settings() {
		echo '<input name="orderable_org_setting_api_url" id="orderable_org_setting_api_url" value="'.get_option('orderable_org_setting_api_url').'" type="text" /><p class="description" id="tagline-description">The url where the orderable.org API is hosted.</p>';
	}
}
