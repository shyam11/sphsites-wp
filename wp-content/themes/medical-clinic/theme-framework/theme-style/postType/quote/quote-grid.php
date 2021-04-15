<?php
/**
 * @package 	WordPress
 * @subpackage 	Medical Clinic
 * @version		1.1.4
 * 
 * Quote Grid Template
 * Created by CMSMasters
 * 
 */


$unique_id = uniqid();

?>
<!-- Start Quote Grid Article -->
<article class="cmsmasters_quote_inner" <?php echo 'id="cmsmasters_quote_' . $unique_id . '"';?>>
	<?php 
		if ($quote_color != '') {
			medical_clinic_quote_color($unique_id, 'grid', $quote_color);
		}
		
		if ($quote_image != '') {
			echo '<figure class="cmsmasters_quote_image">' . 
					wp_get_attachment_image(strstr($quote_image, '|', true), 'cmsmasters-small-thumb') . 
				'</figure>';
		}
			
		echo '<div class="cmsmasters_quote_content_wrap">';
							
			echo cmsmasters_divpdel('<div class="cmsmasters_quote_content">' . 
				do_shortcode(wpautop(wp_kses(stripslashes($quote_content), 'post'))) . 
			'</div>');
			
			if ($quote_name != '') {
				echo '<header class="cmsmasters_quote_header">' . 
					'<h4 class="cmsmasters_quote_title">' . esc_html($quote_name) . '</h4>' . 
				'</header>';
			}
			
			if ($quote_subtitle != '' || $quote_website != '' || $quote_link != '') {
				echo '<div class="cmsmasters_quote_subtitle_wrap">' . 
					
					($quote_subtitle != '' ? '<h6 class="cmsmasters_quote_subtitle">' . esc_html($quote_subtitle) . '</h6>' : '');
					
					
					if ($quote_website != '' || $quote_link != '') {
						echo '<span class="cmsmasters_quote_site">' . 
							($quote_link != '' ? '<a href="' . esc_url($quote_link) . '" target="_blank">' : '') . 
							
							($quote_website != '' ? esc_html($quote_website) : esc_html($quote_link)) . 
							
							($quote_link != '' ? '</a>' : '') . 
						'</span>';
					}
					
				echo '</div>';
			}
			
		echo '</div>';
	?>
</article>
<!-- Finish Quote Grid Article -->

