<?php get_header(); ?>
<div>
    <?php
        if (have_posts()): ?>
        <ul class="list-group" >
        <?php while (have_posts()):
                the_post(); ?>
                    <li id=<?php the_id(); ?> class="list-group-item">
                        <h2><?php the_title(); ?></h2>
                        <small>Post pada : <?php the_time( "j F Y" ); ?> Waktu : <?php the_time("g:i a"); ?> in <?php the_category() ?></small>
                        <p><?php the_content(); ?></p>
                    </li>
        <?php   endwhile; ?>
        </ul>
    <?php endif; ?>
    Ini adalah tampilan about pages
</div>
<?php get_footer(); ?>
