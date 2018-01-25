<?php
/**
 * @package em-digitals
 */

/*
Plugin Name: em-digitals
Plugin URI: http://hogivano.ga
Description: Event Manege Plugin Digitals
Version: 1.0.0
Author: Hendriyan Ogivano
Author URI: http://hogivano.ga
license: GPLv2 or later
Text Domain: Event Manager Plugin Digitals
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

defined("ABSPATH") or die("Hey, you cannot acces this file, you still human!");
/**
 *
 */
$coba = new NewDatabase();
$coba->createTableArtis();
$coba->createTableTempat();
// $coba->addRegisterTempat();

class NewDatabase
{

    // public function __construct(){
    //     $this->installed_var = get_option("jal_db_version");
    //     $this->addTable();
    // }

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

    public function addRegisterTempat(){
        $args = array ( "public"    => true,
                        "label"     => "Tempat",
                        "supports"   => array(
                            "custom-fields",
                            "title"
                        ));
        register_post_type( "Tempat", $args);
    }

    public function addTable(){
        global $wpdb;
        $installed_ver;

        $this->wpdb->prefix . "wp_artis";
        $tableName = $this->wpdb;
        if ($this->wpdb->get_var("wp_artis") == $tableName){
            return;
        }

        $this->wpdb->prefix . "wp_tempat";
        $tableTempat = $this->wpdb;
        if($this->wpdb->get_var("wp_tempat") == $tableTempat){
            return;
        }

        $this->wpdb->prefix . "wp_tempat_relationship";
        $tableTempatRel = $this->wpdb;
        if ($this->wpdp->get_var("wp_artis") == $tableName){
            return;
        }

        $this->wpdb->prefix . "wp_artis_relationship";
        $tableArtisRel = $this->wpdb;

        $sqlArtis = "CREATE TABLE $tableName (
            id int(9) NOT NULL AUTO_INCREMENT,
		    name tinytext NOT NULL,
            deskripsi tinytext NOT NULL,
		    PRIMARY KEY  (id)
        );";

        $sqlTempat = "CREATE TABLE $tableTempat (
            id int(9) NOT NULL AUTO_INCREMENT,
            name tinytext NOT NULL,
            alamat tinytext NOT NULL,
            PRIMARY KEY (id)
        );";

        $sqlTempatRel = "CREATE TABLE $tableTempatRel(
            id int (9) NOT NULL AUTO_INCREMENT,
            tempat_id int (9) NOT NULL,
            post_id int (9) NOT NULL,
            PRIMARY KEY (id)
        );";

        $sqlArtisRel = "CREATE TABLE $tableArtisRel (
            id int (9) NOT NULL AUTO_INCREMENT,
            artis_id int (9) NOT NULL,
            post_id int (9) NOT NULL,
            PRIMARY KEY (id)
        );";

        require_once(ABSPATH . "wp-admin/includes/upgrade.php");
        dbDelta($sqlArtis);
        dbDelta($sqlTempat);
        dbdelta($sqlTempatRel);
        dbdelta($sqlArtisRel);

        update_option( "jal_db_version", $jal_db_version);
    }
}


 ?>
