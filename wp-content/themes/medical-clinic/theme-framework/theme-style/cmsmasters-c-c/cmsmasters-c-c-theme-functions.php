<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version 	1.0.9
 * 
 * Theme Content Composer Functions
 * Created by CMSMasters
 * 
 */


/* Register JS Scripts */
function medical_clinic_theme_register_c_c_scripts() {
	global $pagenow;
	
	
	if ( 
		$pagenow == 'post-new.php' || 
		($pagenow == 'post.php' && isset($_GET['post']) && get_post_type($_GET['post']) != 'attachment') 
	) {
		wp_enqueue_script('medical-clinic-composer-shortcodes-extend', get_template_directory_uri() . '/theme-framework/theme-style' . CMSMASTERS_THEME_STYLE . '/cmsmasters-c-c/js/cmsmasters-c-c-theme-extend.js', array('cmsmasters_composer_shortcodes_js'), '1.0.0', true);
		
		wp_localize_script('medical-clinic-composer-shortcodes-extend', 'cmsmasters_theme_shortcodes', array( 
			'portfolio_field_metadata_choises_icon' =>				esc_attr__('Icon', 'medical-clinic'), 
			'portfolio_field_metadata_choises_more' =>				esc_attr__('Read more', 'medical-clinic'), 
			'posts_slider_field_metadata_choises_icon' =>			esc_attr__('Icon', 'medical-clinic'), 
			'posts_slider_field_metadata_choises_more' =>			esc_attr__('Read more', 'medical-clinic'), 
			'blog_field_layout_mode_puzzle' 	=> 					esc_attr__('Puzzle', 'medical-clinic'), 
			'tab_field_highlight_bg_color_title' 	=> 				esc_attr__('Tab Background Color', 'medical-clinic'), 
			'quotes_field_slider_type_title' => 					esc_attr__('Slider Type', 'medical-clinic'), 
			'quotes_field_slider_type_descr' => 					esc_attr__('Choose your quotes slider style type', 'medical-clinic'), 
			'quotes_field_type_choice_box' => 						esc_attr__('Boxed', 'medical-clinic'), 
			'quotes_field_type_choice_center' => 					esc_attr__('Centered', 'medical-clinic'), 
			'quotes_field_item_color_title' => 						esc_attr__('Color', 'medical-clinic'), 
			'quotes_field_item_color_descr' => 						esc_attr__('Enter this quote custom color', 'medical-clinic') 
		));
	}
}

add_action('admin_enqueue_scripts', 'medical_clinic_theme_register_c_c_scripts');



// Quotes Shortcode Attributes Filter
add_filter('cmsmasters_quotes_atts_filter', 'cmsmasters_quotes_atts');

function cmsmasters_quotes_atts() {
	return array( 
		'shortcode_id' => 		'', 
		'mode' => 				'grid', 
		'type' => 				'boxed', 
		'columns' => 			'3', 
		'speed' => 				'10', 
		'animation' => 			'', 
		'animation_delay' => 	'', 
		'classes' => 			'' 
	);
}


// Quote Item Shortcode Attributes Filter
add_filter('cmsmasters_quote_atts_filter', 'cmsmasters_quote_atts');

function cmsmasters_quote_atts() {
	return array( 
		'shortcode_id' => 	'', 
		'image' => 			'', 
		'name' => 			'', 
		'subtitle' => 		'', 
		'color' => 			'', 
		'link' => 			'', 
		'website' => 		'', 
		'classes' => 		'' 
	);
}



// Tab Shortcode Attributes Filter
add_filter('cmsmasters_tab_atts_filter', 'cmsmasters_tab_atts');

function cmsmasters_tab_atts() {
	return array( 
		'shortcode_id' => 		'', 
		'title' => 				esc_attr__('Title', 'medical-clinic'), 
		'custom_colors' => 		'', 
		'color' => 				'', 
		'bg_color' => 			'', 
		'icon' => 				'', 
		'classes' => 			'' 
	);
}

