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

use Automattic\Jetpack\Assets;

class Conphig_Admin
{

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
	 * Slug for plugin admin interface.
	 *
	 * Can be used to register scripts and styles for this plugin admin interface.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var	string	$slug	Slug for plugin admin interface
	 */
	private $slug;

	/**
	 * Assets values generated by wp-scripts.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var array    $asset_file    Assets values generated by wp-scripts.
	 */
	private $asset_file;

	private $slug_delimiter;
	private $build_dir;
	private $build_url;
	private $view_dir;
	private $menu;
	private $style_handle;
	private $script_handle;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct()
	{
		$this->plugin_name = Conphig::PLUGIN_NAME;
		$this->version = Conphig::VERSION;
		$this->slug_delimiter = Conphig::SLUG_DELIMITER;
		$this->asset_file = include_once  plugin_dir_path(__FILE__) . '/build/index.asset.php';
		$this->slug = $this->plugin_name . $this->slug_delimiter . 'admin' . $this->slug_delimiter . 'classic';
		$this->style_handle = $this->slug;
		$this->script_handle = $this->slug;
		$this->build_dir = plugin_dir_path(__FILE__) . '/build';
		$this->build_url = plugin_dir_url( __FILE__ ) . '/build';
		$this->view_dir = plugin_dir_path(__FILE__) . '/view';

		$this->menu = array(
			'page_title'	=> 'Conphig',
			'menu_title'	=> 'Conphig',
			'menu_slug'	=> Conphig::ADMIN_MENU_SLUG,
			'icon_url'	=> "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNTQuMzMgMzU0LjMzIj48cGF0aCBkPSJNMjcwLjI1LDIwOGE5MC4zNSw5MC4zNSwwLDEsMSwuMy02Ni4zN2w2MS44NC0yNC41M2ExNTYuODcsMTU2Ljg3LDAsMSwwLC4xNiwxMTUuMzRaIiBzdHlsZT0iZmlsbDojMjMxZjIwIi8+PHBhdGggZD0iTTE2Mi42LDIwMi42N2EyOS45MSwyOS45MSwwLDAsMS0yMS4xNS01MUEyOC43NiwyOC43NiwwLDAsMSwxNjIuNiwxNDNoNDkuNzZhMjkuOTEsMjkuOTEsMCwwLDEsMjEuMTYsNTEsMjguOCwyOC44LDAsMCwxLTIxLjE2LDguNzFabTAtOS45NWg0OS43NmExOS45MSwxOS45MSwwLDAsMCwwLTM5LjgySDE2Mi42YTE5LjkxLDE5LjkxLDAsMCwwLDAsMzkuODJabTQ5Ljc2LTVhMTQuODksMTQuODksMCwxLDAtMTAuNTctNC4zNkExNC4zOCwxNC4zOCwwLDAsMCwyMTIuMzYsMTg3Ljc0WiIgc3R5bGU9ImZpbGw6IzAxMDEwMSIvPjwvc3ZnPg==",
			'submenu_title'	=> 'Dashboard',
			'submenu_slug'	=> Conphig::ADMIN_MENU_SLUG . $this->slug_delimiter . 'dashboard',
			'position'	=> '2.5',
		);
	}


	/**
	 * Add a plugin default admin menu.
	 *
	 * @return void
	 */
	public function add_plugin_admin_menu()
	{
		$page_title = $this->menu['page_title'];
		$menu_title = $this->menu['menu_title'];
		$parent_slug = $menu_slug = $this->menu['menu_slug'];
		$menu_icon = $this->menu['icon_url'];
		$submenu_title = $this->menu['submenu_title'];
		$submenu_slug = $this->menu['submenu_slug'];
		$menu_position = $this->menu['position'];

		$page_hook_suffix_top = add_menu_page(
			$page_title,
			$menu_title,
			'manage_options',
			$menu_slug,
			array($this, 'render_admin_page'),
			$menu_icon,
			$menu_position
		);

		$page_hook_suffix_sub_default = add_submenu_page(
			$parent_slug,
			$page_title,
			$submenu_title,
			'manage_options',
			$submenu_slug,
			array($this, 'render_admin_page')
		);

		remove_submenu_page($menu_slug, $menu_slug);

		// Register dashboard hooks.
		add_action('load-' . $page_hook_suffix_top, array($this, 'admin_page_init'));
		add_action('load-' . $page_hook_suffix_sub_default, array($this, 'admin_page_init'));

		// add_action('admin_init', array($this, 'enqueue_general_admin_styles_scripts') );
	}


	/**
	 * Initialize the Dashboard admin resources.
	 */
	public function admin_page_init()
	{
		add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles_scripts'));
	}


	/**
	 * Enqueue plugin admin scripts and styles.
	 */
	public function enqueue_admin_styles_scripts()
	{

		wp_register_style(
			$this->style_handle,
			$this->build_url . '/index.css',
			array(),
			$this->asset_file['version']
		);
		wp_enqueue_style($this->style_handle);


		wp_enqueue_script(
			$this->script_handle,
			$this->build_url . '/index.js',
			array('jquery'),
			$this->asset_file['version'],
			false
		);
	}


	public function render_admin_page()
	{
		require_once $this->view_dir. '/dashboard.php';
	}



	public function enqueue_general_admin_styles_scripts()
	{
		wp_register_style(
			$this->style_handle . "met_tw",
			trailingslashit(WP_CONTENT_URL) . 'mu-plugins/conphig/assets/css/styles.css',
			array(),
			'3.4.4'
		);
		wp_enqueue_style($this->style_handle);
	}
}
