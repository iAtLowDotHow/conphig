<?php

/**
 * Fired during plugin activation
 *
 * @link       https://low.how
 * @since      1.0.0
 *
 * @package    Conphig
 * @subpackage Conphig/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Conphig
 * @subpackage Conphig/includes
 * @author     How <i@low.how>
 */
class Conphig_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if(!function_exists( 'acf_add_options_page' )) {

			// Add admin notice
			set_transient( 'conphig_activation_error', true );


  	}

	}


}
