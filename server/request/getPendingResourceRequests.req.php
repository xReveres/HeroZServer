<?php
namespace Request;

use Srv\Core;

class getPendingResourceRequests{
    public function __request(){
        Core::req()->data = [];
    }
}