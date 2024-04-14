<?php
use Conphig\Extensions\ACF\Main as ACF;
/**
 * ACF Set custom load and save JSON points.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/
 */

add_filter( 'acf/json/load_paths', 'conphig_addon_acf_json_load_paths' );
add_filter( 'acf/settings/save_json/type=acf-field-group', 'conphig_addon_acf_json_save_path_for_field_groups' );
add_filter( 'acf/settings/save_json/type=acf-ui-options-page', 'conphig_addon_acf_json_save_path_for_option_pages' );
add_filter( 'acf/settings/save_json/type=acf-post-type', 'conphig_addon_acf_json_save_path_for_post_types' );
add_filter( 'acf/settings/save_json/type=acf-taxonomy', 'conphig_addon_acf_json_save_path_for_taxonomies' );
add_filter( 'acf/json/save_file_name', 'conphig_addon_acf_json_filename', 10, 3 );

/**
 * Set a custom ACF JSON load path.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/#loading-explained
 *
 * @param array $paths Existing, incoming paths.
 *
 * @return array $paths New, outgoing paths.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_json_load_paths( $paths ) {
	$paths[] = ACF::dir('acf-json/field-groups');
	$paths[] = ACF::dir('acf-json/options-pages');
	$paths[] = ACF::dir('acf-json/post-types');
	$paths[] = ACF::dir('acf-json/taxonomies');

	return $paths;
}

/**
 * Set custom ACF JSON save point for
 * ACF generated post types.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/#saving-explained
 *
 * @return string $path New, outgoing path.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_json_save_path_for_post_types() {
	return ACF::dir('acf-json/post-types');
}

/**
 * Set custom ACF JSON save point for
 * ACF generated field groups.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/#saving-explained
 *
 * @return string $path New, outgoing path.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_json_save_path_for_field_groups() {
	return ACF::dir('acf-json/field-groups');
}

/**
 * Set custom ACF JSON save point for
 * ACF generated taxonomies.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/#saving-explained
 *
 * @return string $path New, outgoing path.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_json_save_path_for_taxonomies() {
	return ACF::dir('acf-json/taxonomies');
}

/**
 * Set custom ACF JSON save point for
 * ACF generated Options Pages.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/#saving-explained
 *
 * @return string $path New, outgoing path.
 *
 * @since 0.1.1
 */
function conphig_addon_acf_json_save_path_for_option_pages() {
	return ACF::dir('acf-json/options-pages');
}

/**
 * Customize the file names for each file.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/#saving-explained
 *
 * @param string $filename  The default filename.
 * @param array  $post      The main post array for the item being saved.
 *
 * @return string $filename
 *
 * @since  0.1.1
 */
function conphig_addon_acf_json_filename( $filename, $post ) {
	$filename = str_replace(
		array(
			' ',
			'_',
		),
		array(
			'-',
			'-',
		),
		$post['title']
	);

	$filename = strtolower( $filename ) . '.json';

	return $filename;
}
