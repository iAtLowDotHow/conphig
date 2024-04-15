<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://low.how
 * @since             1.0.0
 * @package           Conphig
 *
 * @wordpress-plugin
 * Plugin Name:       Conphig
 * xx Plugin URI:        https://components.low.how/conphig
 * Description:       Standard configuration for all WordPress in-HOWS setup.
 * Version:           1.0.0
 * Author:            How
 * Author URI:        https://low.how/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       conphig
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */

require_once plugin_dir_path(__FILE__) . 'Core/includes/functions/index.php';

$conphig_autoloader = plugin_dir_path(__FILE__) . 'vendor/autoload_packages.php';
if (is_readable($conphig_autoloader)) {
	require_once $conphig_autoloader;

} else { // Something very unexpected. Error out gently with an admin_notice and exit loading.
	if (defined('WP_DEBUG') && WP_DEBUG) {
		error_log( // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
			__('Error loading autoloader file for Conphig plugin', 'conphig')
		);
	}

	add_action(
		'admin_notices',
		function () {
?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: Placeholder is a link to a support document. */
						__('Your installation of Conphig is incomplete. If you installed Conphig from GitHub, please refer to <a href="%1$s" target="_blank" rel="noopener noreferrer">this document</a> to set up your development environment. Conphig must have Composer dependencies installed and built via the build command.', 'conphig'),
						array(
							'a' => array(
								'href'   => array(),
								'target' => array(),
								'rel'    => array(),
							),
						)
					),
					'https://github.com/'
				);
				?>
			</p>
		</div>
		<?php
		}
	);

	return;
}



/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-conphig-activator.php
 */
function activate_conphig()
{
	require_once plugin_dir_path(__FILE__) . '/Core/includes/class-conphig-activator.php';
	Conphig_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-conphig-deactivator.php
 */
function deactivate_conphig()
{
	require_once plugin_dir_path(__FILE__) . '/Core/includes/class-conphig-deactivator.php';
	Conphig_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_conphig');
register_deactivation_hook(__FILE__, 'deactivate_conphig');


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_conphig()
{
	/**
	 * Bootstrapping Composer Autoloading for namespaces
	 */
	require_once plugin_dir_path(__FILE__) . 'Core/includes/class-conphig.php';
	if (class_exists('Conphig')) {
		(new Conphig())->run();
	}

}
run_conphig();