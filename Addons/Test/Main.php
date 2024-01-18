<?php namespace Addons\Test;
use Core\Observer as Observer;
use Core\Loader as Loader;

class Main implements Observer
{
	private $loader;

	public function __construct( Loader $loader )
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
				'page_title' 	=> 'CPMS General Settings',
				'menu_title'	=> 'CPMS Settings',
				'menu_slug' 	=> 'cpms-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> false
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> 'REN Settings',
				'menu_title'	=> 'REN Settings',
				'parent_slug'	=> 'cpms-general-settings',
			));

			acf_add_options_sub_page(array(
				'page_title' 	=> 'System Settings',
				'menu_title'	=> 'System Settings',
				'parent_slug'	=> 'cpms-general-settings',
			));

		}
		return $this;
	}

}