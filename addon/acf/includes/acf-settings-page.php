<?php
/**
 * ACF demo Options Page: "Site Settings".
 *
 * @link https://www.advancedcustomfields.com/resources/options-page/
 */

/**
 * Check if ACF PRO is active and function exists.
 */

if ( function_exists( 'acf_add_options_page' ) ) {
	// add_action( 'acf/init', 'hows_ss_register_options_page' );
	add_action('admin_menu', 'hows_ss_plugin_menu');
	// add_action('admin_init', 'your_plugin_initialize_settings');
}

function hows_ss_register_options_page() {
	// Add the top-level page.
	acf_add_options_page(
		array(
			'page_title' => 'test Site Settings',
			'menu_slug'  => 'hows-site-settings',
			'redirect'   => false,
		)
	);

	// Add the sub-page.
	acf_add_options_sub_page(
		array(
			'page_title'  => 'Contact Information',
			'menu_slug'   => 'test-contact-information',
			'parent_slug' => 'hows-site-settings',
		)
	);

	// Add 'Contact Information' field group with Phone field.
	acf_add_local_field_group(
		array(
			'key'      => 'group_6511a57f5680c',
			'title'    => 'Contact Information',
			'fields'   => array(
				array(
					'key'           => 'field_6511a57fcbe7e',
					'label'         => 'Phone Number',
					'name'          => 'demo_acf_phone_number',
					'type'          => 'text',
					'default_value' => '555 123-4567',
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'contact-information',
					),
				),
			),
		)
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_6511a5e8c1c15',
			'title'    => 'Notification Bar',
			'fields'   => array(
				array(
					'key'        => 'field_6511a5e897814',
					'label'      => 'Notification Bar',
					'name'       => 'demo_acf_notification_bar_group',
					'aria-label' => '',
					'type'       => 'group',
					'layout'     => 'row',
					'sub_fields' => array(
						array(
							'key'           => 'field_6511a5f597815',
							'label'         => 'Notification On/Off',
							'name'          => 'demo_acf_notification_onoff',
							'type'          => 'true_false',
							'message'       => 'Should the site-wide Notification Bar be showing?',
							'default_value' => 1,
							'ui_on_text'    => 'On',
							'ui_off_text'   => 'Off',
							'ui'            => 1,
						),
						array(
							'key'               => 'field_6511a5f597816',
							'label'             => 'Notification Message',
							'name'              => 'demo_acf_notification_message',
							'type'              => 'textarea',
							'conditional_logic' => array(
								array(
									array(
										'field'    => 'demo_acf_notification_onoff',
										'operator' => '==',
										'value'    => '1',
									),
								),
							),
						),
					),
				),
			),
			'location' => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'hows-site-settings',
					),
				),
			),
		)
	);
}






// Register the menu page
function hows_ss_plugin_menu() {
    add_menu_page(
        'HOWS Site Settings',
        'Site Settings',
        'manage_options',
        'hows_site_settings',
        'hows_site_settings_page',
				"data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzNTEuNCAzNTEuNCI+PHBhdGggZD0iTTE3NS43LDBBMTc1LjcsMTc1LjcsMCwxLDAsMzUxLjQsMTc1LjcsMTc1LjcsMTc1LjcsMCwwLDAsMTc1LjcsMFptOTMuNDUsMjYzLjMzcS0zNS4yNSwzNi4yOS05MCwzNi4yOFExMjQsMjk5LjYxLDg5LDI2My40OVQ1My44OCwxNzQuMzVxMC01MywzNS4wOC04OS4xNSwzMS42Ny0zMi42LDc5LjY3LTM1LjczYzIuOTIsMjkuNjQsMTcuMzIsNTIuODcsNDIuMTEsNjcuNzgsMzMuNDMsMjAuMTIsNjEuMzEsOSw4Ny44OCwyNSwuODcuNTMsMS43MSwxLjA4LDIuNTMsMS42NWExMzguNzgsMTM4Ljc4LDAsMCwxLDMuMjYsMzAuNDJRMzA0LjQxLDIyNy4wNiwyNjkuMTUsMjYzLjMzWiIgc3R5bGU9ImZpbGw6IzIzMWYyMCIvPjxlbGxpcHNlIGN4PSIyMjQuOTQiIGN5PSIxNzQuMDkiIHJ4PSIyMi45NiIgcnk9IjIyLjE0IiBzdHlsZT0iZmlsbDojMjMxZjIwIi8+PC9zdmc+"
    );
}


// Define the settings and create the form
function hows_site_settings_page() {
    ?>
    <div class="wrap">
        <h2>Your Plugin Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('your_plugin_settings');
            do_settings_sections('your_plugin_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register and initialize the settings
function your_plugin_initialize_settings() {
    // Register a setting and its sanitization callback
    register_setting('your_plugin_settings', 'your_plugin_option', 'sanitize_text_field');

    // Add a section and a field to the settings page
    add_settings_section(
        'your_plugin_section',
        'Your Settings Section',
        'your_plugin_section_callback',
        'your_plugin_settings'
    );

    add_settings_field(
        'your_plugin_field',
        'Your Option',
        'your_plugin_field_callback',
        'your_plugin_settings',
        'your_plugin_section'
    );
}


// Section callback (optional)
function your_plugin_section_callback() {
    echo '<p>Optional section description goes here.</p>';
}

// Field callback
function your_plugin_field_callback() {
    $option_value = get_option('your_plugin_option');
    echo '<input type="text" name="your_plugin_option" value="' . esc_attr($option_value) . '" />';
}
