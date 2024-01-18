<?php
// use Core as C;
// Use Addons as A;

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
		if ( defined( 'CONPHIG_VERSION' ) ) {
			$this->version = CONPHIG_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'conphig';

		$this->core_loader = new Core\Loader();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->attach_addons();

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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-conphig-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-conphig-public.php';

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

		$plugin_admin = new Conphig_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

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


	private function attach_addons() {
	//get all folder names in namespace Addons
		// $parentFolder = FW_THEME_DIR.'page-templates';
		// $filePattern = 'Module*.php';

		// $this->requireFilesRecursively($parentFolder, $filePattern);

		// foreach ($this->namespaces as $namespace) {
		// 	$className = '\\'.$namespace . '\\ModuleAjax';
		// 	$this->extensionLoader
		// 	->attach( new $className( $this->loader ) )
		// 	->load();
		// }
		$namespace = 'Addons';

		$this->addon_loader = new Core\AddonLoader();
		// $test = new Addons\Test();
		$addonFolders = [];

		// Get path to Addons namespace
		$addonsPath = plugin_dir_path( dirname( __FILE__ ) ) . '/' . $namespace;

		// Scan directory for folders
		$dir = new DirectoryIterator($addonsPath);
		foreach ($dir as $fileInfo) {
			if($fileInfo->isDir() && !$fileInfo->isDot()) {
				$addonFolders[] = $fileInfo->getFilename();
			}
		}

		sort($addonFolders);

		foreach ($addonFolders as $addon) {
			$className = '\\'.$namespace . '\\' . $addon .'\\Main';
			if (class_exists($className)) {
				$this->addon_loader->attach( new $className($this->core_loader) );
			}
		}

		$this->addon_loader->load();
	}

	private function requireFilesRecursively($folder, $filePattern){
		$files = glob($folder . '/*', GLOB_ONLYDIR);

    foreach ($files as $childFolder) {
			$filePattern_new = $childFolder . '/' . $filePattern;
			$moduleFiles = glob($filePattern_new);

			foreach ($moduleFiles as $file) {
				$namespace = $this->extractNamespaces($file);
				// var_dump($namespace);
				// echo '<br>';
				if (!empty($namespace)) {
					$this->namespaces[] = $namespace;
				}

				// var_dump($file);
				// echo '<br>';

				// echo '<br>';
				require_once $file;
			}

			// Recursively search child folders
			$this->requireFilesRecursively($childFolder, $filePattern);
    }
	}



	private function extractNamespaces($file) {
    $content = file_get_contents($file);
    $matches = [];

    // Use regular expression to find the namespace declaration.
    if (preg_match('/namespace\s+([^\s;]+);/', $content, $matches)) {
      return $matches[1];
    }

    return ''; // Return an empty string if no namespace is found.
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
