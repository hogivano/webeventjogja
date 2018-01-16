<div class="col-xs-4">
    <div id=<?php the_id(); ?> class="card card-inverse card-info align-center">
        <img class="card-img-top" src="">
        <div class="card-block">
            <?php

            ?>
            <figure class="profile profile-inline">
                <img src=<?php echo $url; ?> class="profile-avatar" alt="">

            </figure>
            <h4 class="card-title"><?php the_title(); ?></h4>
            <div class="card-text">
                <?php
                //just get text content
                $content = get_the_content();
                $content = preg_replace('/(<)([img])(\w+)([^>]*>)/', "", $content);
                $content = apply_filters('the_content', $content);
                $content = str_replace(']]>', ']]&gt;', $content);
                echo $content;
                ?>
            </div>
        </div>
        <div class="card-footer">
            <small>Post: <?php the_time(); ?></small>
            <small> <?php the_category(" "); ?></small>
        </div>
    </div>
</div>
