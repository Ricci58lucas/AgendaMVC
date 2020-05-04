<?php

    class Conexion{

        public static function conectar(){
            $server='localhost';
            $user='root';
            $db='desarrollo_mvc';

            //conexion con la db, especificando tambien el servidor, el usuario y  la contraseña
            $con = mysqli_connect($server,$user,"",$db) or die ("ERROR AL CONECTAR ".mysql_error);
            return $con;
        }
    }

?>