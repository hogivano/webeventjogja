<?php
/**
 * @package EventPluginHendri
 */

/*
Plugin Name: Event Plugin Hendri
Plugin URI: http://hogivano.ga
Description: First plugin for event plugin
Version: 1.0.0
Author: Hendriyan Ogivano
Author URI: http://hogivano.ga
license: GPLv2 or later
Text Domain: event-plugin-hendri
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

if (!defined("ABSPATH")) {
    # code...
    die;
}

defined("ABSPATH") or die("Hey, you cannot acces this file, you still human!");

//cek apaka ada file atau support dengan plugin
if (! function_exists("add_action")) {
    # code...
    echo "Hey, you cannot acces this file, you still human!";
    exit;
}

class EventPluginHendri {
    //methods

    //public can access everywhere
    //protected just can access in class self and this child class
    //private just can access in class self
    function __construct(){
        //call function agar bisa dijalankan
        add_action("init", array($this, "custom_post_type"));
    }

    //static method to call this method just can call methot not use object class
    static function register_admin_scripts(){
        add_action("admin_enqueue_scripts", array("EventPluginHendri", "enqueue"));
    }

    function activate(){
        //generate a custom post type
        $this->custom_post_type();
        // echo "This plugin is activate";

        //flush rewrite rules
        flush_rewrite_rules();
    }

    function deactivate(){
        //flush rewrite rules
        flush_rewrite_rules();
    }

    //add custom post type in menus admin
    function custom_post_type(){
        register_post_type("book", ["public" => true, "label" => "Books"]);
    }

    static function enqueue(){
        //enqueue all our script
        wp_enqueue_style( "mypluginstyle", plugins_url("/assets/mystyle.css", __FILE__));
        wp_enqueue_script("mypluginscript", plugins_url("/assets/myscript.js", __FILE__));
    }
}

//melihat apakah ada kelas dalam file
if (class_exists("EventPluginHendri")) {
    $eventPluginHendri = new EventPluginHendri();

    //static method
    $eventPluginHendri::register_admin_scripts();
}

//activation
//__file__ => can access global file location
register_activation_hook( __FILE__, array($eventPluginHendri, "activate"));
// add_action("init", "function_name");

//deactivation
register_deactivation_hook( __FILE__, array($eventPluginHendri, "deactivate"));

?>
