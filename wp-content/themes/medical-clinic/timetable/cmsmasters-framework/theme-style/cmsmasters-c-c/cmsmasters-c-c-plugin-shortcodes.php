<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version 	1.1.6
 * 
 * Timetable Content Composer Shortcodes
 * Created by CMSMasters
 * 
 */


function medical_clinic_timetable_shortcodes($shortcodes) {
	$shortcodes[] = 'cmsmasters_timetable';
	
	
	return $shortcodes;
}

add_filter('cmsmasters_custom_shortcodes_filter', 'medical_clinic_timetable_shortcodes');


/**
 * Timetable
 */
function cmsmasters_timetable($atts, $content = null) {
	extract(shortcode_atts(array( 
		'shortcode_id' => 				'', 
		'event' => 						'', 
		'event_category' => 			'', 
		'hour_category' => 				'', 
		'columns' => 					'', 
		'measure' => 					'1', 
		'filter_style' => 				'dropdown_list', 
		'filter_kind' => 				'event', 
		'filter_label' => 				'All Events', 
		'filter_label_2' => 			'All Events Categories', 
		'time_format' => 				'H.i', 
		'time_format_custom' => 		'', 
		'hide_all_events_view' => 		'0', 
		'hide_hours_column' => 			'0', 
		'show_end_hour' => 				'0', 
		'event_layout' => 				'1', 
		'hide_empty' => 				'0', 
		'disable_event_url' => 			'0', 
		'text_align' => 				'center', 
		'id' => 						'', 
		'row_height' => 				'31', 
		'desktop_list_view' => 			'0', 
		'event_description_responsive' => 'none', 
		'collapse_event_hours_responsive' => '0', 
		'colors_responsive_mode' => 	'0', 
		'export_to_pdf_button' => 		'0', 
		'generate_pdf_label' => 		'Generate PDF', 
		'show_booking_button' => 		'no', 
		'show_available_slots' => 		'no', 
		'available_slots_singular_label' => '{number_available}/{number_total} slot available', 
		'available_slots_plural_label' => '{number_available}/{number_total} slots available', 
		'default_booking_view' => 		'user', 
		'allow_user_booking' => 		'yes', 
		'allow_guest_booking' => 		'no', 
		'show_guest_name_field' => 		'yes', 
		'guest_name_field_required' => 	'yes', 
		'show_guest_phone_field' => 	'no', 
		'guest_phone_field_required' => 'no', 
		'show_guest_message_field' => 	'no', 
		'guest_message_field_required' => 'no', 
		'booking_label' => 				'Book now', 
		'booked_label' => 				'Booked', 
		'unavailable_label' => 			'Unavailable', 
		'booking_popup_label' => 		'Book now', 
		'login_popup_label' => 			'Log in', 
		'cancel_popup_label' => 		'Cancel', 
		'continue_popup_label' => 		'Continue', 
		'terms_checkbox' => 			'no', 
		'terms_message' => 				'Please accept terms and conditions', 
		'booking_popup_message' => 		'', 
		'booking_popup_thank_you_message' => '', 
		'box_bg_color' => 				'', 
		'box_hover_bg_color' => 		'', 
		'box_bd_color' => 				'', 
		'box_txt_color' => 				'', 
		'box_hover_txt_color' => 		'', 
		'box_hours_txt_color' => 		'', 
		'box_hours_hover_txt_color' => 	'', 
		'row1_bg_color' => 				'', 
		'row1_txt_color' => 			'', 
		'row2_bg_color' => 				'', 
		'row2_txt_color' => 			'', 
		'booking_text_color' => 		'', 
		'booking_bg_color' => 			'', 
		'booking_hover_text_color' => 	'', 
		'booking_hover_bg_color' => 	'', 
		'booked_text_color' => 			'', 
		'booked_bg_color' => 			'', 
		'unavailable_text_color' => 	'', 
		'unavailable_bg_color' => 		'', 
		'available_slots_color' => 		'', 
		'classes' => 					'' 
	), $atts));
	
	
	$unique_id = $shortcode_id;
	
	
    $out = '<div id="cmsmasters_timetable_shortcode_' . $unique_id . '" class="cmsmasters_timetable_shortcode' . 
	(($classes != '') ? ' ' . $classes : '') . 
	'">';
	
	$shortcode_styles = "
		#cmsmasters_timetable_shortcode_{$unique_id} .tabs_box_navigation .tabs_box_navigation_selected {
			" . cmsmasters_color_css('color', $row1_txt_color) . "
			" . cmsmasters_color_css('background-color', $box_txt_color) . "
			" . cmsmasters_color_css('border-color', $box_bd_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tabs_box_navigation .tabs_box_navigation_selected:hover {
			" . cmsmasters_color_css('color', $box_txt_color) . "
			" . cmsmasters_color_css('background-color', $box_bg_color) . "
			" . cmsmasters_color_css('border-color', $box_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tabs_box_navigation .tabs_box_navigation_selected .sub-menu {
			" . cmsmasters_color_css('background-color', $box_txt_color) . "
			" . cmsmasters_color_css('border-color', $box_bd_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tabs_box_navigation .tabs_box_navigation_selected .sub-menu li a {
			" . cmsmasters_color_css('color', $row1_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tabs_box_navigation .tabs_box_navigation_selected .sub-menu li a:hover, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tabs_box_navigation .tabs_box_navigation_selected .sub-menu li.selected a {
			" . cmsmasters_color_css('color', $box_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_tabs_navigation li a {
			" . cmsmasters_color_css('color', $row2_txt_color) . "
			" . cmsmasters_color_css('border-color', $box_bd_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_tabs_navigation li a:hover,
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_tabs_navigation li a.selected,
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_tabs_navigation li.ui-tabs-active a {
			" . cmsmasters_color_css('border-top-color', $box_bg_color) . "
		}
		
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable thead tr:first-child th:first-child {
			" . cmsmasters_color_css('background-color', $box_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable td.tt_hours_column, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable thead tr:first-child th	{
			" . cmsmasters_color_css('color', $row1_txt_color) . "
			" . cmsmasters_color_css('background-color', $row1_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable tbody tr:nth-child(even) td.tt_hours_column, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable td {
			" . cmsmasters_color_css('color', $row2_txt_color) . "
			" . cmsmasters_color_css('background-color', $row2_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event {
			" . cmsmasters_color_css('background-color', $box_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event hr {
			" . cmsmasters_color_css('background-color', $box_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event {
			" . cmsmasters_color_css('background-color', $box_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container:hover, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event:hover, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_tooltip_content {
			" . cmsmasters_color_css('background-color', $box_hover_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event .event_container, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event .event_container:hover {
			background-color:transparent;
			color:inherit;
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_tooltip_arrow {
			" . cmsmasters_color_css('border-color', $box_hover_bg_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container a, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event a {
			" . cmsmasters_color_css('color', $box_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container:hover, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container:hover a, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event:hover, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event:hover a, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_tooltip_content, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_tooltip_content a {
			" . cmsmasters_color_css('color', $box_hover_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container .hours, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event .hours {
			" . cmsmasters_color_css('color', $box_hours_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .event_container:hover .hours, 
		#cmsmasters_timetable_shortcode_{$unique_id} table.tt_timetable .tt_single_event:hover .hours {
			" . cmsmasters_color_css('color', $box_hours_hover_txt_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable .event_container .available_slots, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable .event_container .available_slots span {
			" . cmsmasters_color_css('color', $available_slots_color) . "
		}
		
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable .event_container:hover .available_slots, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable .event_container:hover .available_slots span, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable .tt_single_event:hover .available_slots, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable .tt_single_event:hover .available_slots span, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable.use_colors ul.tt_items_list li:hover .available_slots, 
		#cmsmasters_timetable_shortcode_{$unique_id} .tt_timetable.use_colors ul.tt_items_list li:hover .available_slots span {
			" . cmsmasters_color_css('color', $box_hover_txt_color . ' !important') . "
		}
	";
	
	
	$out .= Cmsmasters_Shortcodes::cmsmasters_generate_front_css($shortcode_styles);
	
	
	$out_timetable = do_shortcode('[tt_timetable' . 
		($event != '' ? ' event="' . $event . '"' : '') . 
		($event_category != '' ? ' event_category="' . $event_category . '"' : '') . 
		($hour_category != '' ? ' hour_category="' . $hour_category . '"' : '') . 
		($columns != '' ? ' columns="' . $columns . '"' : '') . 
		' measure="' . $measure . '"' . 
		' filter_style="' . $filter_style . '"' . 
		' filter_kind="' . $filter_kind . '"' . 
		' filter_label="' . $filter_label . '"' . 
		' filter_label_2="' . $filter_label_2 . '"' . 
		($time_format == 'custom' ? ($time_format_custom != '' ? ' time_format="' . $time_format_custom . '"' : '') : ' time_format="' . $time_format . '"') . 
		' hide_all_events_view="' . $hide_all_events_view . '"' . 
		' hide_hours_column="' . $hide_hours_column . '"' . 
		' show_end_hour="' . $show_end_hour . '"' . 
		' event_layout="' . $event_layout . '"' . 
		' hide_empty="' . $hide_empty . '"' . 
		' disable_event_url="' . $disable_event_url . '"' . 
		' text_align="' . $text_align . '"' . 
		($id != '' ? ' id="' . $id . '"' : '') . 
		(($row_height != '' && $row_height != '0') ? ' row_height="' . $row_height . '"' : '') . 
		' desktop_list_view="' . $desktop_list_view . '"' . 
		' event_description_responsive="' . $event_description_responsive . '"' . 
		' collapse_event_hours_responsive="' . $collapse_event_hours_responsive . '"' . 
		' colors_responsive_mode="' . $colors_responsive_mode . '"' . 
		' export_to_pdf_button="' . $export_to_pdf_button . '"' . 
		' generate_pdf_label="' . $generate_pdf_label . '"' . 
		' show_booking_button="' . $show_booking_button . '"' . 
		' show_available_slots="' . $show_available_slots . '"' . 
		' available_slots_singular_label="' . $available_slots_singular_label . '"' . 
		' available_slots_plural_label="' . $available_slots_plural_label . '"' . 
		' default_booking_view="' . $default_booking_view . '"' . 
		' allow_user_booking="' . $allow_user_booking . '"' . 
		' allow_guest_booking="' . $allow_guest_booking . '"' . 
		' show_guest_name_field="' . $show_guest_name_field . '"' . 
		' guest_name_field_required="' . $guest_name_field_required . '"' . 
		' show_guest_phone_field="' . $show_guest_phone_field . '"' . 
		' guest_phone_field_required="' . $guest_phone_field_required . '"' . 
		' show_guest_message_field="' . $show_guest_message_field . '"' . 
		' guest_message_field_required="' . $guest_message_field_required . '"' . 
		' booking_label="' . $booking_label . '"' . 
		' booked_label="' . $booked_label . '"' . 
		' unavailable_label="' . $unavailable_label . '"' . 
		' booking_popup_label="' . $booking_popup_label . '"' . 
		' login_popup_label="' . $login_popup_label . '"' . 
		' cancel_popup_label="' . $cancel_popup_label . '"' . 
		' continue_popup_label="' . $continue_popup_label . '"' . 
		' terms_checkbox="' . $terms_checkbox . '"' . 
		' terms_message="' . $terms_message . '"' . 
		" booking_popup_message='" . do_shortcode(urldecode($booking_popup_message)) . "'" . 
		" booking_popup_thank_you_message='" . do_shortcode(urldecode($booking_popup_thank_you_message)) . "'" . 
		' box_bg_color="' . $box_bg_color . '"' . 
		' box_hover_bg_color="' . $box_hover_bg_color . '"' . 
		' box_bd_color="' . $box_bd_color . '"' . 
		' box_txt_color="' . $box_txt_color . '"' . 
		' box_hover_txt_color="' . $box_hover_txt_color . '"' . 
		' box_hours_txt_color="' . $box_hours_txt_color . '"' . 
		' box_hours_hover_txt_color="' . $box_hours_hover_txt_color . '"' . 
		' row1_color="' . $row1_bg_color . '"' . 
		' row2_color="' . $row2_bg_color . '"' . 
		' booking_text_color="' . $booking_text_color . '"' . 
		' booking_bg_color="' . $booking_bg_color . '"' . 
		' booking_hover_text_color="' . $booking_hover_text_color . '"' . 
		' booking_hover_bg_color="' . $booking_hover_bg_color . '"' . 
		' booked_text_color="' . $booked_text_color . '"' . 
		' booked_bg_color="' . $booked_bg_color . '"' . 
		' unavailable_text_color="' . $unavailable_text_color . '"' . 
		' unavailable_bg_color="' . $unavailable_bg_color . '"' . 
		' available_slots_color="' . $available_slots_color . '"' . 
		' filter_color=""' . 
	']');
	
	
	$out .= preg_replace("/#rgb/", 'rgb', $out_timetable);
	
	
	$out .= '</div>';
	
	
	return $out;
}

