<?php
/**
 * Trigger this file is plugin uninstall
 *
 * @package EventPluginHendri
*/

//cek apakah support untuk login
if (!defined("WP_UNINSTALL_PLUGIN")) {
    # code...
    die;
}

//clear Database stored data
// $books = get_post(array("post_type" => "book",
//                         "numberpots" => -1));
// //numberpots is -1 because to select all data
// foreach ($books as $book) {
//     # code...
//     wp_delete_post($book->ID, true);
// }

//Access the database via sql
global $wpdp;
//delete book type in posts table
$wpdp->query("DELETE FROM wp_posts WHERE post_type = 'book'");

//delete post_id book in postmeta dengan cek idnya book tidak ada di wp_posts
$wpdp->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");

//delete id book in wp_term_relationships cek with id book n ot in wp_posts
$wpdp->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
?>
