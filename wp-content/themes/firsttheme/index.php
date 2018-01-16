<?php get_header();

global $wpdp;

$array = $wpdb->get_results("SELECT * FROM wp_posts", OBJECT);
// $result = $conn->query($sql);
echo $array;
if ($array) {
    # code...
    foreach ($array as $ok) {
        # code...
        if ($ok->post_status == "publish"){
            echo $ok->post_title . "<br>";
        }
    }
} else {
    echo "noting";
    echo $wpdp;
}
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
                echo $query->the_post();
                get_template_part("content", get_post_format());
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
            the_post(); ?>

            <div class="row">
            <?php
                //template content per post format
                get_template_part("content", get_post_format());
            ?>
            </div>
        <?php   endwhile; ?>
        </ul>
    <?php endif; ?>
</div>
<!-- call sidebar widget -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
