<?php

class AH_Youtube_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
                // Base ID of your widget
                'AH-Youtube-widget-form',
                // Widget name will appear in UI
                esc_html__('AH | Youtube Downloader', 'ah-yt'),
                // Widget description
                array('description' => esc_html__('Download videos and playlists with multi types', 'ah-yt'),)
        );
    }


    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance) {
        global $SoundCloud_API;
        $title = apply_filters('widget_title', $instance['title']);
        $hide_title = !empty($instance['hide_title']) ? $instance['hide_title'] : '';
        //$form_layout = isset($instance['form_layout']) ? $instance['form_layout'] : '';
        // before and after widget arguments are defined by themes
        echo empty($instance['hide_widget']) ? $args['before_widget'] : '';
        ?>
        <?php if ($hide_title != 'true') { ?>
            <h2><?php echo (!empty($title)) ? $title : esc_html__('AH-Youtube Downloader', 'ah-yt'); ?></h2>
        <?php } ?>
        <div class="widget-ah-youtube" id="<?php echo $this->id; ?>" data-apikey="<?php echo AH_KEY; ?>">
            <form method="GET" action="">
                <input type="text" name="ah-input" placeholder="<?php _e('Search here ... ','ah-yt'); ?>">
            </form>
        </div>
        <?php
        echo empty($instance['hide_widget']) ? $args['after_widget'] : '';
    }

    // Widget Backend 
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $hide_title = !empty($instance['hide_title']) ? $instance['hide_title'] : '';
        $hide_widget = !empty($instance['hide_widget']) ? $instance['hide_widget'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php esc_html_e('Title', 'ah-yt'); ?>: 
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <input  class="widefat" type="checkbox" <?php checked('true', $hide_title); ?> id="<?php echo $this->get_field_id('hide_title'); ?>" name="<?php echo $this->get_field_name('hide_title'); ?>" value="true">
            <label for="<?php echo $this->get_field_id('hide_title'); ?>"><?php esc_html_e('Hide Title', 'ah-yt'); ?></label>
        </p>
        <p>
            <input class="checkbox" <?php checked($hide_widget, 'true'); ?> id="<?php echo $this->get_field_id('hide_widget'); ?>" name="<?php echo $this->get_field_name('hide_widget'); ?>" type="checkbox" value="true">
            <label for="<?php echo $this->get_field_id('hide_widget'); ?>"><?php esc_html_e('Hide Before & After Widget', 'ah-yt'); ?></label>
        </p>
        <?php
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['hide_title'] = (!empty($new_instance['hide_title']) ) ? strip_tags($new_instance['hide_title']) : '';
        $instance['hide_widget'] = (!empty($new_instance['hide_widget']) ) ? strip_tags($new_instance['hide_widget']) : '';
        //$instance['form_layout'] = (!empty($new_instance['form_layout']) ) ? strip_tags($new_instance['form_layout']) : '';
        return $instance;
    }

}