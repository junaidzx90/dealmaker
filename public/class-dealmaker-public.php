<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Dealmaker
 * @subpackage Dealmaker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Dealmaker
 * @subpackage Dealmaker/public
 * @author     Developer Junayed <admin@easeare.com>
 */
class Dealmaker_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'dealmaker', [$this, "dealmaker_shortcode_view"] );
	}

	
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dealmaker-public.css', array(), $this->version, 'all' );

		wp_enqueue_script( 'html2canvas', plugin_dir_url( __FILE__ ) . 'js/html2canvas.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dealmaker-public.js', array( 'jquery', 'html2canvas' ), $this->version, true );
	}

	function dealmaker_shortcode_view($atts){
		ob_start();
		$atts = shortcode_atts(
			array(
				'id' => null,
			), $atts, 'dealmaker' 
		);

		$makerId = null;
		if($atts['id'] !== null){
			$makerId = intval($atts['id']);
			require_once plugin_dir_path( __FILE__ )."partials/dealmaker-public-display.php";
		}
		
		return ob_get_clean();
	}

}
