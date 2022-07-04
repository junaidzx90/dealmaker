<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Dealmaker
 * @subpackage Dealmaker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Dealmaker
 * @subpackage Dealmaker/admin
 * @author     Developer Junayed <admin@easeare.com>
 */
class Dealmaker_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/dealmaker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/dealmaker-admin.js', array( 'jquery' ), $this->version, false );
	}

	function dm_menupage(){
		add_menu_page( "dealmaker", "dealmaker", "manage_options", "dealmaker", [$this, "dealmaker_makers"], "dashicons-nametag", 45 );
		add_submenu_page( "dealmaker", "Makers", "Makers", "manage_options", "dealmaker", [$this, "dealmaker_makers"]);
		add_submenu_page( "dealmaker", "Add new", "Add new", "manage_options", "new-maker", [$this, "dealmaker_newmaker"]);
		add_submenu_page( "dealmaker", "Settings", "Settings", "manage_options", "dealmaker-setting", [$this, "dealmaker_setting_page"]);

		add_settings_section( 'general_dm_opt_section', '', '', 'general_opt_dm_page' );
		
		add_settings_field( 'dealmaker_shortcode', 'Shortcode', [$this, 'dealmaker_shortcode_cb'], 'general_opt_dm_page','general_dm_opt_section' );
		// Logo URL
		add_settings_field( 'dealmaker_logo_url', 'Logo URL', [$this, 'dealmaker_logo_url_cb'], 'general_opt_dm_page','general_dm_opt_section' );
		register_setting( 'general_dm_opt_section', 'dealmaker_logo_url' );
		// Privacy page URL
		add_settings_field( 'dealmaker_privacy_page_url', 'Privacy page URL', [$this, 'dealmaker_privacy_page_url_cb'], 'general_opt_dm_page','general_dm_opt_section' );
		register_setting( 'general_dm_opt_section', 'dealmaker_privacy_page_url' );
		// Support email
		add_settings_field( 'dealmaker_support_mail', 'Support email', [$this, 'dealmaker_support_mail_cb'], 'general_opt_dm_page','general_dm_opt_section' );
		register_setting( 'general_dm_opt_section', 'dealmaker_support_mail' );
	}

	function dealmaker_shortcode_cb(){
		echo '<input type="text" readonly value="[dealmaker]">';
	}
	function dealmaker_privacy_page_url_cb(){
		echo '<input type="url" placeholder="URL" name="dealmaker_privacy_page_url" class="widefat" value="'.get_option('dealmaker_privacy_page_url').'">';
	}
	function dealmaker_logo_url_cb(){
		echo '<input type="url" placeholder="URL" name="dealmaker_logo_url" class="widefat" value="'.get_option('dealmaker_logo_url').'">';
	}
	function dealmaker_support_mail_cb(){
		echo '<input type="email" placeholder="Email address" name="dealmaker_support_mail" class="widefat" value="'.get_option('dealmaker_support_mail').'">';
	}


	function dealmaker_makers(){
		if((isset($_GET['page']) && $_GET['page'] === 'dealmaker') && (isset($_GET['action']) && $_GET['action'] === 'manage') && isset($_GET['maker']) && !empty($_GET['maker'])){
			$manage_maker = intval($_GET['maker']);
			require_once plugin_dir_path( __FILE__ )."partials/manage-maker.php";
		}else{
			$makers = new Dealmaker_Makers();
			?>
			<h3>Makers</h3>
			<hr>
			<form action="" method="post">
				<?php
				$makers->prepare_items();
				$makers->display();
				?>
			</form>
			<?php
		}
	}
	function dealmaker_newmaker(){
		require_once plugin_dir_path( __FILE__ )."partials/manage-maker.php";
	}

	function dealmaker_setting_page(){
		echo '<h3>Settings</h3><hr>';
		echo '<form style="width: 75%" action="options.php" method="post">';
		settings_fields( 'general_dm_opt_section' );
		do_settings_sections( 'general_opt_dm_page' );
		submit_button(  );
		echo '</form>';
	}
}
