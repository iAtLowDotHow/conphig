<?php namespace Addons\Resets;
use Core\Observer as Observer;
use Core\Loader as Loader;

class Main implements Observer
{
	private $loader;

	public function __construct( $loader )
	{
		$this->loader = $loader;
	}

	public function handle()
	{
		// $this->loader
		// ->add_action( 'template_redirect', $this, 'routing_rules' )
		// ->add_action( 'admin_init', $this, 'restrict_admin_with_redirect', 1 );
		if( function_exists('acf_add_options_page') ) {

			acf_add_options_page(array(
				'page_title' 	=> 'Resets',
				'menu_title'	=> 'Resets',
				'menu_slug' 	=> 'conphig-resets',
				'capability'	=> 'manage_options',
				'redirect'		=> false
			));

		}
		return $this;
	}

}