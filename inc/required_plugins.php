<?php

/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1 for plugin Wp Mobile
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
add_action( 'tgmpa_register', 'wp_mobile_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function wp_mobile_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'				 => 'WordPress REST API (Version 2)',
			'slug'				 => 'rest-api',
			'required'			 => true,
			'force_activation'	 => true,
		),
		array(
			'name'				 => 'ButterBean',
			'slug'				 => 'butterbean',
			'source'			 => 'https://github.com/justintadlock/butterbean/archive/master.zip',
			'required'			 => true,
			'force_activation'	 => true,
			'external_url'		 => 'http://themehybrid.com/plugins/butterbean',
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'			 => 'wp-mobile', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path'	 => '', // Default absolute path to bundled plugins.
		'menu'			 => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'	 => 'plugins.php', // Parent menu slug.
		'capability'	 => 'manage_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'	 => true, // Show admin notices or not.
		'dismissable'	 => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg'	 => '', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic'	 => false, // Automatically activate plugins after installation or not.
		'message'		 => '', // Message to output right before the plugins table.
		'strings' => array(
			'page_title'						 => __( 'Install Required Plugins', 'wp-mobile' ),
			'menu_title'						 => __( 'Install Plugins', 'wp-mobile' ),
			/* translators: %s: plugin name. */
			'installing'						 => __( 'Installing Plugin: %s', 'wp-mobile' ),
			/* translators: %s: plugin name. */
			'updating'							 => __( 'Updating Plugin: %s', 'wp-mobile' ),
			'oops'								 => __( 'Something went wrong with the plugin API.', 'wp-mobile' ),
			'notice_can_install_required'		 => _n_noop(
					/* translators: 1: plugin name(s). */
					'This plugin requires the following plugin: %1$s.', 'This plugin requires the following plugins: %1$s.', 'wp-mobile'
			),
			'notice_can_install_recommended'	 => _n_noop(
					/* translators: 1: plugin name(s). */
					'This plugin recommends the following plugin: %1$s.', 'This plugin recommends the following plugins: %1$s.', 'wp-mobile'
			),
			'notice_ask_to_update'				 => _n_noop(
					/* translators: 1: plugin name(s). */
					'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'wp-mobile'
			),
			'notice_ask_to_update_maybe'		 => _n_noop(
					/* translators: 1: plugin name(s). */
					'There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'wp-mobile'
			),
			'notice_can_activate_required'		 => _n_noop(
					/* translators: 1: plugin name(s). */
					'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'wp-mobile'
			),
			'notice_can_activate_recommended'	 => _n_noop(
					/* translators: 1: plugin name(s). */
					'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'wp-mobile'
			),
			'install_link'						 => _n_noop(
					'Begin installing plugin', 'Begin installing plugins', 'wp-mobile'
			),
			'update_link'						 => _n_noop(
					'Begin updating plugin', 'Begin updating plugins', 'wp-mobile'
			),
			'activate_link'						 => _n_noop(
					'Begin activating plugin', 'Begin activating plugins', 'wp-mobile'
			),
			'return'							 => __( 'Return to Required Plugins Installer', 'wp-mobile' ),
			'plugin_activated'					 => __( 'Plugin activated successfully.', 'wp-mobile' ),
			'activated_successfully'			 => __( 'The following plugin was activated successfully:', 'wp-mobile' ),
			/* translators: 1: plugin name. */
			'plugin_already_active'				 => __( 'No action taken. Plugin %1$s was already active.', 'wp-mobile' ),
			/* translators: 1: plugin name. */
			'plugin_needs_higher_version'		 => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'wp-mobile' ),
			/* translators: 1: dashboard link. */
			'complete'							 => __( 'All plugins installed and activated successfully. %1$s', 'wp-mobile' ),
			'dismiss'							 => __( 'Dismiss this notice', 'wp-mobile' ),
			'notice_cannot_install_activate'	 => __( 'There are one or more required or recommended plugins to install, update or activate.', 'wp-mobile' ),
			'contact_admin'						 => __( 'Please contact the administrator of this site for help.', 'wp-mobile' ),
			'nag_type' => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
		),
	);

	tgmpa( $plugins, $config );
}

