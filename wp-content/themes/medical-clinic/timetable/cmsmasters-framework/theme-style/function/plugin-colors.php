<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version 	1.1.6
 * 
 * Timetable Colors Rules
 * Created by CMSMasters
 * 
 */


function medical_clinic_timetable_colors($custom_css) {
	$cmsmasters_option = medical_clinic_get_global_options();
	
	
	$cmsmasters_color_schemes = cmsmasters_color_schemes_list();
	
	
	foreach ($cmsmasters_color_schemes as $scheme => $title) {
		$rule = (($scheme != 'default') ? "html .cmsmasters_color_scheme_{$scheme} " : '');
		
		
		$custom_css .= "
/***************** Start {$title} Timetable Color Scheme Rules ******************/

	/* Start Main Content Font Color */
	{$rule}.tabs_box_navigation .tabs_box_navigation_selected:before, 
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:before, 
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container * {
		" . cmsmasters_color_css('color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_color']) . "
	}
	/* Finish Main Content Font Color */
	
	
	/* Start Primary Color */
	{$rule}.cmsmasters_tt_event #event_hours_list > li > h4:nth-child(2), 
	{$rule}.second_color {
		" . cmsmasters_color_css('color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_link']) . "
	}
	
	{$rule}.tt_upcoming_events_wrapper .tt_upcoming_event_controls > a:hover, 
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:hover, 
	{$rule}.tt_booking a.tt_btn {
		" . cmsmasters_color_css('background-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_link']) . "
	}
	
	{$rule}.tt_upcoming_events_wrapper .tt_upcoming_event_controls > a:hover, 
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:hover {
		" . cmsmasters_color_css('border-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_link']) . "
	}
	
	{$rule}ul.tt_upcoming_events li a.tt_upcoming_events_event_container {
		" . cmsmasters_color_css('border-' . (is_rtl() ? 'right' : 'left') . '-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_link']) . "
	}
	
	{$rule}body .cmsmasters_tt_event #event_hours_list > li, 
	{$rule}body .cmsmasters_tt_event .cmsmasters_tt_event_sidebar > div {
		" . cmsmasters_color_css('border-top-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_link']) . "
	}
	/* Finish Primary Color */
	
	
	/* Start Highlight Color */
	{$rule}.tt_upcoming_events_wrapper .tt_upcoming_event_controls > a,
	{$rule}.hover_color {
		" . cmsmasters_color_css('color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_hover']) . "
	}
	/* Finish Highlight Color */
	
	
	/* Start Headings Color */
	{$rule}.tt_tabs_navigation li a.selected,
	{$rule}.tt_tabs_navigation li.ui-tabs-active a {
		" . cmsmasters_color_css('color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_heading']) . "
	}
	
	{$rule}.tt_booking a.tt_btn:hover {
		" . cmsmasters_color_css('background-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_heading']) . "
	}
	/* Finish Headings Color */
	
	
	/* Start Alternate Background Color */
	{$rule}ul.tt_items_list li:nth-child(2n+1) {
		" . cmsmasters_color_css('background-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_alternate']) . "
	}
	/* Start Alternate Background Color */
	
	
	/* Start Main Background Color */
	{$rule}.tabs_box_navigation .tabs_box_navigation_selected:hover:before, 
	{$rule}.tt_upcoming_events_wrapper .tt_upcoming_event_controls > a:hover,
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:hover:before,
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:hover *,
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:hover, 
	{$rule}.tt_booking a.tt_btn, 
	{$rule}.tt_booking a.tt_btn:hover {
		" . cmsmasters_color_css('color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_bg']) . "
	}
	
	{$rule}.cmsmasters_tt_event #event_hours_list > li, 
	{$rule}.cmsmasters_tt_event .cmsmasters_tt_event_sidebar > div, 
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container,
	{$rule}.tt_upcoming_events_wrapper .tt_upcoming_event_controls > a, 
	{$rule}.tt_booking .tt_booking_message_wrapper {
		" . cmsmasters_color_css('background-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_bg']) . "
	}
	/* Finish Main Background Color */
	
	
	/* Start Borders Color */
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container:hover {
		" . cmsmasters_color_css('color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_border']) . "
	}
	
	{$rule}.cmsmasters_tt_event #event_hours_list > li, 
	{$rule}.ui-tabs .tt_tabs_navigation.ui-widget-header, 
	{$rule}.cmsmasters_tt_event .cmsmasters_tt_event_sidebar > div, 
	{$rule}.cmsmasters_tt_event .cmsmasters_tt_event_hours .cmsmasters_tt_event_hours_item, 
	{$rule}.cmsmasters_tt_event .cmsmasters_tt_event_details .cmsmasters_tt_event_details_item, 
	{$rule}ul.tt_upcoming_events li .tt_upcoming_events_event_container,
	{$rule}.tt_booking, 
	{$rule}.tt_upcoming_events_wrapper .tt_upcoming_event_controls > a {
		" . cmsmasters_color_css('border-color', $cmsmasters_option['medical-clinic' . '_' . $scheme . '_border']) . "
	}
	/* Finish Borders Color */

/***************** Finish {$title} Timetable Color Scheme Rules ******************/

";
	}
	
	
	return $custom_css;
}

add_filter('medical_clinic_theme_colors_secondary_filter', 'medical_clinic_timetable_colors');

