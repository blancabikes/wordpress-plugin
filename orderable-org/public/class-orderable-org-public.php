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

	private $uis;

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
		$this->uis = array();

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

		// Disabled because unused
		//wp_enqueue_script( $this->orderable_org, plugin_dir_url( __FILE__ ) . 'js/orderable-org-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add required javascript to the page if a shortcode is used.
	 *
	 * @since    1.0.0
	 */
	public function do_footer() {
		if (count($this->uis) > 0) {
			$html = '';
			$html .= '<script charset="utf8" type="text/javascript" id="orderable_org_ui_init_script">function orderable_org_ui_init() {';
			foreach ($this->uis as $ui) {
				$html .= 'Orderable.init({apiUrl: \''.$ui->host.'/api/public\', themeConfig: JSON.parse(\''.str_replace("'", "\'", $ui->theme).'\')}, document.querySelector("#'.$ui->id.'"));';
			}
			$html .= '}</script>';
			$html .= '<script charset="utf8" type="text/javascript" src="'.$this->uis[0]->host.'/assets/js/embed.js" defer onload="orderable_org_ui_init();"></script>';
			echo $html;
		}
	}

	/**
	 * Embedded UI shortcode implmentation
	 *
	 * @since    1.0.0
	 */
	public function do_ui_shortcode($attributes) {

		$host = $attributes['host'];
		$theme = json_encode(json_decode($attributes['theme']) ?? new stdClass());
		if (empty($host)) {
			return '<div><!-- MISSING HOST ATTRIBUTE IN SHORT CODE, USE [orderable_org_ui host="https://tenant.orderable.org"] --></div>';
		} else {
			$ui = new stdClass();
			$ui->id = 'orderable_org_ui_'.bin2hex(openssl_random_pseudo_bytes(4));
			$ui->host = $host;
			$ui->theme = $theme;

			array_push($this->uis, $ui);

			return '<div id="'.$ui->id.'"></div>';
		}

	}
}
