<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version 	1.1.5
 * 
 * Theme Vars Functions
 * Created by CMSMasters
 * 
 */


/* Register CSS Styles */
function medical_clinic_vars_register_css_styles() {
	wp_enqueue_style('medical-clinic-theme-vars-style', get_template_directory_uri() . '/theme-vars/theme-style' . CMSMASTERS_THEME_STYLE . '/css/vars-style.css', array('medical-clinic-retina'), '1.0.0', 'screen, print');
}

add_action('wp_enqueue_scripts', 'medical_clinic_vars_register_css_styles');

