<?php 

class CustomPostController {
    public function __construct($init) {
        $this->settings = $init;
        self::add_custom_post_type($this->settings);
        // add_action('init', array($this, 'register_custom_post_type'));
    }
    
    public static function add_custom_post_type( $settings ) {
        var_dump($settings);
        register_post_type(
            $settings['slug'],
            array(
                'labels' => array(
                    'name' => __($settings['plural']),
                    'singular_name' => __($settings['singular'])
                ),
                'public' => true,
                'has_archive' => true,
            )
        );
    }
}

