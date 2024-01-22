<?php namespace Addons\ACF;
use Core\Observer as Observer;
use Core\Loader as Loader;

class Main implements Observer
{
	private $loader;

	public function __construct( $loader )
	{
		// Set custom load & save JSON points for ACF sync.
		require 'includes/acf-json.php';
		// Register blocks and other handy ACF Block helpers.
		require 'includes/acf-blocks.php';
		// Register a default "Site Settings" Options Page.
		require 'includes/acf-settings-page.php';
		// Restrict access to ACF Admin screens.
		require 'includes/acf-restrict-access.php';
		// Display and template helpers.
		require 'includes/template-tags.php';

		$this->loader = $loader;
	}

	public function handle()
	{

		// $this->loader
		// ->add_action( 'template_redirect', $this, 'routing_rules' )
		// ->add_action( 'admin_init', $this, 'restrict_admin_with_redirect', 1 );

		return $this;
	}

}