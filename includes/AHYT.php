<?php

/**
 * Description of AH Youtube
 *
 * @author Abdo Hamoud
 */
class AHYT {

    public $pagenow;
    public $wpdb;

    public function __construct() {
        global $pagenow, $wpdb;
        $this->wpdb = $wpdb;
        $this->pagenow = $pagenow;
        add_action('wp_enqueue_scripts', array($this, 'front_head'));
        add_action('widgets_init', array($this, 'add_widgets'));
    }

    // add CSS and JavaScript to front head
    public function front_head() {
        wp_enqueue_style('ah-youtube-css', AH_URL . '/assets/css/ah-yt-main.css');
        wp_enqueue_script('ah-youtube-js', AH_URL . '/assets/js/ah-yt-app.js', array('jquery'));
    }
    
    public function add_widgets() {
        register_widget('AH_Youtube_widget');
    }

}

new AHYT();
