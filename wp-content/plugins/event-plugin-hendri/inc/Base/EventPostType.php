<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Base;

class EventPostType{
    public function register(){
        add_action( "init", array($this, "eventPost"));
    }

    public function eventPost(){
        $args = array ( "public"    => true,
                        "label"     => "Event",
                        "supports"   => array(
                            "custom-fields",
                            "title",
                            "editor",
                            "thumbnail"
                        ));
        register_post_type( "Event", $args);
    }

    public function eph_meta_box_custom(){
        add_meta_box(
            "EPH Meta",
            "", $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null )
    }
}
 ?>
