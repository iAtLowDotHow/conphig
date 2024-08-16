<?php namespace Conphig\Extensions\SecurityResets;
use Conphig\Core\Observer as Observer;
use Conphig\Core\Loader as Loader;
use Conphig\Extensions\SecurityResets\Modules\DisablePluginEditor;

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
		// $rowActions = new RowActions();
		// $stylesScripts = new StylesScripts();

		// $this->loader
		// ->add_action( 'admin_init', $stylesScripts, 'enqueue_admin_styles_scripts' )
		// ->add_filter('admin_body_class', $this, 'add_admin_body_class')
		// ->add_filter('page_row_actions', $rowActions, 'modify_row_actions', 999, 2)
		// ->add_filter('post_row_actions', $rowActions, 'modify_row_actions', 999, 2)
		// ;

		DisablePluginEditor::get_instance()->set_disabled();

		return $this;
	}

}