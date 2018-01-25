<?php
/**
 * @package EventPluginHendri
 */
 namespace Inc\Sql;

 class AddTable {
     public function __construct(){
         $this->createTableArtis();
         $this->createTableTempat();
     }

     public function createTableArtis(){
         global $wpdb;
         $tableName = $wpdb->prefix . "artis";
             $sqlArtis = "CREATE TABLE IF NOT EXISTS $tableName (
                 id int(9) NOT NULL AUTO_INCREMENT,
     		    name text NOT NULL,
                 deskripsi text NOT NULL,
     		    PRIMARY KEY  (id)
             );";
             require_once(ABSPATH . "wp-admin/includes/upgrade.php");
             dbDelta($sqlArtis);
     }

     public function createTableTempat(){
         global $wpdb;
         $tableName = $wpdb->prefix . "tempat";
         $sqlTempat = "CREATE TABLE IF NOT EXISTS $tableName(
             id int (9) NOT NULL AUTO_INCREMENT,
             name text NOT NULL,
             alamat text,
             PRIMARY KEY (id)
         );";
         require_once(ABSPATH . "wp-admin/Includes/upgrade.php");
         dbDelta($sqlTempat);
     }
 }

?>
