<li id=<?php $post->the_id(); ?>>
    <h2>The Aside post : <?php $post->the_title(); ?></h2>
    <small>Post pada : <?php the_time( "j F Y" ); ?> Waktu : <?php the_time("g:i a"); ?> in <?php the_category() ?></small>
    <p><?php $post->the_content(); ?></p>
</li>
