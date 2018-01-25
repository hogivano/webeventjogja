<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Base;
use Inc\Sql\AddTable;

class Activate{
    public static function activate(){
        flush_rewrite_rules();
        new AddTable();
    }
}

?>
