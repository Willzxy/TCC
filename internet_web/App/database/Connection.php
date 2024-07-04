<?php

namespace App;

abstract class Connection {
    private $host = 'localhost:3306';
    private $bd_name = 'tcc';
    private $usuario = 'root';
    private $senha = '17483&#JFHSywrhkSI85930KS#*%8329';
    
    function getDB(){
        try {
            $Mysql = new \mysqli($this->host, $this->usuario, $this->senha, $this->bd_name,);

            return $Mysql;
        } catch (\Throwable $th) {
            echo $th;
            echo 'tem parada errada ai';
        }

    }
}