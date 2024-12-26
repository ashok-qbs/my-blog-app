<?php

namespace App\Libraries;

use EdSDK\FlmngrServer\FlmngrServer;

class FileManager
{

    protected $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function build()
    {
        return FlmngrServer::flmngrRequest(array(
            "dirFiles" => FCPATH . "/uploads/" . $this->name,
        ));
    }
}

?>