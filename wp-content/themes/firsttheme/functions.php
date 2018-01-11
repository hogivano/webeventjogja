<?php

function firsttheme_script_enqueue(){
    wp_enqueue_style("frameworkstyle", get_template_directory_uri() . "/css/bootstrap.min.css", array(), "3.3.7", "all");
    wp_enqueue_style("customstyle", get_template_directory_uri() . "/css/style.css", array(), "1.0.0", "all");

    wp_enqueue_script("frameworkscript", get_template_directory_uri() . "js/bootstrap.min.js", array(), "3.3.7", true);
    wp_enqueue_script("customscript", get_template_directory_uri() . "js/main.js", array(), "1.0.0", true);
}
add_action("wp_enqueue_scripts", "firsttheme_script_enqueue");

function firsttheme_setup(){
    add_theme_support("menus");
    register_nav_menu("primary", "primary header navigation");
    // ragister_nav_menu("secondary", "footer navigation");
}
add_action("after_setup_theme", "firsttheme_setup")
?>
