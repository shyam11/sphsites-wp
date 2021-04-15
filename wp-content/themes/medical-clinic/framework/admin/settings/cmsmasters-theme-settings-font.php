<?php 
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version		1.1.6
 * 
 * Admin Panel Fonts Options
 * Created by CMSMasters
 * 
 */


function medical_clinic_options_font_tabs() {
	$tabs = array();
	
	$tabs['content'] = esc_attr__('Content', 'medical-clinic');
	$tabs['link'] = esc_attr__('Links', 'medical-clinic');
	$tabs['nav'] = esc_attr__('Navigation', 'medical-clinic');
	$tabs['heading'] = esc_attr__('Heading', 'medical-clinic');
	$tabs['other'] = esc_attr__('Other', 'medical-clinic');
	$tabs['google'] = esc_attr__('Google Fonts', 'medical-clinic');
	
	return apply_filters('cmsmasters_options_font_tabs_filter', $tabs);
}


function medical_clinic_options_font_sections() {
	$tab = medical_clinic_get_the_tab();
	
	switch ($tab) {
	case 'content':
		$sections = array();
		
		$sections['content_section'] = esc_html__('Content Font Options', 'medical-clinic');
		
		break;
	case 'link':
		$sections = array();
		
		$sections['link_section'] = esc_html__('Links Font Options', 'medical-clinic');
		
		break;
	case 'nav':
		$sections = array();
		
		$sections['nav_section'] = esc_html__('Navigation Font Options', 'medical-clinic');
		
		break;
	case 'heading':
		$sections = array();
		
		$sections['heading_section'] = esc_html__('Headings Font Options', 'medical-clinic');
		
		break;
	case 'other':
		$sections = array();
		
		$sections['other_section'] = esc_html__('Other Fonts Options', 'medical-clinic');
		
		break;
	case 'google':
		$sections = array();
		
		$sections['google_section'] = esc_html__('Serving Google Fonts from CDN', 'medical-clinic');
		
		break;
	default:
		$sections = array();
		
		
		break;
	}
	
	return apply_filters('cmsmasters_options_font_sections_filter', $sections, $tab);
} 


function medical_clinic_options_font_fields($set_tab = false) {
	if ($set_tab) {
		$tab = $set_tab;
	} else {
		$tab = medical_clinic_get_the_tab();
	}
	
	
	$options = array();
	
	
	$defaults = medical_clinic_settings_font_defaults();
	
	
	switch ($tab) {
	case 'content':
		$options[] = array( 
			'section' => 'content_section', 
			'id' => 'medical-clinic' . '_content_font', 
			'title' => esc_html__('Main Content Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_content_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style' 
			) 
		);
		
		break;
	case 'link':
		$options[] = array( 
			'section' => 'link_section', 
			'id' => 'medical-clinic' . '_link_font', 
			'title' => esc_html__('Links Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_link_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		$options[] = array( 
			'section' => 'link_section', 
			'id' => 'medical-clinic' . '_link_hover_decoration', 
			'title' => esc_html__('Links Hover Text Decoration', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'select_scheme', 
			'std' => $defaults[$tab]['medical-clinic' . '_link_hover_decoration'], 
			'choices' => medical_clinic_text_decoration_list() 
		);
		
		break;
	case 'nav':
		$options[] = array( 
			'section' => 'nav_section', 
			'id' => 'medical-clinic' . '_nav_title_font', 
			'title' => esc_html__('Navigation Title Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_nav_title_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform' 
			) 
		);
		
		$options[] = array( 
			'section' => 'nav_section', 
			'id' => 'medical-clinic' . '_nav_dropdown_font', 
			'title' => esc_html__('Navigation Dropdown Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_nav_dropdown_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform' 
			) 
		);
		
		break;
	case 'heading':
		$options[] = array( 
			'section' => 'heading_section', 
			'id' => 'medical-clinic' . '_h1_font', 
			'title' => esc_html__('H1 Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_h1_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		$options[] = array( 
			'section' => 'heading_section', 
			'id' => 'medical-clinic' . '_h2_font', 
			'title' => esc_html__('H2 Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_h2_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		$options[] = array( 
			'section' => 'heading_section', 
			'id' => 'medical-clinic' . '_h3_font', 
			'title' => esc_html__('H3 Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_h3_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		$options[] = array( 
			'section' => 'heading_section', 
			'id' => 'medical-clinic' . '_h4_font', 
			'title' => esc_html__('H4 Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_h4_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		$options[] = array( 
			'section' => 'heading_section', 
			'id' => 'medical-clinic' . '_h5_font', 
			'title' => esc_html__('H5 Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_h5_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		$options[] = array( 
			'section' => 'heading_section', 
			'id' => 'medical-clinic' . '_h6_font', 
			'title' => esc_html__('H6 Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_h6_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform', 
				'text_decoration' 
			) 
		);
		
		break;
	case 'other':
		$options[] = array( 
			'section' => 'other_section', 
			'id' => 'medical-clinic' . '_button_font', 
			'title' => esc_html__('Button Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_button_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform' 
			) 
		);
		
		$options[] = array( 
			'section' => 'other_section', 
			'id' => 'medical-clinic' . '_small_font', 
			'title' => esc_html__('Small Tag Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_small_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style', 
				'text_transform' 
			) 
		);
		
		$options[] = array( 
			'section' => 'other_section', 
			'id' => 'medical-clinic' . '_input_font', 
			'title' => esc_html__('Text Fields Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_input_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style' 
			) 
		);
		
		$options[] = array( 
			'section' => 'other_section', 
			'id' => 'medical-clinic' . '_quote_font', 
			'title' => esc_html__('Blockquote Font', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'typorgaphy', 
			'std' => $defaults[$tab]['medical-clinic' . '_quote_font'], 
			'choices' => array( 
				'system_font', 
				'google_font', 
				'font_size', 
				'line_height', 
				'font_weight', 
				'font_style' 
			) 
		);
		
		break;
	case 'google':
		$options[] = array( 
			'section' => 'google_section', 
			'id' => 'medical-clinic' . '_google_web_fonts', 
			'title' => esc_html__('Google Fonts', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'google_web_fonts', 
			'std' => $defaults[$tab]['medical-clinic' . '_google_web_fonts'] 
		);
		
		$options[] = array( 
			'section' => 'google_section', 
			'id' => 'medical-clinic' . '_google_web_fonts_subset', 
			'title' => esc_html__('Google Fonts Subset', 'medical-clinic'), 
			'desc' => '', 
			'type' => 'select_multiple', 
			'std' => '', 
			'choices' => array( 
				esc_html__('Latin Extended', 'medical-clinic') . '|' . 'latin-ext', 
				esc_html__('Arabic', 'medical-clinic') . '|' . 'arabic', 
				esc_html__('Cyrillic', 'medical-clinic') . '|' . 'cyrillic', 
				esc_html__('Cyrillic Extended', 'medical-clinic') . '|' . 'cyrillic-ext', 
				esc_html__('Greek', 'medical-clinic') . '|' . 'greek', 
				esc_html__('Greek Extended', 'medical-clinic') . '|' . 'greek-ext', 
				esc_html__('Vietnamese', 'medical-clinic') . '|' . 'vietnamese', 
				esc_html__('Japanese', 'medical-clinic') . '|' . 'japanese', 
				esc_html__('Korean', 'medical-clinic') . '|' . 'korean', 
				esc_html__('Thai', 'medical-clinic') . '|' . 'thai', 
				esc_html__('Bengali', 'medical-clinic') . '|' . 'bengali', 
				esc_html__('Devanagari', 'medical-clinic') . '|' . 'devanagari', 
				esc_html__('Gujarati', 'medical-clinic') . '|' . 'gujarati', 
				esc_html__('Gurmukhi', 'medical-clinic') . '|' . 'gurmukhi', 
				esc_html__('Hebrew', 'medical-clinic') . '|' . 'hebrew', 
				esc_html__('Kannada', 'medical-clinic') . '|' . 'kannada', 
				esc_html__('Khmer', 'medical-clinic') . '|' . 'khmer', 
				esc_html__('Malayalam', 'medical-clinic') . '|' . 'malayalam', 
				esc_html__('Myanmar', 'medical-clinic') . '|' . 'myanmar', 
				esc_html__('Oriya', 'medical-clinic') . '|' . 'oriya', 
				esc_html__('Sinhala', 'medical-clinic') . '|' . 'sinhala', 
				esc_html__('Tamil', 'medical-clinic') . '|' . 'tamil', 
				esc_html__('Telugu', 'medical-clinic') . '|' . 'telugu' 
			) 
		);
		
		break;
	}
	
	return apply_filters('cmsmasters_options_font_fields_filter', $options, $tab);	
}

