<?php namespace Conphig\Extensions\CustomAdmin\Modules;

class StylesScripts
{
  public function __construct()
  {
  }

  public function enqueue_admin_styles_scripts()
  {
    wp_register_style(
      "material_icons",
      "https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200",
      array(),
      null
    );

    wp_register_style(
      "custom_admin",
      trailingslashit( plugin_dir_url( dirname(__FILE__) ) ) . 'assets/css/custom-admin.min.css',
      array('material_icons'),
      '3.4.4'
    );
    wp_enqueue_style("custom_admin");
  }
}