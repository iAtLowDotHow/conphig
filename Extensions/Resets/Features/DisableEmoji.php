<?php namespace Conphig\Extensions\Resets\Features;

class DisableEmoji{

	public function  disable_emoji(){
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'embed_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    add_action( 'admin_init', array( $this, 'disable_admin_emojis' ) );
		add_filter( 'emoji_svg_url', '__return_false' );
    add_filter( 'tiny_mce_plugins',[$this, 'disable_emojis_tinymce'] );
	  add_filter( 'wp_resource_hints', [$this, 'disable_emojis_remove_dns_prefetch'], 10, 2 );
	}

  /**
   * Filter function used to remove the tinymce emoji plugin.
   *
   * @param    array  $plugins
   * @return   array  Difference betwen the two arrays
   */
  public function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    }

    return array();
  }

  /**
   * Remove emoji CDN hostname from DNS prefetching hints.
   *
   * @param  array  $urls          URLs to print for resource hints.
   * @param  string $relation_type The relation type the URLs are printed for.
   * @return array                 Difference betwen the two arrays.
   */
  public function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {

    if ( 'dns-prefetch' == $relation_type ) {

      // Strip out any URLs referencing the WordPress.org emoji location
      $emoji_svg_url_bit = 'https://s.w.org/images/core/emoji/';
      foreach ( $urls as $key => $url ) {
        if ( strpos( $url, $emoji_svg_url_bit ) !== false ) {
          unset( $urls[$key] );
        }
      }

    }

    return $urls;
  }

  /**
	 * Disable emojis in wp-admin
	 *
	 * @since 4.7.2
	 */
  public function disable_admin_emojis() {
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
  }
}