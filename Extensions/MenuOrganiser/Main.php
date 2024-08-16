<?php namespace Conphig\Extensions\MenuOrganiser;
use Conphig\Core\Observer as Observer;
use Conphig\Extensions\MenuOrganiser\Modules\RegisterMenu;
use Conphig\Extensions\MenuOrganiser\Modules\ASETweaks;


class Main implements Observer
{
	private $loader;

	public $admin_manager;

	public function __construct( $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		$registerMenu = new RegisterMenu();
		$aSETweaks = new ASETweaks();

		$this->loader
		->add_action( 'admin_menu', $registerMenu, 'add_plugin_admin_menu' )
		->add_action( 'admin_init', $aSETweaks, 'add_gf_cap')
		;

		return $this;
	}
}