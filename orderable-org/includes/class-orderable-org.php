<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Orderable_Org
 * @subpackage Orderable_Org/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Orderable_Org
 * @subpackage Orderable_Org/includes
 * @author     Your Name <email@example.com>
 */
class Orderable_Org {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Orderable_Org_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $orderable_org    The string used to uniquely identify this plugin.
	 */
	protected $orderable_org;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ORDERABLE_ORG_VERSION' ) ) {
			$this->version = ORDERABLE_ORG_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->orderable_org = 'orderable-org';
		$this->plugin_admin = null;
		$this->plugin_public = null;

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_shortcodes();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Orderable_Org_Loader. Orchestrates the hooks of the plugin.
	 * - Orderable_Org_i18n. Defines internationalization functionality.
	 * - Orderable_Org_Admin. Defines all hooks for the admin area.
	 * - Orderable_Org_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-orderable-org-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-orderable-org-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-orderable-org-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-orderable-org-public.php';

		$this->loader = new Orderable_Org_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Orderable_Org_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Orderable_Org_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * On demand create the admin plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_plugin_admin() {

		if (is_null($this->plugin_admin)) {
			$this->plugin_admin = new Orderable_Org_Admin( $this->get_orderable_org(), $this->get_version() );
		}
		return $this->plugin_admin;

	}

	/**
	 * On demand create the public plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function get_plugin_public() {

		if (is_null($this->plugin_public)) {
			$this->plugin_public = new Orderable_Org_Public( $this->get_orderable_org(), $this->get_version() );
		}
		return $this->plugin_public;

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$this->loader->add_action( 'admin_init', $this->get_plugin_admin(), 'init_settings' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->get_plugin_admin(), 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->get_plugin_admin(), 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$this->loader->add_action( 'wp_enqueue_scripts', $this->get_plugin_public(), 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this->get_plugin_public(), 'enqueue_scripts' );

	}

	/**
	 * Register all short codes of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_shortcodes() {

		add_shortcode('orderable_org_ui', function ( $attributes ) {
			return $this->get_plugin_public()->do_ui_shortcode($attributes);
		});

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_orderable_org() {
		return $this->orderable_org;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Orderable_Org_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
