<?php namespace Conphig\Extensions\CustomAdmin\Modules;

class RowActions
{
  public function __construct()
  {
  }

  public function modify_row_actions($actions, $post)
  {
    // if (isset($actions['edit'])) {
    //   $actions['edit'] = sprintf(
    //     '<a href="%s">%s</a>',
    //     get_edit_post_link($post->ID),
    //     '<span class="dashicons dashicons-edit-page"></span>'
    //   );
    // }

    if (isset($actions['edit'])) {
      $actions['edit'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="dashicons dashicons-edit-large" title="Edit"></span>' . '</a>',
        $actions['edit']
      );
    }

    // if (isset($actions['inline hide-if-no-js'])) {
    //   // The class 'dashicons-edit' is a pencil icon from WordPress Dashicons
    //   $actions['inline hide-if-no-js'] = sprintf(
    //     '<a href="#" class="editinline" aria-label="%s" title="%s">%s</a>',
    //     esc_attr__('Quick edit &#8220;' . $post->post_title . '&#8221; inline'),
    //     esc_attr__('Quick edit &#8220;' . $post->post_title . '&#8221; inline'),
    //     '<span class="dashicons dashicons-edit-large" aria-hidden="true"></span>'
    //   );
    // }

    if (isset($actions['inline hide-if-no-js'])) {
      $actions['inline hide-if-no-js'] = sprintf(
        '<a href="#" class="editinline" aria-label="%s" title="%s">%s</a>',
        esc_attr__('Quick edit &#8220;' . $post->post_title . '&#8221; inline'),
        esc_attr__('Quick edit &#8220;' . $post->post_title . '&#8221; inline'),
        '<span class="material-symbols-rounded">edit_square</span>'
      );
    }

    if (isset($actions['trash'])) {
      $actions['trash'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="dashicons dashicons-trash"></span>' . '</a>',
        $actions['trash']
      );
    }

    if (isset($actions['view'])) {
      $actions['view'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="dashicons dashicons-visibility"></span>' . '</a>',
        $actions['view']
      );
    }

    if (isset($actions['brx_duplicate'])) {
      $actions['brx_duplicate'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Bricks Duplicate">file_copy</span>' . '</a>',
        $actions['brx_duplicate']
      );
    }

    if (isset($actions['edit_with_bricks'])) {
      $actions['edit_with_bricks'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="icon-conphig icon-conphig-bricks" title="Edit with Bricks"></span>' . '</a>',
        $actions['edit_with_bricks']
      );
    }

    if (isset($actions['untrash'])) {
      $actions['untrash'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="dashicons dashicons-undo"></span>' . '</a>',
        $actions['untrash']
      );
    }

    if (isset($actions['delete'])) {
      $actions['delete'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="dashicons dashicons-remove"></span>' . '</a>',
        $actions['delete']
      );
    }


    /**
     * ACF Actions
     */
    if (isset($actions['acfduplicate'])) {
      $actions['acfduplicate'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Duplicate">file_copy</span>' . '</a>',
        $actions['acfduplicate']
      );
    }

    if (isset($actions['acfdeactivate'])) {
      $actions['acfdeactivate'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Deactivate">toggle_off</span>' . '</a>',
        $actions['acfdeactivate']
      );
    }

    if (isset($actions['acfactivate'])) {
      $actions['acfactivate'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Activate">toggle_on</span>' . '</a>',
        $actions['acfactivate']
      );
    }

    if (isset($actions['sync'])) {
      $actions['sync'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Sync">sync</span>' . '</a>',
        $actions['sync']
      );
    }

    if (isset($actions['review'])) {
      $actions['review'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Review Changes">manage_history</span>' . '</a>',
        $actions['review']
      );
    }

    if (isset($actions['resetpassword'])) {
      $actions['resetpassword'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Send password reset">lock_reset</span>' . '</a>',
        $actions['resetpassword']
      );
    }

    if (isset($actions['switch_to_user'])) {
      $actions['switch_to_user'] = preg_replace(
        '/>(.*?)<\/a>/',
        '>' . '<span class="material-symbols-rounded" title="Switch To">wifi_protected_setup</span>' . '</a>',
        $actions['switch_to_user']
      );
    }

    return $actions;
  }


}



