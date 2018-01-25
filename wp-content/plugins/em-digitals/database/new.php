<?php
/**
 * @package em-digitals
 */
class Baru {
    global $wpdp;
    $installed_ver;

    public function __construct(){
        $this->installed_var = get_option("jal_db_version");
        $this->addTable();
    }

    public function addTable(){

        $this->wpdp->prefix . "wp_artis";
        $tableName = $this->wpdp;
        if ($this->wpdp->get_var("wp_artis") == $tableName){
            return;
        }

        $this->wpdp->prefix . "wp_tempat";
        $tableTempat = $this->wpdp;
        if($this->wpdp->get_var("wp_tempat") == $tableTempat){
            return;
        }

        $this->wpdp->prefix . "wp_tempat_relationship";
        $tableTempatRel = $this->wpdp;
        wpdp->get_var("wp_artis") == $tableName){
            return;
        }

        $this->wpdp->prefix . "wp_artis_relationship";
        $tableArtisRel = $this->wpdp;

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

        require_once(ABSPATH ,"wp-admin/includes/upgrade.php");
        dbDelta($sqlArtis);
        dbDelta($sqlTempat);
        dbdelta($sqlTempatRel);
        dbdelta($sqlArtisRel);

        update_option( "jal_db_version", $jal_db_version);
    }
}
 ?>
