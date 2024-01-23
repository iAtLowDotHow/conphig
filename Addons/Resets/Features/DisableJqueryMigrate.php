<?php namespace Addons\Resets\Features;

class DisableJqueryMigrate{

	/**
	 * Disable jQuery Migrate
	 *
	 * @since 5.8.0
	 * @link https://plugins.trac.wordpress.org/browser/remove-jquery-migrate/trunk/remove-jquery-migrate.php
	 * @param WP_Scripts $scripts WP_Scripts object.
	 */
	public function disable_jquery_migrate( $scripts ) {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];

			if ( ! empty( $script->deps ) ) { // Check whether the script has any dependencies
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	}
}