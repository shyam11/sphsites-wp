<?php 
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version		1.1.6
 * 
 * Admin Panel Theme Settings Import/Export
 * Created by CMSMasters
 * 
 */


function medical_clinic_options_demo_tabs() {
	$tabs = array();
	
	
	$tabs['import'] = esc_attr__('Import', 'medical-clinic');
	$tabs['export'] = esc_attr__('Export', 'medical-clinic');
	
	
	return $tabs;
}


function medical_clinic_options_demo_sections() {
	$tab = medical_clinic_get_the_tab();
	
	
	switch ($tab) {
	case 'import':
		$sections = array();
		
		$sections['import_section'] = esc_html__('Theme Settings Import', 'medical-clinic');
		
		
		break;
	case 'export':
		$sections = array();
		
		$sections['export_section'] = esc_html__('Theme Settings Export', 'medical-clinic');
		
		
		break;
	default:
		$sections = array();
		
		
		break;
	}
	
	
	return $sections;
} 


function medical_clinic_options_demo_fields($set_tab = false) {
	if ($set_tab) {
		$tab = $set_tab;
	} else {
		$tab = medical_clinic_get_the_tab();
	}
	
	
	$options = array();
	
	
	switch ($tab) {
	case 'import':
		$options[] = array( 
			'section' => 'import_section', 
			'id' => 'medical-clinic' . '_demo_import', 
			'title' => esc_html__('Theme Settings', 'medical-clinic'), 
			'desc' => esc_html__("Enter your theme settings data here and click 'Import' button", 'medical-clinic') . (CMSMASTERS_THEME_STYLE_COMPATIBILITY ? '<span class="descr_note">' . esc_html__("Please note that when importing theme settings, these settings will be applied to the appropriate Theme Style (with the same name).", 'medical-clinic') . '<br />' . esc_html__("To see these settings applied, please enable appropriate", 'medical-clinic') . ' <a href="' . esc_url(admin_url('admin.php?page=cmsmasters-settings&tab=theme_style')) . '">' . esc_html__("Theme Style", 'medical-clinic') . '</a>.</span>' : ''), 
			'type' => 'textarea', 
			'std' => '', 
			'class' => '' 
		);
		
		
		break;
	case 'export':
		$options[] = array( 
			'section' => 'export_section', 
			'id' => 'medical-clinic' . '_demo_export', 
			'title' => esc_html__('Theme Settings', 'medical-clinic'), 
			'desc' => esc_html__("Click here to export your theme settings data to the file.", 'medical-clinic') . (CMSMASTERS_THEME_STYLE_COMPATIBILITY ? '<span class="descr_note">' . esc_html__("Please note, that when exporting theme settings, you will export settings for the currently active Theme Style.", 'medical-clinic') . '<br />' . esc_html__("Theme Style can be set", 'medical-clinic') . ' <a href="' . esc_url(admin_url('admin.php?page=cmsmasters-settings&tab=theme_style')) . '">' . esc_html__("here", 'medical-clinic') . '</a>.</span>' : ''), 
			'type' => 'button', 
			'std' => esc_html__('Export Theme Settings', 'medical-clinic'), 
			'class' => 'cmsmasters-demo-export' 
		);
		
		
		break;
	}
	
	
	return $options;	
}

