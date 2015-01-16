<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */
global $post_settings; ?>
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