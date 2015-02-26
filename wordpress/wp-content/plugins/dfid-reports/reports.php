<?php
/*
Plugin Name: Digital Capability Tool Reports
Description: Generate reports
Version: 1.0.0
*/

define ("REPORTS_MODULE_DIRECTORY", plugin_dir_path( __FILE__ ));

/**
 * Report departments callback
 */
function reports_departments() {
	if ( !current_user_can( WATUPRO_MANAGE_CAPS ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	require_once REPORTS_MODULE_DIRECTORY . "views" . DIRECTORY_SEPARATOR . "departments-list.php";

}

/**
 * Report roles callback
 */
function reports_roles() {
	if ( !current_user_can( WATUPRO_MANAGE_CAPS ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	require_once REPORTS_MODULE_DIRECTORY . "views" . DIRECTORY_SEPARATOR . "roles-list.php";

}

/**
 * Report free form answers callback
 */
function reports_free_form_answers() {
    if ( !current_user_can( WATUPRO_MANAGE_CAPS ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }
    require_once REPORTS_MODULE_DIRECTORY . "views" . DIRECTORY_SEPARATOR . "free-form-answers.php";
}

/**
 * Download CSV route handler
 */
add_action('template_redirect','download_files_redirect');
function download_files_redirect() {
	if (isset($_POST['action']) && current_user_can( WATUPRO_MANAGE_CAPS )) {
		switch ($_POST['action']) {
			case "download_departments_csv":
				require_once REPORTS_MODULE_DIRECTORY . "controllers" . DIRECTORY_SEPARATOR . "export-departments-report.php";
				break;
			case "download_roles_csv":
				require_once REPORTS_MODULE_DIRECTORY . "controllers" . DIRECTORY_SEPARATOR . "export-roles-report.php";
				break;
		}

	}
}

/** Define de admin menu */
add_action( 'admin_menu', 'reports_menu' );
function reports_menu() {
	add_menu_page(__('Reports', 'reports'), __('Reports', 'reports'), WATUPRO_MANAGE_CAPS, "reports_menu", 'reports_departments');
	add_submenu_page('reports_menu', __('Departments', 'reports'), __('Departments', 'reports'), WATUPRO_MANAGE_CAPS, "reports_departments", 'reports_departments');
	add_submenu_page('reports_menu', __('Roles', 'reports'), __('Roles', 'reports'), WATUPRO_MANAGE_CAPS, "reports_roles", 'reports_roles');
    add_submenu_page('reports_menu', __('Free-form answers', 'reports'), __('Free-form answers', 'reports'), WATUPRO_MANAGE_CAPS, "reports_free_form_answers", 'reports_free_form_answers');
	remove_submenu_page('reports_menu','reports_menu');
}