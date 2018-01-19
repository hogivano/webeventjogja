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

// if (!defined("ABSPATH")) {
//     # code...
//     die;
// }


defined("ABSPATH") or die("Hey, you cannot acces this file, you still human!");

//cek apaka ada file atau support dengan plugin
// if (! function_exists("add_action")) {
//     # code...
//     echo "Hey, you cannot acces this file, you still human!";
//     exit;
// }

if (file_exists(dirname(__FILE__) . "/vendor/autoload.php") ) {
    # code...
    require_once dirname(__FILE__) . "/vendor/autoload.php";
}

use Inc\Base\Deactivate;

function activate_event_plugin_hendri(){
    Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, "activate_event_plugin_hendri");

function deactivate_event_plugin_hendri(){
    Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, "deactivate_event_plugin_hendri");

if (class_exists("Inc\\Init")) {
    # code...
    Inc\Init::register_services();
    // var_dump("good");
}
?>
