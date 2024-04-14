<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://low.how
 * @since      1.0.0
 *
 * @package    Conphig
 * @subpackage Conphig/includes
 */

use Conphig\Core as Core;
use Conphig\Extensions as Ext;

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
 * @package    Conphig
 * @subpackage Conphig/includes
 * @author     How <i@low.how>
 */
class Conphig {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Conphig_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;


	protected $core_loader;
	protected $extensions_loader;

	public const VERSION = '1.0.0';
	public const PLUGIN_NAME = 'conphig';
	public const ADMIN_MENU_SLUG = 'conphig';
	public const SLUG_DELIMITER = '-';
	public const DIR_CORE = 'Core';
	public const DIR_EXTENSIONS = 'Extensions';
	public const DIR_ADMIN = self::DIR_CORE . '/Admin';
	public const DIR_ADMIN_CLASSIC = self::DIR_ADMIN . '/classic';
	public const DIR_ADMIN_MODERN = self::DIR_ADMIN . '/modern';

	public static $extensions = [];


	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->plugin_name = self::PLUGIN_NAME;

		$this->core_loader = new Core\Loader();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->attach_core_loadables();
		$this->attach_extensions();
		$this->loader->run();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Conphig_Loader. Orchestrates the hooks of the plugin.
	 * - Conphig_i18n. Defines internationalization functionality.
	 * - Conphig_Admin. Defines all hooks for the admin area.
	 * - Conphig_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-conphig-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-conphig-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'Admin/classic/class-conphig-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path(dirname(dirname(__FILE__))) . 'public/class-conphig-public.php';

		$this->loader = new Conphig_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Conphig_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Conphig_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Conphig_Admin();

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Conphig_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Attach core loadables. These loadables belongs to the core of the plugin. They must be present and loaded before any addon.
	 * Core loadables must not be edited.
	 *
	 * @return void
	 */
	private function attach_core_loadables() {
		//$conphig_dashboard = new Core\ConphigDashboard($this->core_loader);

	}

	/**
	 * Attach all Addons to the Loader.
	 *
	 * @return void
	 */
	private function attach_extensions() {

		$this->extensions_loader = new Core\ExtensionsLoader();
		/**
		 * Autoload all Addons
		 * Scan the Addons directory for folders and load their Main class.
		 */
		// $addonFolders = [];

		// // Get path to Addons namespace
		// $addonsPath = plugin_dir_path( dirname( __FILE__ ) ) . $namespace;

		// // Scan directory for folders
		// $dir = new DirectoryIterator($addonsPath);
		// foreach ($dir as $fileInfo) {
		// 	if($fileInfo->isDir() && !$fileInfo->isDot()) {
		// 		$addonFolders[] = $fileInfo->getFilename();
		// 	}
		// }

		// sort($addonFolders);

		// foreach ($addonFolders as $addon) {
		// 	$className = '\\'.$namespace . '\\' . $addon .'\\Main';
		// 	if (class_exists($className)) {


		// 		define("ADDON_DIR_".$addon, $addonsPath. '/'. $addon . '/');
		// 		define("ADDON_URL_".$addon, plugin_dir_url(dirname(__FILE__)) . "Addons/$addon/" );

		// 		$this->extensions_loader->attach( new $className($this->loader) );

		// 	}
		// }

		/** Addons: Site Settings */
		// if (class_exists(Addons\SiteSettings\Main::class)) {
		// 	define("ADDON_SLUG_SITESETTINGS", CONPHIG_SLUG . '-sitesettings');
		// 	define("ADDON_DIR_SITESETTINGS", trailingslashit(CONPHIG_DIR) . 'Addons/SiteSettings');
		// 	define("ADDON_URL_SITESETTINGS", trailingslashit(CONPHIG_URL) . 'Addons/SiteSettings');
		// 	$this->extensions_loader->attach(new Addons\SiteSettings\Main($this->loader));
		// }

		/** Addons: Test */
		// if (class_exists(Addons\Test\Main::class)) {
		// 	define("ADDON_SLUG_TEST", CONPHIG_SLUG . '-test');
		// 	define("ADDON_DIR_TEST", trailingslashit(CONPHIG_DIR) . 'Addons/Test');
		// 	define("ADDON_URL_TEST", trailingslashit(CONPHIG_URL) . 'Addons/Test');
		// 	$this->extensions_loader->attach(new Addons\Test\Main($this->loader));
		// }

		/** Addons: ACF */
		if ( class_exists( Ext\ACF\Main::class ) ) {
			$acf = new Ext\ACF\Main( $this->loader );
			$this->extensions_loader->attach( $acf );
		}

		/** Addons: Resets */
		// if (class_exists(Addons\Resets\Main::class)) {
		// 	define("ADDON_SLUG_RESETS", CONPHIG_SLUG . '-resets');
		// 	define("ADDON_DIR_RESETS", trailingslashit(CONPHIG_DIR) . 'Addons/Resets');
		// 	define("ADDON_URL_RESETS", trailingslashit(CONPHIG_URL) . 'Addons/Resets');
		// 	$this->extensions_loader->attach(new Addons\Resets\Main($this->loader));
		// }

		/** Addons: Docs */
		// if (class_exists(Addons\Docs\Main::class)) {
		// 	define("ADDON_SLUG_DOCS", CONPHIG_SLUG . '-docs');
		// 	define("ADDON_DIR_DOCS", trailingslashit(CONPHIG_DIR) . 'Addons/Docs');
		// 	define("ADDON_URL_DOCS", trailingslashit(CONPHIG_URL) . 'Addons/Docs');
		// 	$this->extensions_loader->attach(new Addons\Docs\Main($this->loader));
		// }





		$this->extensions_loader->load();

	}




	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Conphig_Loader    Orchestrates the hooks of the plugin.
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
