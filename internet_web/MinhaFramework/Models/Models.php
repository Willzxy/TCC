<?php

namespace MF;

require_once '../App/database/Connection.php';

use App\Connection;

class Models extends Connection {
    protected $db;

    function __construct(){
        $this->db = Connection::getDB();
    }
}