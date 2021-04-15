<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version 	1.1.6
 * 
 * Timetable Content Composer Functions 
 * Created by CMSMasters
 * 
 */


/* Register JS Scripts */
function medical_clinic_timetable_register_c_c_scripts() {
	global $pagenow;
	
	
	$cmsmasters_option = medical_clinic_get_global_options();
	
	
	if ( 
		$pagenow == 'post-new.php' || 
		($pagenow == 'post.php' && isset($_GET['post']) && get_post_type($_GET['post']) != 'attachment') 
	) {
		wp_enqueue_script('medical-clinic-timetable-extend', get_template_directory_uri() . '/timetable/cmsmasters-framework/theme-style' . CMSMASTERS_THEME_STYLE . '/cmsmasters-c-c/js/cmsmasters-c-c-plugin-extend.js', array('cmsmasters_composer_shortcodes_js'), '1.0.0', true);
		
		wp_localize_script('medical-clinic-timetable-extend', 'cmsmasters_timetable_shortcodes', array( 
			'timetable_events' => 												medical_clinic_timetable_events(), 
			'timetable_event_categories' => 									medical_clinic_timetable_event_categories(), 
			'timetable_hour_categories' => 										medical_clinic_timetable_hour_categories(), 
			'timetable_columns' => 												medical_clinic_timetable_columns(), 
			'timetable_title' =>												esc_html__('Timetable', 'medical-clinic'), 
			'timetable_field_event_title' =>									esc_html__('Events', 'medical-clinic'), 
			'timetable_field_event_descr' =>									esc_html__('Select the events that are to be displayed in timetable', 'medical-clinic'), 
			'timetable_field_event_descr_note' =>								esc_html__('Hold the CTRL key to select multiple items', 'medical-clinic'), 
			'timetable_field_event_category_title' =>							esc_html__('Event categories', 'medical-clinic'), 
			'timetable_field_event_category_descr' =>							esc_html__('Select the events categories that are to be displayed in timetable', 'medical-clinic'), 
			'timetable_field_event_category_descr_note' =>						esc_html__('Hold the CTRL key to select multiple items', 'medical-clinic'), 
			'timetable_field_hour_category_title' =>							esc_html__('Hour categories', 'medical-clinic'), 
			'timetable_field_hour_category_descr' =>							esc_html__('Select the hour categories (if defined for existing event hours) for events that are to be displayed in timetable', 'medical-clinic'), 
			'timetable_field_hour_category_descr_note' =>						esc_html__('Hold the CTRL key to select multiple items', 'medical-clinic'), 
			'timetable_field_columns_title' =>									esc_html__('Columns', 'medical-clinic'), 
			'timetable_field_columns_descr' =>									esc_html__('Select the columns that are to be displayed in timetable', 'medical-clinic'), 
			'timetable_field_columns_descr_note' =>								esc_html__('Hold the CTRL key to select multiple items', 'medical-clinic'), 
			'timetable_field_measure_title' =>									esc_html__('Hour measure', 'medical-clinic'), 
			'timetable_field_measure_descr' =>									esc_html__('Choose hour measure for event hours', 'medical-clinic'), 
			'timetable_field_measure_choice_hour' =>							esc_html__('Hour (1h)', 'medical-clinic'), 
			'timetable_field_measure_choice_half_hour' =>						esc_html__('Half hour (30min)', 'medical-clinic'), 
			'timetable_field_measure_choice_quarter_hour' =>					esc_html__('Quarter hour (15min)', 'medical-clinic'), 
			'timetable_field_filter_style_title' =>								esc_html__('Filter style', 'medical-clinic'), 
			'timetable_field_filter_style_descr' =>								esc_html__('Choose between dropdown menu and tabs for event filtering', 'medical-clinic'), 
			'timetable_field_filter_style_choice_dropdown_list' =>				esc_html__('Dropdown list', 'medical-clinic'), 
			'timetable_field_filter_style_choice_tabs' =>						esc_html__('Tabs', 'medical-clinic'), 
			'timetable_field_filter_kind_title' =>								esc_html__('Filter kind', 'medical-clinic'), 
			'timetable_field_filter_kind_descr' =>								esc_html__('Choose between filtering by events or events categories', 'medical-clinic'), 
			'timetable_field_filter_kind_choice_event' =>						esc_html__('By event', 'medical-clinic'), 
			'timetable_field_filter_kind_choice_event_category' =>				esc_html__('By event category', 'medical-clinic'), 
			'timetable_field_filter_kind_choice_event_and_event_category' =>	esc_html__('By event and event category', 'medical-clinic'), 
			'timetable_field_filter_label_title' =>								esc_html__('Filter label', 'medical-clinic'), 
			'timetable_field_filter_label_descr' =>								esc_html__('Specify text label for all events', 'medical-clinic'), 
			'timetable_field_filter_label_def' =>								esc_html__('All Events', 'medical-clinic'), 
			'timetable_field_filter_label_2_title' =>							esc_html__('Filter label 2', 'medical-clinic'), 
			'timetable_field_filter_label_2_descr' =>							esc_html__('Specify text label for all events categories', 'medical-clinic'), 
			'timetable_field_filter_label_2_def' =>								esc_html__('All Events Categories', 'medical-clinic'), 
			'timetable_field_time_format_title' =>								esc_html__('Time format', 'medical-clinic'), 
			'timetable_field_time_format_choice_custom' =>						esc_html__('Custom', 'medical-clinic'), 
			'timetable_field_time_format_custom_title' =>						esc_html__('Custom Time Format', 'medical-clinic'), 
			'timetable_field_hide_all_events_view_title' =>						esc_html__('Hide \'All Events\' view', 'medical-clinic'), 
			'timetable_field_hide_hours_column_title' =>						esc_html__('Hide first (hours) column', 'medical-clinic'), 
			'timetable_field_show_end_hour_title' =>							esc_html__('Show end hour in first (hours) column', 'medical-clinic'), 
			'timetable_field_event_layout_title' =>								esc_html__('Event block layout', 'medical-clinic'), 
			'timetable_field_event_layout_descr' =>								esc_html__('Select one of the available event block layouts', 'medical-clinic'), 
			'timetable_field_event_layout_choice_type' =>						esc_html__('Type', 'medical-clinic'), 
			'timetable_field_hide_empty_title' =>								esc_html__('Hide empty rows', 'medical-clinic'), 
			'timetable_field_disable_event_url_title' =>						esc_html__('Disable event url', 'medical-clinic'), 
			'timetable_field_text_align_title' =>								esc_html__('Text align', 'medical-clinic'), 
			'timetable_field_text_align_descr' =>								esc_html__('Specify text align in timetable event block', 'medical-clinic'), 
			'timetable_field_id_title' =>										esc_html__('Id', 'medical-clinic'), 
			'timetable_field_id_descr' =>										esc_html__('Assign a unique identifier to a timetable if you use more than one table on a single page', 'medical-clinic'), 
			'timetable_field_id_descr_note' =>									esc_html__('Otherwise, leave this field blank', 'medical-clinic'), 
			'timetable_field_row_height_title' =>								esc_html__('Row height', 'medical-clinic'), 
			'timetable_field_desktop_list_view_title' =>						esc_html__('Display list view on desktop', 'medical-clinic'), 
			'timetable_field_desktop_list_view_descr' =>						esc_html__('Enable to display list view in desktop mode.', 'medical-clinic'), 
			'timetable_field_event_description_responsive_title' =>				esc_html__('Event description in responsive mode', 'medical-clinic'), 
			'timetable_field_event_description_responsive_descr' =>				esc_html__('Specify if you want to display event description in mobile mode.', 'medical-clinic'), 
			'timetable_field_choice_none' =>									esc_html__('None', 'medical-clinic'), 
			'timetable_field_choice_description_1' =>							esc_html__('Only Description 1', 'medical-clinic'), 
			'timetable_field_choice_description_2' =>							esc_html__('Only Description 2', 'medical-clinic'), 
			'timetable_field_choice_description_1_and_description_2' =>			esc_html__('Description 1 and Description 2', 'medical-clinic'), 
			'timetable_field_collapse_event_hours_responsive_title' =>			esc_html__('Collapse event hours in responsive mode', 'medical-clinic'), 
			'timetable_field_collapse_event_hours_responsive_descr' =>			esc_html__('Enable to collapse event hours in responsive mode, can be expanded on click', 'medical-clinic'), 
			'timetable_field_colors_responsive_mode_title' =>					esc_html__('Use colors in responsive mode', 'medical-clinic'), 
			'timetable_field_colors_responsive_mode_descr' =>					esc_html__('Enable to use colors defined in shortcode and in event settings while in responsive mode.', 'medical-clinic'), 
			'timetable_field_export_to_pdf_button_title' =>						esc_html__('Export to PDF button', 'medical-clinic'), 
			'timetable_field_export_to_pdf_button_descr' =>						esc_html__('Enable to show \'Generate PDF\' button', 'medical-clinic'), 
			'timetable_field_generate_pdf_label_title' =>						esc_html__('Generate PDF label', 'medical-clinic'), 
			'timetable_field_generate_pdf_label_descr' =>						esc_html__('Specify text label for \'Generate PDF\' button', 'medical-clinic'), 
			'timetable_field_generate_pdf_label_def' =>							esc_html__('Generate PDF', 'medical-clinic'), 
			'timetable_field_show_booking_button_title' =>						esc_html__('Show booking button', 'medical-clinic'), 
			'timetable_field_show_booking_button_descr' =>						esc_html__('Specify if the \'Book now\' button should be displayed', 'medical-clinic'), 
			'timetable_field_show_booking_button_choice_no' =>					esc_html__('No', 'medical-clinic'), 
			'timetable_field_show_booking_button_choice_always' =>				esc_html__('Always', 'medical-clinic'), 
			'timetable_field_show_booking_button_choice_on_hover' =>			esc_html__('On hover', 'medical-clinic'), 
			'timetable_field_show_available_slots_title' =>						esc_html__('Show available slots', 'medical-clinic'), 
			'timetable_field_show_available_slots_descr' =>						esc_html__('Specify if the \'available slots\' information should be displayed', 'medical-clinic'), 
			'timetable_field_show_available_slots_choice_no' =>					esc_html__('No', 'medical-clinic'), 
			'timetable_field_show_available_slots_choice_always' =>				esc_html__('Always', 'medical-clinic'), 
			'timetable_field_available_slots_singular_label_title' =>			esc_html__('Available slots singular label', 'medical-clinic'), 
			'timetable_field_available_slots_singular_label_descr' =>			esc_html__('Specify text label for slot available information (singular). Available placeholders: {number_available}, {number_taken}, {number_total}', 'medical-clinic'), 
			'timetable_field_available_slots_singular_label_def' =>				esc_html__('{number_available}/{number_total} slot available', 'medical-clinic'), 
			'timetable_field_available_slots_plural_label_title' =>				esc_html__('Available slots plural label', 'medical-clinic'), 
			'timetable_field_available_slots_plural_label_descr' =>				esc_html__('Specify text label for slots available information (plural). Available placeholders: {number_available}, {number_taken}, {number_total}', 'medical-clinic'), 
			'timetable_field_available_slots_plural_label_def' =>				esc_html__('{number_available}/{number_total} slots available', 'medical-clinic'), 
			'timetable_field_default_booking_view_title' =>						esc_html__('Default booking view', 'medical-clinic'), 
			'timetable_field_default_booking_view_descr' =>						esc_html__('Specify which booking view should be visible by default', 'medical-clinic'), 
			'timetable_field_default_booking_view_choice_user' =>				esc_html__('User', 'medical-clinic'), 
			'timetable_field_default_booking_view_choice_guest' =>				esc_html__('Guest', 'medical-clinic'), 
			'timetable_field_allow_user_booking_title' =>						esc_html__('Allow user booking', 'medical-clinic'), 
			'timetable_field_allow_user_booking_descr' =>						esc_html__('Set to Yes if you want to allow logged in users to make a booking', 'medical-clinic'), 
			'timetable_field_allow_user_booking_choice_yes' =>					esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_allow_user_booking_choice_no' =>					esc_html__('No', 'medical-clinic'), 
			'timetable_field_allow_guest_booking_title' =>						esc_html__('Allow guest booking', 'medical-clinic'), 
			'timetable_field_allow_guest_booking_descr' =>						esc_html__('Set to Yes if you want to allow guests to make a booking', 'medical-clinic'), 
			'timetable_field_allow_guest_booking_choice_yes' =>					esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_allow_guest_booking_choice_no' =>					esc_html__('No', 'medical-clinic'), 
			'timetable_field_show_guest_name_field_title' =>					esc_html__('Show guest name field', 'medical-clinic'), 
			'timetable_field_show_guest_name_field_descr' =>					esc_html__('Set to Yes if you want to show Name field in guest booking form', 'medical-clinic'), 
			'timetable_field_show_guest_name_field_choice_yes' =>				esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_show_guest_name_field_choice_no' =>				esc_html__('No', 'medical-clinic'), 
			'timetable_field_guest_name_field_required_title' =>				esc_html__('Guest name field required', 'medical-clinic'), 
			'timetable_field_guest_name_field_required_descr' =>				esc_html__('Set to Yes if the Name field should be required', 'medical-clinic'), 
			'timetable_field_guest_name_field_required_choice_yes' =>			esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_guest_name_field_required_choice_no' =>			esc_html__('No', 'medical-clinic'), 
			'timetable_field_show_guest_phone_field_title' =>					esc_html__('Show guest phone field', 'medical-clinic'), 
			'timetable_field_show_guest_phone_field_descr' =>					esc_html__('Set to Yes if you want to show Phone field in guest booking form', 'medical-clinic'), 
			'timetable_field_show_guest_phone_field_choice_yes' =>				esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_show_guest_phone_field_choice_no' =>				esc_html__('No', 'medical-clinic'), 
			'timetable_field_guest_phone_field_required_title' =>				esc_html__('Guest phone field required', 'medical-clinic'), 
			'timetable_field_guest_phone_field_required_descr' =>				esc_html__('Set to Yes if the Phone field should be required', 'medical-clinic'), 
			'timetable_field_guest_phone_field_required_choice_yes' =>			esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_guest_phone_field_required_choice_no' =>			esc_html__('No', 'medical-clinic'), 
			'timetable_field_show_guest_message_field_title' =>					esc_html__('Show guest message field', 'medical-clinic'), 
			'timetable_field_show_guest_message_field_descr' =>					esc_html__('Set to Message if you want to show Phone field in guest booking form', 'medical-clinic'), 
			'timetable_field_show_guest_message_field_choice_yes' =>			esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_show_guest_message_field_choice_no' =>				esc_html__('No', 'medical-clinic'), 
			'timetable_field_guest_message_field_required_title' =>				esc_html__('Guest message field required', 'medical-clinic'), 
			'timetable_field_guest_message_field_required_descr' =>				esc_html__('Set to Yes if the Message field should be required', 'medical-clinic'), 
			'timetable_field_guest_message_field_required_choice_yes' =>		esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_guest_message_field_required_choice_no' =>			esc_html__('No', 'medical-clinic'), 
			'timetable_field_booking_label_title' =>							esc_html__('Booking label', 'medical-clinic'), 
			'timetable_field_booking_label_descr' =>							esc_html__('Specify text label for booking button', 'medical-clinic'), 
			'timetable_field_booking_label_def' =>								esc_html__('Book now', 'medical-clinic'), 
			'timetable_field_booked_label_title' =>								esc_html__('Booked label', 'medical-clinic'), 
			'timetable_field_booked_label_descr' =>								esc_html__('Specify text label for already booked event', 'medical-clinic'), 
			'timetable_field_booked_label_def' =>								esc_html__('Booked', 'medical-clinic'), 
			'timetable_field_unavailable_label_title' =>						esc_html__('Unavailable label', 'medical-clinic'), 
			'timetable_field_unavailable_label_descr' =>						esc_html__('Specify text label for unavailable event', 'medical-clinic'), 
			'timetable_field_unavailable_label_def' =>							esc_html__('Unavailable', 'medical-clinic'), 
			'timetable_field_booking_popup_label_title' =>						esc_html__('Popup Booking Label', 'medical-clinic'), 
			'timetable_field_booking_popup_label_descr' =>						esc_html__('Specify text label for booking button in the popup window', 'medical-clinic'), 
			'timetable_field_booking_popup_label_def' =>						esc_html__('Book now', 'medical-clinic'), 
			'timetable_field_login_popup_label_title' =>						esc_html__('Popup Login Label', 'medical-clinic'), 
			'timetable_field_login_popup_label_descr' =>						esc_html__('Specify text label for login button in the popup window', 'medical-clinic'), 
			'timetable_field_login_popup_label_def' =>							esc_html__('Log in', 'medical-clinic'), 
			'timetable_field_cancel_popup_label_title' =>						esc_html__('Popup Cancel Label', 'medical-clinic'), 
			'timetable_field_cancel_popup_label_descr' =>						esc_html__('Specify text label for cancel button in the popup window', 'medical-clinic'), 
			'timetable_field_cancel_popup_label_def' =>							esc_html__('Cancel', 'medical-clinic'), 
			'timetable_field_continue_popup_label_title' =>						esc_html__('Popup Continue Label', 'medical-clinic'), 
			'timetable_field_continue_popup_label_descr' =>						esc_html__('Specify text label for continue button in the popup window', 'medical-clinic'), 
			'timetable_field_continue_popup_label_def' =>						esc_html__('Continue', 'medical-clinic'), 
			'timetable_field_terms_checkbox_title' =>							esc_html__('Terms and conditions checkbox', 'medical-clinic'), 
			'timetable_field_terms_checkbox_descr' =>							esc_html__('Set to Enable if you want to display Terms and conditions checkbox', 'medical-clinic'), 
			'timetable_field_terms_checkbox_choice_yes' =>						esc_html__('Yes', 'medical-clinic'), 
			'timetable_field_terms_checkbox_choice_no' =>						esc_html__('No', 'medical-clinic'), 
			'timetable_field_terms_message_title' =>							esc_html__('Terms and conditions message', 'medical-clinic'), 
			'timetable_field_terms_message_descr' =>							esc_html__('Specify text for Terms and conditions checkbox', 'medical-clinic'), 
			'timetable_field_terms_message_def' =>								esc_html__('Please accept terms and conditions', 'medical-clinic'), 
			'timetable_field_booking_popup_message_title' =>					esc_html__('Booking pop-up message', 'medical-clinic'), 
			'timetable_field_booking_popup_message_descr' =>					esc_html__('Specify text that will appear in pop-up window. Available placeholders:', 'medical-clinic'), 
			'timetable_field_booking_popup_thank_you_message_title' =>			esc_html__('Booking pop-up thank you message', 'medical-clinic'), 
			'timetable_field_box_bg_color_title' =>								esc_html__('Timetable box background color', 'medical-clinic'), 
			'timetable_field_box_bd_color_title' =>								esc_html__('Timetable box border color', 'medical-clinic'), 
			'timetable_field_box_hover_bg_color_title' =>						esc_html__('Timetable box hover background color', 'medical-clinic'), 
			'timetable_field_box_txt_color_title' =>							esc_html__('Timetable box text color', 'medical-clinic'), 
			'timetable_field_box_hover_txt_color_title' =>						esc_html__('Timetable box hover text color', 'medical-clinic'), 
			'timetable_field_box_hours_txt_color_title' =>						esc_html__('Timetable box hours text color', 'medical-clinic'), 
			'timetable_field_box_hours_hover_txt_color_title' =>				esc_html__('Timetable box hours hover text color', 'medical-clinic'), 
			'timetable_field_row1_bg_color_title' =>							esc_html__('Row 1 style background color', 'medical-clinic'), 
			'timetable_field_row1_txt_color_title' =>							esc_html__('Row 1 style text color', 'medical-clinic'), 
			'timetable_field_row2_bg_color_title' =>							esc_html__('Row 2 style background color', 'medical-clinic'), 
			'timetable_field_row2_txt_color_title' =>							esc_html__('Row 2 style text color', 'medical-clinic'), 
			'timetable_field_booking_text_color_title' =>						esc_html__('Booking text color', 'medical-clinic'), 
			'timetable_field_booking_bg_color_title' =>							esc_html__('Booking background color', 'medical-clinic'), 
			'timetable_field_booking_hover_text_color_title' =>					esc_html__('Booking hover text color', 'medical-clinic'), 
			'timetable_field_booking_hover_bg_color_title' =>					esc_html__('Booking hover background color', 'medical-clinic'), 
			'timetable_field_booked_text_color_title' =>						esc_html__('Booked text color', 'medical-clinic'), 
			'timetable_field_booked_bg_color_title' =>							esc_html__('Booked background color', 'medical-clinic'), 
			'timetable_field_unavailable_text_color_title' =>					esc_html__('Unavailable text color', 'medical-clinic'), 
			'timetable_field_unavailable_bg_color_title' =>						esc_html__('Unavailable background color', 'medical-clinic'), 
			'timetable_field_available_slots_color_title' =>					esc_html__('Available slots color', 'medical-clinic'), 
			
			
			/* Default Colors */
			'box_bg_color' => 				($cmsmasters_option['medical-clinic' . '_default' . '_link'] == '#3065b5' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_link']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_link']), 
			'box_hover_bg_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_secondary'] == '#3eb8d7' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_secondary']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_secondary']), 
			'box_bd_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_border'] == '#e0e0e0' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_border']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_border']), 
			'box_txt_color' => 				($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'box_hover_txt_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'box_hours_txt_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'box_hours_hover_txt_color' => 	($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'row1_bg_color' => 				($cmsmasters_option['medical-clinic' . '_default' . '_alternate'] == '#fcfcfc' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_alternate']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_alternate']), 
			'row1_txt_color' => 			($cmsmasters_option['medical-clinic' . '_default' . '_color'] == '#787878' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_color']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_color']), 
			'row2_bg_color' => 				($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'row2_txt_color' => 			($cmsmasters_option['medical-clinic' . '_default' . '_color'] == '#787878' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_color']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_color']), 
			'booking_text_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'booking_bg_color' => 			($cmsmasters_option['medical-clinic' . '_default' . '_heading'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_heading']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_heading']), 
			'booking_hover_text_color' => 	($cmsmasters_option['medical-clinic' . '_default' . '_link'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_link']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_link']), 
			'booking_hover_bg_color' => 	($cmsmasters_option['medical-clinic' . '_default' . '_heading'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_heading']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_heading']), 
			'booked_text_color' => 			($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'booked_bg_color' => 			($cmsmasters_option['medical-clinic' . '_default' . '_heading'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_heading']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_heading']), 
			'unavailable_text_color' => 	($cmsmasters_option['medical-clinic' . '_default' . '_bg'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_bg']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_bg']), 
			'unavailable_bg_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_heading'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_heading']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_heading']), 
			'available_slots_color' => 		($cmsmasters_option['medical-clinic' . '_default' . '_color'] == '#ffffff' ? 'rgba(' . cmsmasters_color2rgb($cmsmasters_option['medical-clinic' . '_default' . '_color']) . ', 0.99)' : $cmsmasters_option['medical-clinic' . '_default' . '_color']) 
		));
	}
}

add_action('admin_enqueue_scripts', 'medical_clinic_timetable_register_c_c_scripts');


/* Events */
function medical_clinic_timetable_events() {
	$timetable_events = get_posts(array(
		'numberposts' => -1, 
		'post_type' => 'events'
	));
	
	
	$out = array();
	
	
	if (!empty($timetable_events)) {
		foreach ($timetable_events as $timetable_event) {
			$out[urldecode($timetable_event->post_name)] = esc_html($timetable_event->post_title);
		}
	}
	
	
	return $out;
}


/* Event Categories */
function medical_clinic_timetable_event_categories() {
	$categories = get_terms('events_category', array( 
		'hide_empty' => 0 
	));
	
	
	$out = array();
	
	
	if (!empty($categories)) {
		foreach ($categories as $category) {
			$out[urldecode(esc_attr($category->slug))] = esc_html($category->name);
		}
	}
	
	
	return $out;
}


/* Hour Categories */
function medical_clinic_timetable_hour_categories() {
	global $wpdb;
	
	
	$query = $wpdb->prepare("SELECT distinct(category) AS category FROM {$wpdb->prefix}event_hours AS t1
		LEFT JOIN {$wpdb->posts} AS t2 ON t1.event_id=t2.ID 
		WHERE 
		t2.post_type='%s'
		AND t2.post_status='publish'
		AND category<>''", 'events');
	
	
	$categories = $wpdb->get_results($query);
	
	
	$out = array();
	
	
	if (!empty($categories)) {
		foreach ($categories as $category) {
			$out[esc_attr($category->category)] = esc_html($category->category);
		}
	}
	
	
	return $out;
}


/* Columns */
function medical_clinic_timetable_columns() {
	$timetable_columns = get_posts(array(
		'numberposts' => -1, 
		'post_type' => 'timetable_weekdays'
	));
	
	
	$out = array();
	
	
	if (!empty($timetable_columns)) {
		foreach ($timetable_columns as $timetable_column) {
			$out[urldecode($timetable_column->post_name)] = esc_html($timetable_column->post_title);
		}
	}
	
	
	return $out;
}

