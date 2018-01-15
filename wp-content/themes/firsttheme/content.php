<li id=<?php the_id(); ?>>
    <h2>Standart post :<?php the_title(); ?></h2>
    <small>Post pada : <?php the_time( "j F Y" ); ?> Waktu : <?php the_time("g:i a"); ?> in <?php the_category() ?></small>
    <p><?php the_content(); ?></p>
</li>
