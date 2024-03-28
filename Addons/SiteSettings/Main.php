<?php
/**
 * Primary class file for the SiteSettings.
 *
 * @package SiteSettings
 */

namespace AddOns\SiteSettings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Core\Observer as Observer;
use Addons\SiteSettings\Core\Options;
use Addons\SiteSettings\API\OptionsAPI;
use Addons\SiteSettings\Blocks\RegisterBlocks;
use Addons\SiteSettings\Admin\RegisterAdmin;

/**
 * Class Plugin
 */
class Main implements Observer {
	private $loader;
	/**
	 * Options manager.
	 *
	 * @var Options
	 */
	public $options_manager;

	/**
	 * Options API manager.
	 *
	 * @var OptionsAPI
	 */
	public $options_api_manager;

	/**
	 * Blocks manager.
	 *
	 * @var RegisterBlocks
	 */
	public $blocks_manager;

	/**
	 * Admin Manager.
	 *
	 * @var RegisterAdmin;
	 */
	public $admin_manager;

	/**
	 * Constructor.
	 */
	public function __construct( $loader ) {
		// Get options manager instance.
		$this->options_manager = Options::get_instance();

		// Register APIs.
		$this->options_api_manager = new OptionsAPI();

		// Register Blocks.
		$this->blocks_manager = new RegisterBlocks();

		// Register Admin.
		$this->admin_manager = new RegisterAdmin();

		$this->register_hooks();

		$this->loader = $loader;
	}

	/**
	 * Registers core hooks.
	 */
	public function register_hooks() {
		/**
		 * Add "Dashboard" link to plugins page.
		 */
		add_filter(
			'plugin_action_links_' . ADDON_DIR_SITESETTINGS . '/sitesettings.php',
			array( $this, 'action_links' )
		);
	}

	/**
	 * Registers plugin action links.
	 *
	 * @param array $actions A list of actions for the plugin.
	 * @return array
	 */
	public function action_links( $actions ) {
		$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=conphig-sitesettings' ) ) . '">' . __( 'Dashboard', 'conphig' ) . '</a>';
		array_unshift( $actions, $settings_link );

		return $actions;
	}

	/**
	 * Plugin deactivation hook.
	 *
	 * @access public
	 * @static
	 */
	public static function plugin_activation() {
		// Clear the permalinks in case any new post types has been registered.
		flush_rewrite_rules();
	}

	/**
	 * Plugin deactivation hook.
	 *
	 * @access public
	 * @static
	 */
	public static function plugin_deactivation() {
	}

	public function handle()
	{

		// $this->loader
		// ->add_action( 'template_redirect', $this, 'routing_rules' )
		// ->add_action( 'admin_init', $this, 'restrict_admin_with_redirect', 1 );

		return $this;
	}
}
