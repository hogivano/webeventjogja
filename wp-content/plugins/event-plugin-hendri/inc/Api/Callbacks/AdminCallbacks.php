<?php
/**
 * @package EventPluginHendri
*/
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;

class AdminCallbacks extends BaseController{
    public function adminIndex(){
        require_once $this->plugin_path. "templates/admin.php";
    }

    public function artisIndex(){
        require_once $this->plugin_path. "templates/artis.php";
    }
}

?>
