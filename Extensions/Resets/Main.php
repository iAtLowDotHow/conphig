<?php namespace Addons\Resets;
use Core\Observer as Observer;
use Core\Loader as Loader;
use Addons\Resets\Features as Features;

class Main implements Observer
{
	private $loader;

	public function __construct( $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{

		$disable_emoji = new Features\DisableEmoji( $this->loader );
		$this->loader->add_action( 'init', $disable_emoji, 'disable_emoji' );

		$disable_jquery_migrate = new Features\DisableJqueryMigrate( $this->loader );
		$this->loader->add_action( 'wp_default_scripts', $disable_jquery_migrate, 'disable_jquery_migrate' );

		return $this;
	}
}