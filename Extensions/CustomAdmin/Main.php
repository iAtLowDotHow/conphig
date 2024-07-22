<?php namespace Conphig\Extensions\CustomAdmin;
use Conphig\Core\Observer as Observer;
use Conphig\Core\Loader as Loader;

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

		$this->loader
		->add_action( 'admin_init', $this, 'enqueue_admin_styles_scripts' )
		->add_filter('admin_body_class', $this, 'add_admin_body_class')
		// ->add_action( 'admin_init', $this, 'restrict_admin_with_redirect', 1 );
		;

		return $this;
	}



	public function add_admin_body_class($classes) {
    $classes .= ' conphig-admin ';
    return $classes;
	}




	public function enqueue_admin_styles_scripts()
	{
		// wp_register_style(
		// 	 "conphig_met_tw",
		// 	trailingslashit(WP_CONTENT_URL) . 'mu-plugins/conphig/assets/css/styles.css',
		// 	array(),
		// 	'3.4.4'
		// );
		wp_register_style(
			"custom_admin",
			// trailingslashit( plugin_dir_url( __FILE__ ) ) . 'assets/css/custom-admin.min.css',
			trailingslashit(plugin_dir_url(__FILE__)) . 'assets/css/custom-admin.min.css',
			array(),
			'3.4.4'
		);
		wp_enqueue_style("custom_admin");
	}



}