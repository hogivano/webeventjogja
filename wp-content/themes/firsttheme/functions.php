<?php
//add_action is call function to running

function firsttheme_script_enqueue(){
    wp_enqueue_style("frameworkstyle", get_template_directory_uri() . "/css/bootstrap.min.css", array(), "3.3.7", "all");
    wp_enqueue_style("customstyle", get_template_directory_uri() . "/css/style.css", array(), "1.0.0", "all");

    wp_enqueue_script("frameworkscript", get_template_directory_uri() . "js/bootstrap.min.js", array(), "3.3.7", true);
    wp_enqueue_script("customscript", get_template_directory_uri() . "js/main.js", array(), "1.0.0", true);
}
add_action("wp_enqueue_scripts", "firsttheme_script_enqueue");

//active menu customize in admin
function firsttheme_setup(){
    add_theme_support("menus");
    register_nav_menu("primary", "primary header navigation");
    // ragister_nav_menu("secondary", "footer navigation");
}
//can use init/after_custom_theme
add_action("after_setup_theme", "firsttheme_setup");

//editor theme support function
add_theme_support("custom-background");
add_theme_support("custom-header");
add_theme_support("post-thumbnails");

//post format function
add_theme_support("post-formats", array("aside", "image", "video"));

//sidebar format function
function firsttheme_widget_setup(){
    register_sidebar(
        array(
            "name"          => "sidebar",
            "id"            => "sidebar-1",
            "class"         => "sidebar-custom",
            "description"   => "Standart sidebar",
            "before_widget" => "<aside id='%1' class='widget %2'>",
            "after_widget"  => "</aside>",
            "before_tittlw" => "<h1 class='widget-title'>",
            "after_widget"  => "</h1>",
        )
    );
}

add_action("widgets_init", "firsttheme_widget_setup");
?>
