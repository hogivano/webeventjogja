<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hendriyan Ogivano</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body>
    <div class="nav-container nav-theme">
        <nav class="navbar">
                <?php
                    wp_nav_menu(array(
                        "theme_location" => "primary",
                        "container"      => false,
                        "menu_class"     => "nav navbar-nav",
                        ));
                ?>
            </div>
        </nav>
    </div>
    <!-- <header>
        Ini adalah header percobaan theme
    </header> -->
