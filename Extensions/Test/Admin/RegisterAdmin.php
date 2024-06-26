<?php
/**
 * Admin registration class.
 *
 * @package SiteSettings
 */

namespace Addons\Test\Admin;

use \WP_Admin_Bar;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Automattic\Jetpack\Assets;

/**
 * Class RegisterAdmin
 */
class RegisterAdmin {
	/**
	 * Class constructor.
	 */
	public function __construct() {
		// Register Admin Dashboard.
		add_action( 'admin_menu', array( $this, 'register_admin_dashboard' ) );

		// Handles Admin Bar menu setup and actions.
		$this->setup_admin_bar_menu();
	}

	/**
	 * Register admin dashboard.
	 */
	public function register_admin_dashboard() {
		$primary_slug = ADDON_SLUG_TEST;
		$menu_icon = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNTQuMzMgMzU0LjMzIj48cGF0aCBkPSJNMjcwLjI1LDIwOGE5MC4zNSw5MC4zNSwwLDEsMSwuMy02Ni4zN2w2MS44NC0yNC41M2ExNTYuODcsMTU2Ljg3LDAsMSwwLC4xNiwxMTUuMzRaIiBzdHlsZT0iZmlsbDojMjMxZjIwIi8+PHBhdGggZD0iTTE2Mi42LDIwMi42N2EyOS45MSwyOS45MSwwLDAsMS0yMS4xNS01MUEyOC43NiwyOC43NiwwLDAsMSwxNjIuNiwxNDNoNDkuNzZhMjkuOTEsMjkuOTEsMCwwLDEsMjEuMTYsNTEsMjguOCwyOC44LDAsMCwxLTIxLjE2LDguNzFabTAtOS45NWg0OS43NmExOS45MSwxOS45MSwwLDAsMCwwLTM5LjgySDE2Mi42YTE5LjkxLDE5LjkxLDAsMCwwLDAsMzkuODJabTQ5Ljc2LTVhMTQuODksMTQuODksMCwxLDAtMTAuNTctNC4zNkExNC4zOCwxNC4zOCwwLDAsMCwyMTIuMzYsMTg3Ljc0WiIgc3R5bGU9ImZpbGw6IzAxMDEwMSIvPjwvc3ZnPg==";

		$dashboard_page_suffix = add_menu_page(
			_x( 'Test Dashboard', 'Page title', 'conphig' ),
			_x( 'Test Page', 'Menu title', 'conphig' ),
			'manage_options',
			$primary_slug,
			array( $this, 'plugin_dashboard_page' ),
			$menu_icon
		);

		// Register dashboard hooks.
		add_action( 'load-' . $dashboard_page_suffix, array( $this, 'dashboard_admin_init' ) );

		// Register dashboard submenu nav item.
		add_submenu_page($primary_slug, 'Conphig Test', 'Test', 'manage_options', $primary_slug . '#/test', '__return_null' );

		// Remove duplicate menu hack.
		// Note: It needs to go after the above add_submenu_page call.
		// remove_submenu_page( $primary_slug, $primary_slug );

		// // Register getting started aka onboarding submenu nav item.
		// add_submenu_page( $primary_slug, 'SiteSettings Dashboard', 'Getting Started', 'manage_options', $primary_slug . '#/getting-started', '__return_null' );

		// // Register settings submenu nav item.
		// add_submenu_page( $primary_slug, 'SiteSettings Dashboard', 'Settings', 'manage_options', $primary_slug . '#/settings', '__return_null' );
	}

	/**
	 * Initialize the Dashboard admin resources.
	 */
	public function dashboard_admin_init() {
		// add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_dashboard_admin_scripts' ) );
	}

	/**
	 * Enqueue plugin admin scripts and styles.
	 */
	public function enqueue_dashboard_admin_scripts() {
		$prefix = ADDON_SLUG_TEST;

		Assets::register_script(
			$prefix . '-dashboard',
			'build/test/index.js',
			CONPHIG_ROOT_FILE,
			array(
				'in_footer'  => true,
				'textdomain' => 'conphig',
			)
		);

		// Enqueue app script.
		Assets::enqueue_script( $prefix . '-dashboard' );
		// Initial JS state.
		wp_add_inline_script( $prefix . '-dashboard', $this->render_dashboard_initial_state(), 'before' );
	}

	/**
	 * Render the initial state into a JavaScript variable.
	 *
	 * @return string
	 */
	public function render_dashboard_initial_state() {
		return 'var vajraPluginState=JSON.parse(decodeURIComponent("' . rawurlencode( wp_json_encode( $this->initial_dashboard_state() ) ) . '"));';
	}

	/**
	 * Get the initial state data for hydrating the React UI.
	 *
	 * @return array
	 */
	public function initial_dashboard_state() {
		return array(
			'apiRoute'     => CONPHIG_SLUG . '/v1',
			'assetsURL'    => CONPHIG_URL . '/assets',
			// You can also replace this changelog URL to something else so that it loads from one source and stays up-to-date always.
			'changelogURL' => CONPHIG_URL . '/changelog.json?ver=' . filemtime( CONPHIG_DIR . '/changelog.json' ),
			'version'      => CONPHIG_VERSION,
		);
	}

	/**
	 * Plugin Dashboard page.
	 */
	public function plugin_dashboard_page() {
		?>
			<div id="conphig-sitesettings-dashboard-root"></div>
		<?php
	}

	/**
	 * Sets up admin bar and related functions.
	 *
	 * @return void
	 */
	public function setup_admin_bar_menu() {

		// Register admin bar menu.
		// Priority level is 1000 intentionally so that it shows up.
		add_action( 'admin_bar_menu', array( $this, 'register_admin_bar_menu' ), 1000 );

		// AJAX action handler for flushing permalinks.
		$action_key = CONPHIG_SLUG . '_flush_rules';
		add_action( 'wp_ajax_' . $action_key, array( $this, 'process_permalinks_flush' ) );
	}

	/**
	 * Register admin bar menu.
	 *
	 * @param WP_Admin_Bar $admin_bar The WP_Admin_Bar instance.
	 *
	 * @return void
	 */
	public function register_admin_bar_menu( WP_Admin_Bar $admin_bar ) {
		$prefix         = CONPHIG_SLUG;
		$parent_menu_id = $prefix . '-dashboard';

		$admin_bar->add_menu(
			array(
				'id'     => $parent_menu_id,
				'parent' => null,
				'title'  => __( 'Test page', 'conphig' ),
				'href'   => esc_url( admin_url( 'admin.php?page=' . $prefix ) ),
			)
		);

		$nonce = wp_create_nonce( $prefix . '_flush_rules' );

		$admin_bar->add_menu(
			array(
				'parent' => $parent_menu_id,
				'id'     => $prefix . '-flush-rewrite-rules',
				'title'  => __( 'Flush Permalinks', 'conphig' ),
				'href'   => esc_url( admin_url( 'admin-ajax.php?action=' . $prefix . '_flush_rules&nonce=' . $nonce ) ),
			)
		);
	}

	/**
	 * Handles flush permalinks AJAX action from admin bar menu.
	 *
	 * @return void
	 */
	public function process_permalinks_flush() {
		$prefix    = CONPHIG_SLUG;
		$nonce_key = $prefix . '_flush_rules';

		// Do something.
		if ( ! check_ajax_referer( $nonce_key, 'nonce' ) ) {
			exit( 'Unauthorized' );
		}

		// Clear the permalinks in case any changes in permalinks or CPTs.
		flush_rewrite_rules();

        // phpcs:ignore.
		$redirect_uri = wp_unslash( $_SERVER['HTTP_REFERER'] ) && ! empty( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : admin_url( 'admin.php?page=' . $prefix );

		wp_safe_redirect( esc_url( $redirect_uri ) );
		die();
	}
}
