<?php namespace Conphig\Extensions\Resets\Features;

class LimitRevisions{

	public static function  set_max( $limit = 3 ){
    if (!defined('WP_POST_REVISIONS') ) {
      define('WP_POST_REVISIONS', $limit);
    }

	}
}