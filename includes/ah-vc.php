<?php

/*
 * To change this template file, choose Tools | Templates
 */

class AH_YT_VCExtendAddonClass {

    function __construct() {
        // We safely integrate with VC with this hook
        add_action('init', array($this, 'integrateWithVC'));
        // Use this when creating a shortcode addon
        add_shortcode('ah-youtube-downloader', array($this, 'renderMyAHYT'));
    }

    public function integrateWithVC() {
        // Check if Visual Composer is installed
        if (!defined('WPB_VC_VERSION')) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array($this, 'showVcVersionNotice'));
            return;
        }

        /*
          Add your Visual Composer logic here.
          Lets call vc_map function to "register" our custom shortcode within Visual Composer interface.

          More info: http://kb.wpbakery.com/index.php?title=Vc_map
         */

        vc_map(array(
            "label" => esc_html__("Youtube Downloader ", 'ah_yt'),
            "name" => esc_html__("Youtube Downloader ", 'ah_yt'),
            "description" => esc_html__("Download videos with multi types ", 'ah_yt'),
            "base" => "ah-youtube-downloader",
            "class" => "ah-youtube-downloader",
            "controls" => "full",
            "icon" => AH_URL . '/assets/images/logo_sc.png', // or css class name which you can reffer in your css file later. Example: "vc_extend_my_class"
            "category" => esc_html__('AH Social Addons', 'js_composer'),
            "params" => array(
                
            )
        ));
    }

    public function playerForm() {
        $widget= "<h1>Hello</h1>";
        return $widget;
    }

    /*
      Shortcode logic how it should be rendered
     */

    public function renderMyAHYT($atts, $content = null) {
        extract(shortcode_atts(array(
            'show_repeat_btn' => ''
                        ), $atts));
        $form = $this->playerForm();
        $output = "<div class='ah-yt-media'>{$form}</div>";
        return $output;
    }

    /*
      Load plugin css and javascript files which you may need on front end of your site
     */

    public function loadCssAndJs() {
        
    }

    /*
      Show notice if your plugin is activated but Visual Composer is not
     */

    public function showVcVersionNotice() {
        $plugin_data = get_plugin_data(__FILE__);
        echo '
        <div class="updated">
          <p>' . sprintf(__('<strong>%s</strong> requires <strong><a href="http://bit.ly/vcomposer" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', 'ah_yt'), $plugin_data['Name']) . '</p>
        </div>';
    }

}
