<?php get_header();
?>

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
    $args = array(
                    "type"  => "post",
                );

    if (is_front_page()){
        echo "Masuk in if";
        $query = new WP_Query($args);
        echo "melawati query";
        if ($query->have_posts()):
            echo "good if";
            while ($query->have_posts()):
                echo "in while";
                echo $query->the_post(); ?>
                <li id=<?php the_id(); ?>>
                    <h2>The Standar post : <?php the_title(); ?></h2>
                    <small>Post pada : <?php the_time( "j F Y" ); ?> Waktu : <?php the_time("g:i a"); ?> in <?php the_category() ?></small>
                    <p><?php the_content(); ?></p>
                </li>
                <?php
                get_template("content-standar");
            endwhile;
        endif;
        echo "end if";
        wp_reset_postdata();
    } else {
        ?>
        <h1>Gagal sekali</h1>
        <?php
    } ?>
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
<!-- call sidebar widget -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
