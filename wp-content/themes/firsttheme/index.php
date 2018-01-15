<?php get_header(); ?>

<div class="black-img">
    <img src=<?php echo get_template_directory_uri() . "/img/tugujogja.jpg"; ?> alt="" class="img-search">
    <div class="row">
        <div class="col-8">
            <input type="text" placeholder="apa yang anda cari?" name="" value="" class="form-control">
        </div>
        <div class="col-4">
            <button type="button" name="button" class="button default">Cari</button>
        </div>
    </div>
</div>
<div>
    <?php
        if (have_posts()): ?>
        <ul class="list-group" >
        <?php while (have_posts()):
            the_post();

            //template content per post format
            get_template_part("content", get_post_format());
        ?>
        <?php   endwhile; ?>
        </ul>
    <?php endif; ?>
    Ini adalah tampilan index theme
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
