<?php

defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

function startsWith ($string, $startString) { 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
}
    
function endsWith($string, $endString) { 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
} 

class wp_tandora_shortcode {
    public function __construct() {
        add_action('init', array($this, 'register_tandora_shortcodes'));
    }

    public function register_tandora_shortcodes() {
        add_shortcode('tandora', array($this, 'tandora_shortcode_output'));
    }

    public function tandora_shortcode_output($atts, $content = '', $tag) {
        if(!empty($atts) && is_array($atts) && array_key_exists("widget_url", $atts)) {
            $widget_url = $atts['widget_url'];
            if(startsWith($widget_url, "https://app.tandora.co") && strpos($widget_url, "widget")) {
                $tandora_iframe = '<iframe id="tandora_iframe"  
                name="tandora_widget"  
                src="' . $widget_url .'" 
                width="100%"  
                height="100vh"  
                scrolling="yes"
                frameborder="0"     
                allowtransparency="true"  
                style="display:block; width:100%; height:100vh;" ></iframe>';
                return $tandora_iframe;
            }
        }

        return '<p>Either widget_url is not present or it is not a valid tandora widget url. 
            Get your tandora widget url from here 
            <a target="_blank" href="https://app.tandora.co/staff/manage/widget">https://app.tandora.co/staff/manage/widget</a> . 
            Then replace the widget url. </p>';
    }
}

$wp_tandora_shortcode = new  wp_tandora_shortcode;

?>