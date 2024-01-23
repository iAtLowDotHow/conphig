<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://low.how
 * @since      1.0.0
 *
 * @package    Conphig
 * @subpackage Conphig/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Conphig
 * @subpackage Conphig/admin
 * @author     How <i@low.how>
 */
class Conphig_Admin {

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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Conphig_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conphig_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/conphig-admin.css', array(), $this->version, 'all' );

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
		 * defined in Conphig_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Conphig_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/conphig-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_plugin_admin_menu() {
		add_menu_page(
      'Conphig',
			'Conphig',
      'manage_options',
      'conphig',
      [$this,'conphig_dashboard_page'],
      "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNTQuMzMgMzU0LjMzIj48cGF0aCBkPSJNMjcwLjI1LDIwOGE5MC4zNSw5MC4zNSwwLDEsMSwuMy02Ni4zN2w2MS44NC0yNC41M2ExNTYuODcsMTU2Ljg3LDAsMSwwLC4xNiwxMTUuMzRaIiBzdHlsZT0iZmlsbDojMjMxZjIwIi8+PHBhdGggZD0iTTE2Mi42LDIwMi42N2EyOS45MSwyOS45MSwwLDAsMS0yMS4xNS01MUEyOC43NiwyOC43NiwwLDAsMSwxNjIuNiwxNDNoNDkuNzZhMjkuOTEsMjkuOTEsMCwwLDEsMjEuMTYsNTEsMjguOCwyOC44LDAsMCwxLTIxLjE2LDguNzFabTAtOS45NWg0OS43NmExOS45MSwxOS45MSwwLDAsMCwwLTM5LjgySDE2Mi42YTE5LjkxLDE5LjkxLDAsMCwwLDAsMzkuODJabTQ5Ljc2LTVhMTQuODksMTQuODksMCwxLDAtMTAuNTctNC4zNkExNC4zOCwxNC4zOCwwLDAsMCwyMTIuMzYsMTg3Ljc0WiIgc3R5bGU9ImZpbGw6IzAxMDEwMSIvPjwvc3ZnPg=="
    );
	}

	public function conphig_dashboard_page() {
		// include ADDON_ReactTest_DIR . 'react_test/build/index.html';
    echo 'hello world';
  }

}
