<?php
/*
    Template Name: Page No Title
*/
get_header(); ?>
<div>
    <?php
        if (have_posts()): ?>
        <ul class="list-group" >
        <?php while (have_posts()):
                the_post(); ?>
                    <li id=<?php the_id(); ?>>
                        <h2><?php the_title(); ?></h2>
                        <small>Post pada : <?php the_time( "j F Y" ); ?> Waktu : <?php the_time("g:i a"); ?> in <?php the_category() ?></small>
                        <p><?php the_content(); ?></p>
                    </li>
        <?php   endwhile; ?>
        </ul>
    <?php endif; ?>
    Ini adalah tampilan index theme
</div>
<?php get_footer(); ?>
