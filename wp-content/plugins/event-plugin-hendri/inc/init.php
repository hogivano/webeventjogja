<?php
/**
 * @package EventPluginHendri
*/
namespace Inc;

final class Init{

    /**
     * Store all the clase inside array
     * @return array full list of class
     */
    public static function get_services(){
        $arrayClass = array(Pages\Admin::class,
                            Base\Enqueue::class,
                            Base\SettingsLinks::class);
        return $arrayClass;
    }

    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exists
     * @return
     */
    public static function register_services(){

        //cek apakah ada kelas di Page\Admin::class
        foreach (self::get_services() as $class) {
            //membuat object
            $service = self::instantiate($class);
            if (method_exists($service, "register")) {
                //memanggil method register
                $service->register();
            }
        }
    }

    /**
     * Inintialize the class
     * @param class $class from the services array
     * @return class instance new instance of the class
     */
    private static function instantiate ($class){
        //memanggil objek kelas
        $service = new $class();
        return $service;
    }
}

// use Inc\Base\Activate;
// use Inc\Base\Deactivate;
// use Inc\Pages\Admin;
//
// class EventPluginHendri {
//     //methods
//
//     public $plugin;
//     //public can access everywhere
//     //protected just can access in class self and this child class
//     //private just can access in class self
//     function __construct(){
//         //call function agar bisa dijalankan
//         $this->plugin = plugin_basename(__FILE__);
//         add_action("init", array($this, "custom_post_type"));
//     }
//
//
//     //static method to call this method just can call methot not use object class
//     function register_admin_scripts(){
//         add_action("admin_enqueue_scripts", array($this, "enqueue"));
//
//         add_action("admin_menu", array($this, "add_admin_pages"));
//
//         add_filter("plugin_action_links_" . $this->plugin ,
//                 array($this, "settings_link"));
//
//     }
//
//     public function settings_link($links){
//         // add custom settings link
//         $settings_link = "<a href='admin.php?page=event_plugin_hendri'>Settings</a>";
//         array_push($links, $settings_link);
//         return $links;
//     }
//
//     public function add_admin_pages(){
//         add_menu_page( "Event Plugin Hendri", "EPH",
//             "manage_options", "event_plugin_hendri", array($this, "admin_index")
//             , "dashicons-store", 110);
//     }
//
//     public function admin_index(){
//         //use templates
//         require_once plugin_dir_path( __FILE__) . "templates/admin.php";
//     }
//     //
//     // function activate(){
//     //     //generate a custom post type
//     //     $this->custom_post_type();
//     //     // echo "This plugin is activate";
//     //
//     //     //flush rewrite rules
//     //     flush_rewrite_rules();
//     // }
//     //
//     // function deactivate(){
//     //     //flush rewrite rules
//     //     flush_rewrite_rules();
//     // }
//
//     //add custom post type in menus admin
//     function custom_post_type(){
//         register_post_type("book", ["public" => true, "label" => "Books"]);
//     }
//
//     function enqueue(){
//         //enqueue all our script
//         wp_enqueue_style( "mypluginstyle", plugins_url("/assets/mystyle.css", __FILE__));
//         wp_enqueue_script("mypluginscript", plugins_url("/assets/myscript.js", __FILE__));
//     }
// }
//
// //melihat apakah ada kelas dalam file
// if (class_exists("EventPluginHendri")) {
//     $eventPluginHendri = new EventPluginHendri();
//     $eventPluginHendri->register_admin_scripts();
//     //static method
//     // $eventPluginHendri::register_admin_scripts();
// }
//
// //activation
// //__file__ => can access global file location
// // require_once plugin_dir_path( __FILE__) . "inc/Activate.php";
// register_activation_hook( __FILE__, array("Activate", "activate"));
// // add_action("init", "function_name");
//
// //deactivation
// // require_once plugin_dir_path( __FILE__) . "inc/event-plugin-hendri-deactivate.php";
// register_deactivation_hook( __FILE__, array("Deactivate", "deactivate"));

?>
