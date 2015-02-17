<?php
/**
 * @package Energizo
 * @author Wonster
 * @link http://wonster.co/
 */

if ( !defined('ABSPATH') ) { die('-1'); }

if( ! class_exists( 'WTR_Facebook_Like_Box_Widget' ) ) {

	/**
	 * Adds WTR_Facebook_Like_Box_Widget
	 */

	class WTR_Facebook_Like_Box_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {
			parent::__construct(
				'wtr_facebook_like_box', // Base ID
				WTR_THEME_NAME . ' ' . __( 'facebook like box ', 'wtr_framework' ),
				array( 'description' => __( 'You can link You Facebook fanpage here', 'wtr_framework' ), )
			);
		} // end __construct

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			$title 			= apply_filters( 'widget_title', $instance['title'] );
			$page_url 		= $instance['page_url'];
			$color_scheme 	= $instance['color_scheme'];
			$show_faces 	= $instance['show_faces'];
			$show_stream 	= $instance['show_stream'];
			$show_header 	= $instance['show_header'];
			$show_border 	= $instance['show_border'];
			$width 			= $instance['width'];
			$height 		= '62';

			if( 'true' == $show_faces){
				$height = $height + 196;
			}

			if( 'true' == $show_stream ){
				$height = $height + 300;
			}

			if('true' == $show_header ) {
				$height = $height + 32;
			}

			echo $args['before_widget'];

			if ( ! empty( $title ) ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			if($page_url): ?>
				<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($page_url); ?>&amp;width=<?php echo $width; ?>&amp;height=<?php echo $height; ?>&amp;colorscheme=<?php echo $color_scheme; ?>&amp;show_faces=<?php echo $show_faces; ?>&amp;header=<?php echo $show_header; ?>&amp;stream=<?php echo $show_stream; ?>&amp;show_border=<?php echo $show_border?>" scrolling="no" frameborder="0" style="background-color:#FFF;border:none; overflow:hidden; width:<?php echo $width; ?>px; height: <?php echo $height; ?>px;" allowTransparency="false"></iframe>
			<?php endif;
			echo $args['after_widget'];
		} // end widget

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title 			= isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
			$width 			= isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '292';
			$page_url		= isset( $instance['page_url'] ) ? esc_attr( $instance['page_url'] ) : '';
			$color_scheme	= isset( $instance['color_scheme'] ) ? esc_attr( $instance['color_scheme'] ) : 'light';
			$show_faces		= isset( $instance['show_faces'] ) ? esc_attr( $instance['show_faces'] ) : '';
			$show_stream	= isset( $instance['show_stream'] ) ? esc_attr( $instance['show_stream'] ) : '';
			$show_header	= isset( $instance['show_header'] ) ? esc_attr( $instance['show_header'] ) : '';
			$show_border	= isset( $instance['show_border'] ) ? esc_attr( $instance['show_border'] ) : '';
			?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('page_url'); ?>"><?php _e( 'Facebook Page URL', WTR_THEME_NAME ); ?> :</label>
				<input class="widefat" id="<?php echo $this->get_field_id('page_url'); ?>" name="<?php echo $this->get_field_name('page_url'); ?>" type="text" value="<?php echo $page_url; ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e( 'Width', WTR_THEME_NAME ); ?> : </label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('color_scheme'); ?>"><?php _e( 'Color Scheme', WTR_THEME_NAME ); ?>:</label>
				<select id="<?php echo $this->get_field_id('color_scheme'); ?>" name="<?php echo $this->get_field_name('color_scheme'); ?>">
					<option value="light"<?php selected( 'light', $color_scheme)  ?> ><?php _e('Light', WTR_THEME_NAME ); ?></option>
					<option value="dark" <?php selected( 'dark', $color_scheme) ?> ><?php _e('Dark', WTR_THEME_NAME ); ?></option>
				</select>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_faces , 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" />
				<label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php _e('Show faces', WTR_THEME_NAME ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_stream, 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" />
				<label for="<?php echo $this->get_field_id('show_stream'); ?>"><?php _e('Show stream', WTR_THEME_NAME ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_header, 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" />
				<label for="<?php echo $this->get_field_id('show_header'); ?>"><?php _e('Show facebook header', WTR_THEME_NAME ); ?></label>
			</p>
			<p>
				<input class="checkbox" type="checkbox" <?php checked( $show_border, 'true'); ?> value="true" id="<?php echo $this->get_field_id('show_border'); ?>" name="<?php echo $this->get_field_name('show_border'); ?>" />
				<label for="<?php echo $this->get_field_id('show_border'); ?>"><?php _e('Show border', WTR_THEME_NAME ); ?></label>
			</p>
			<?php
		} // end form

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {

			$instance 					= array();
			$instance['title']			= ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['page_url'] 		= ( ! empty( $new_instance['page_url'] ) ) ? strip_tags( $new_instance['page_url'] ) : '';
			$instance['width'] 			= ( ! empty( $new_instance['width'] ) ) ? strip_tags( $new_instance['width'] ) : '';
			$instance['color_scheme']	= ( ! empty( $new_instance['color_scheme'] ) ) ? strip_tags( $new_instance['color_scheme'] ) : '';
			$instance['show_faces']		= ( ! empty( $new_instance['show_faces'] ) ) ? strip_tags( $new_instance['show_faces'] ) : 'false';
			$instance['show_stream']	= ( ! empty( $new_instance['show_stream'] ) ) ? strip_tags( $new_instance['show_stream'] ) : 'false';
			$instance['show_header']	= ( ! empty( $new_instance['show_header'] ) ) ? strip_tags( $new_instance['show_header'] ) : 'false';
			$instance['show_border']	= ( ! empty( $new_instance['show_border'] ) ) ? strip_tags( $new_instance['show_border'] ) : 'false';
			return $instance;
		} // end update

	} // class Foo_Widget
}