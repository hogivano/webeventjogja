<?php
/**
 * @package EventPluginHendri
*/

class EventPluginHendriActivate{
    public static function activate(){
        flush_rewrite_rules();
    }
}
