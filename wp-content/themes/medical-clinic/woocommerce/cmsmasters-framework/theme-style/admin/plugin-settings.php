<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version 	1.1.7
 *
 * CMSMasters WooCommerce Admin Settings
 * Created by CMSMasters
 *
 */


/* Single Settings */
function medical_clinic_woocommerce_options_general_fields($options, $tab) {
	$defaults = medical_clinic_settings_general_defaults();

	if ($tab == 'header') {
		$options[] = array(
			'section' => 'header_section',
			'id' => 'medical-clinic' . '_woocommerce_cart_dropdown',
			'title' => esc_html__('Header WooCommerce Cart', 'medical-clinic'),
			'desc' => esc_html__('show', 'medical-clinic'),
			'type' => 'checkbox',
			'std' => $defaults[$tab]['medical-clinic' . '_woocommerce_cart_dropdown']
		);
	}

	return $options;
}

add_filter('cmsmasters_options_general_fields_filter', 'medical_clinic_woocommerce_options_general_fields', 10, 2);

