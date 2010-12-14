<?php
/*
Plugin Name: Sidebar Downloads
Plugin URI: http://corefactor.pt/
Description: Select a file from the media to add as a link on a sidebar
Author: CoreFactor
Version: 1
*/

// register FooWidget widget
add_action('widgets_init', create_function('', 'return register_widget("SidebarDownload");'));


/**
 * SidebarDownload Class
 */
class SidebarDownload extends WP_Widget {
    /** constructor */
    function SidebarDownload() {
        parent::WP_Widget(false, $name = 'SidebarDownload');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
	
        extract( $args );
        echo $before_widget;
		if ( !empty($instance['title']) && !empty($instance['filename']) ) {
			echo "<a class='sidebar-download-btn' href='{$instance['filename']}'>{$instance['title']}</a>";
		}
		
		echo $after_widget;
			
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['filename'] = strip_tags($new_instance['filename']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {			
		
        $title = esc_attr($instance['title']);
		$filename = esc_attr($instance['filename']);
		
		$files = get_posts('post_type=attachment');
				
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('filename'); ?>"><?php _e('File:'); ?> <select class="widefat" id="<?php echo $this->get_field_id('filename'); ?>" name="<?php echo $this->get_field_name('filename'); ?>">
				<?php foreach($files as $file): ?>
					<option value="<?php echo $file->guid ?>" <?php if ( $file->guid == $instance['filename'] ) echo 'selected="selected"'; ?>><?php echo $file->post_title; ?></option>
				<?php endforeach; ?>
			</select></label></p>
        <?php 

		unset($files);

    }

} // class SidebarDownload


?>