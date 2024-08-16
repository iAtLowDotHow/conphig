<?php namespace Conphig\Extensions\MenuOrganiser\Modules;

class RegisterMenu
{
  public function __construct()
  {
  }

  /**
   * Add a plugin default admin menu.
   *
   * @return void
   */
  public function add_plugin_admin_menu()
  {
    /**
     * If ASE has been activated then add a link to the ASE settings page.
     */
    if (defined('ASENHA_PATH')) {
      $page_hook_suffix_sub_default = add_submenu_page(
        'conphig',
        'ASE link',
        'ASE Settings',
        'manage_options',
        'conphig-shortcut-link-ase',
        array($this, 'redirect_ase'),
        1000
      );
    }
  }

  public function redirect_ase()
  {
    wp_safe_redirect(admin_url('tools.php?page=admin-site-enhancements'));
    exit;
  }


}



