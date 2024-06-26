<?php
use Conphig\Extensions\ACF\Main as ACF;

/**
 * ACF Blocks helpers.
 *
 * @link https://www.advancedcustomfields.com/resources/blocks/
 */

add_action( 'init', 'conphig_addon_acf_blocks_register', 5 );
add_filter( 'block_categories_all', 'conphig_addon_acf_block_category' );
add_filter( 'acf/blocks/no_fields_assigned_message', 'conphig_addon_acf_block_no_fields_msg', 10, 2 );

/**
 * Register our ACF Blocks.
 *
 * @link https://www.advancedcustomfields.com/resources/whats-new-with-acf-blocks-in-acf-6/
 *
 * @return void
 *
 * @since 0.1.1
 */
function conphig_addon_acf_blocks_register() {
	$blocks = conphig_addon_acf_get_blocks();

	/**
	 * Loop through /block directory,
	 * and look for
	 *   /block-one/block.json
	 *   /block-two/block.json
	 */
	foreach ( $blocks as $block ) {
		$block_json_filepath = ACF::dir( 'acf-json/field-groups'. '/blocks/' . $block );
		if ( file_exists(ACF::dir( $block_json_filepath ) ) ) {
			/**
			 * We register our block's with WordPress's handy
			 * register_block_type();
			 *
			 * @link https://developer.wordpress.org/reference/functions/register_block_type/
			 */
			register_block_type($block_json_filepath );
		}
	}
}

/**
 * Loop through and check for blocks.
 * We set an option to try and avoid this check
 * being run every page load.
 *
 * @return array $blocks Indexed array of blocks.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_get_blocks() {
	// Check for options.
	$blocks  = get_option( 'conphig_addon_acf_blocks' );
	$version = get_option( 'conphig_addon_acf_blocks_version' );

	if ( empty( $blocks ) || version_compare( Conphig::VERSION, $version ) || ( function_exists( 'wp_get_environment_type' ) && 'production' !== wp_get_environment_type() ) ) {
		$blocks = scandir( ACF::dir('blocks') );
		$blocks = array_values( array_diff( $blocks, array( '..', '.', '.DS_Store' ) ) );

		// Update our options.
		update_option( 'conphig_addon_acf_blocks', $blocks );
		update_option( 'conphig_addon_acf_blocks_version', Conphig::VERSION );
	}

	return $blocks;
}

/**
 * Register a custom block category for our blocks.
 *
 * @link https://developer.wordpress.org/reference/hooks/block_categories_all/
 *
 * @param array  $block_categories Existing block categories
 *
 * @return array Block categories
 *
 * @since 0.1.1
 */
function conphig_addon_acf_block_category( $block_categories ) {

	$block_categories = array_merge(
		array(
			array(
				'slug'  => 'hows-ss-blocks',
				'title' => __( 'ACF Blocks', 'hows-ss-blocks' ),
			),
		),
		$block_categories,
	);

	return $block_categories;
}

/**
 * Add a custom message for an ACF Block in the editor sidebar
 * if it has no field group assigned.
 *
 * @link https://www.advancedcustomfields.com/resources/whats-new-with-acf-blocks-in-acf-6/#blocks-without-fields
 *
 * @param   string $message The default incoming message from ACF.
 * @param   string $block_name The block name current being rendered.
 *
 * @return  string The html that makes up a block form with no fields.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_block_no_fields_msg( $message, $block_name ) {
	if ( 'acf/phone-number' === $block_name ) {
		$message = sprintf(
			/* translators: %s: an admin URL to the field group edit screen */
			__( 'Edit the phone number in the <a href="%s" target="_blank">Site Settings</a>.', 'hows-ss' ),
			admin_url( 'admin.php?page=contact-information' )
		);
	}

	return $message;
}
