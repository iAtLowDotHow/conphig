<?php namespace Conphig\Extensions\Resets\Features;

class AdminBar{
  public function remove_wp_logo($wp_admin_bar){
    remove_action('admin_bar_menu', 'wp_admin_bar_wp_menu', 10);
    // priority needs to match default value. Use QM to reference.
  }

  /**
   * Remove 'Howdy' from the admin bar
   *
   * @param [type] $wp_admin_bar
   * @return void
   */
  public function remove_howdy($wp_admin_bar){
    // remove_action('admin_bar_menu', 'wp_admin_bar_wp_menu', 10);
    remove_action('admin_bar_menu', 'wp_admin_bar_my_account_item', 7);
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();
    $profile_url = get_edit_profile_url($user_id);
    $avatar = get_avatar($user_id, 26);
    // size 26x26 pixels
    $display_name = $current_user->display_name;
    $class = ($avatar ? 'with-avatar' : 'no-avatar');
    $wp_admin_bar->add_menu(array(
      'id'     => 'my-account',
      'parent' => 'top-secondary',
      'title'  => $display_name . $avatar,
      'href'   => $profile_url,
      'meta'   => array(
        'class' => $class,
      ),
    ));

  }

  public function modify_admin_bar_menu($wp_admin_bar){
    $remove_howdy = true;
    $remove_wp_logo = true;

    if ($remove_wp_logo){
      remove_action('admin_bar_menu', 'wp_admin_bar_wp_menu', 10);
    }

    /**
     * Remove 'Howdy' from the admin bar
     */
    if ($remove_howdy){
      remove_action('admin_bar_menu', 'wp_admin_bar_my_account_item', 7);
      $current_user = wp_get_current_user();
      $user_id = get_current_user_id();
      $profile_url = get_edit_profile_url($user_id);
      $avatar = get_avatar($user_id, 26);
      // size 26x26 pixels
      $display_name = $current_user->display_name;
      $class = ($avatar ? 'with-avatar' : 'no-avatar');
      $wp_admin_bar->add_menu(array(
        'id'     => 'my-account',
        'parent' => 'top-secondary',
        'title'  => $display_name . $avatar,
        'href'   => $profile_url,
        'meta'   => array(
          'class' => $class,
        ),
      ));
    }
  }

  /**
   * Hide the Help tab and drawer
   *
   * @return void
   */
  public function hide_help_drawer()
  {
    if (is_admin()) {
      $screen = get_current_screen();
      $screen->remove_help_tabs();
    }
  }
}