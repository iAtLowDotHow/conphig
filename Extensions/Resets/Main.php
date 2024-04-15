<?php namespace Conphig\Extensions\Resets;

use Conphig\Core\Observer as Observer;
use Conphig\Core\Loader as Loader;
use Conphig\Extensions\Resets\Features as Features;

class Main implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{

		$disable_emoji = new Features\DisableEmoji();
		$this->loader->add_action('init', $disable_emoji, 'disable_emoji');

		$disable_jquery_migrate = new Features\DisableJqueryMigrate();
		$this->loader->add_action( 'wp_default_scripts', $disable_jquery_migrate, 'disable_jquery_migrate' );

		// var_dump(Conphig::$extensions);

		$admin_bar = new Features\AdminBar();
		$this->loader
		->add_filter('admin_bar_menu', $admin_bar, 'modify_admin_bar_menu', 5)
		->add_action('admin_head', $admin_bar, 'hide_help_drawer')
		;

		// var_dump(Conphig::$extensions);
		// exit;

		return $this;
	}
}