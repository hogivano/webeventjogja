<?php
/**
 * @package EventPluginHendri
*/

class EventPluginHendriDeactivate {
    public static function deactivate(){
        flush_rewrite_rules();
    }
}
