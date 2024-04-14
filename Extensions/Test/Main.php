<?php namespace Addons\Test;
use Core\Observer as Observer;
use Core\Loader as Loader;
use Addons\Test\Admin\RegisterAdmin;

class Main implements Observer
{
	private $loader;

	/**
	 * Admin Manager.
	 *
	 * @var RegisterAdmin;
	 */
	public $admin_manager;

	public function __construct( $loader )
	{
		// Register Admin.
		$this->admin_manager = new RegisterAdmin();

		$this->register_hooks();

		$this->loader = $loader;
	}

	/**
	 * Registers core hooks.
	 */
	public function register_hooks()
	{
		/**
		 * Add "Dashboard" link to plugins page.
		 */
		add_filter(
			'plugin_action_links_' . ADDON_DIR_TEST . '/sitesettings.php',
			array($this, 'action_links')
		);
	}

	/**
	 * Registers plugin action links.
	 *
	 * @param array $actions A list of actions for the plugin.
	 * @return array
	 */
	public function action_links($actions)
	{
		$settings_link = '<a href="' . esc_url(admin_url('admin.php?page=conphig-test')) . '">' . __('Dashboard', 'conphig') . '</a>';
		array_unshift($actions, $settings_link);

		return $actions;
	}


	public function handle()
	{
		return $this;
	}



}