<?php namespace Conphig\Extensions\MenuOrganiser\Modules;

class ASETweaks
{
  public function __construct()
  {
  }

  /**
   * Add a plugin default admin menu.
   *
   * @return void
   */
  public function add_gf_cap()
  {
    /**
     * If ASE has been activated then add a link to the ASE settings page.
     */
    // if (defined('ASENHA_PATH')) {
      $role = get_role('administrator');
      $role->add_cap('gform_full_access');
      $role = get_role('editor');
      $role->add_cap('gform_full_access');
    // }
  }

}



