<?php namespace Addons\ReactTest;
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
		// prevd(ADDON_URL_ReactTest);
		// exit;
		// add_action( 'admin_menu', [$this, 'my_plugin_menu_page'] );
		// add_action( 'admin_enqueue_scripts', [$this, 'my_plugin_enqueue_scripts'] );
		// $this->loader
		// ->add_action( 'admin_menu', $this , 'my_plugin_menu_page' )
		// // ->add_action( 'admin_enqueue_scripts', $this, 'my_plugin_enqueue_scripts' )
		// ;
		return $this;
	}

	public function my_plugin_menu_page() {
    add_menu_page(
			'My Plugin',
			'My Plugin',
			'manage_options',
			'my-plugin',
			[$this,'my_plugin_render_menu_page'],
			'dashicons-admin-plugins',
    );
		return $this;
	}

	public function my_plugin_enqueue_scripts() {
    wp_enqueue_script(
			'my-plugin-react-app',
			ADDON_URL_ReactTest . 'react_test/build/static/js/main.js',
			array( 'wp-element' ),
			'1.0.0',
			true
    );

    wp_enqueue_style(
        'my-plugin-react-app',
        plugins_url( 'my-plugin/build/static/css/main.css' ),
        array(),
        '1.0.0'
    );
	}

	public function my_plugin_render_menu_page() {
    echo '<div id="root"></div>';
	}

}