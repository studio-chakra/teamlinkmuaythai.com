<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */
global $post_settings; ?>
			<section class="footer-features clearfix">
				<?php echo do_shortcode('[vc_column width="1/1"][vc_row_inner columns_type="wtrMargin" columns_autohight="wtrAutoHeightColumns" animate="none" delay="0" el_class="footer-features-in"][vc_column_inner width="2/3" css=" cta-trial" img_attr="default" corner="wtrRoundedCornersColumn" animate="none" delay="0"][vc_custom_heading text="START TRAINING TODAY!" font_container="tag:h2|font_size:18|text_align:left|color:%23ffffff" google_fonts="font_family:Montserrat%3Aregular%2C700|font_style:700%20bold%20regular%3A700%3Anormal" css=".vc_custom_1424636808527{margin-bottom: 0px !important;}"][vc_custom_heading text="FREE TRIAL PACKAGE" font_container="tag:h2|font_size:52|text_align:left|color:%23ffffff" google_fonts="font_family:Dosis%3A200%2C300%2Cregular%2C500%2C600%2C700%2C800|font_style:600%20bold%20regular%3A600%3Anormal"][vc_custom_heading text="Start your Muay Thai journey today! Our free trial includes an initial consultation, free group class & free private lesson." font_container="tag:p|font_size:24|text_align:left|color:%23ffffff" google_fonts="font_family:Dosis%3A200%2C300%2Cregular%2C500%2C600%2C700%2C800|font_style:400%20regular%3A400%3Anormal"][vc_wtr_button url="url:%2Ffree-trial|title:Free%20Trial|" label="Start my free trial" align="none" size="big" color="c_white" corner="wtrButtonRad" background="wtrButtonNoTrans" animate_icon="wtrButtonHoverAnim" full_width="wtrButtonNoFullWidth" margin_left="0" margin_right="0" margin_top="0" margin_bottom="0" animate="none" delay="0"][/vc_column_inner][vc_column_inner width="1/3" css=" cta-contactus" img_attr="default" corner="wtrRoundedCornersColumn" animate="none" delay="0"][vc_custom_heading text="QUESTIONS?" font_container="tag:h2|font_size:18|text_align:left|color:%23ffffff" google_fonts="font_family:Montserrat%3Aregular%2C700|font_style:700%20bold%20regular%3A700%3Anormal" css=".vc_custom_1424637297581{margin-bottom: 0px !important;}"][vc_custom_heading text="CONTACT US" font_container="tag:h2|font_size:36|text_align:left|color:%23ffffff" google_fonts="font_family:Dosis%3A200%2C300%2Cregular%2C500%2C600%2C700%2C800|font_style:600%20bold%20regular%3A600%3Anormal"][vc_custom_heading text="We are always here to provide you with the information needed to help you get started." font_container="tag:p|font_size:18|text_align:left|color:%23ffffff" google_fonts="font_family:Dosis%3A200%2C300%2Cregular%2C500%2C600%2C700%2C800|font_style:400%20regular%3A400%3Anormal"][vc_wtr_button url="url:%2Fcontact-us%2F|title:Contact%20Us|" label="Contact us" align="none" size="normal" color="c_darkGrey" corner="wtrButtonRad" background="wtrButtonNoTrans" animate_icon="wtrButtonHoverAnim" full_width="wtrButtonNoFullWidth" margin_left="0" margin_right="0" margin_top="0" animate="none" delay="0" margin_bottom="0"][/vc_column_inner][/vc_row_inner][/vc_column]'); ?>
			</section>
			<footer class="wtrFooter clearfix <?php echo $post_settings['wtr_FooterClassImg']; ?> " <?php echo $post_settings['wtr_FooterStyle']; ?> >
				<?php wtr_footer_column() ?>
				<?php wtr_footer_copy() ?>
			</footer>
			<?php ?>
			<?php echo $post_settings['wtr_Boxed_end'] ?>
			<?php wtr_wp_nav_smart_menu(); ?>
		</div>
	</div>
	<?php wp_footer(); ?>
<!--End body-->
</body>
<!--End html-->
</html>