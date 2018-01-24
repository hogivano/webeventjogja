<?php
/**
 * @package em-digitals
 */

 /**
  *
  */
 class EventPostType
 {

     function __construct()
     {
         # code...

     }

     function eventPostType(){
         $args = array('public' => true, "label" => "Event Listing");
         register_post_type( "event", $args );
     }
     add_action( "init", "eventPostType");
 }

?>
