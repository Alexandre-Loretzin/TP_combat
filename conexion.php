<?php
try{

    $bdd = new PDO('mysql:host='.(getenv('MYSQL_HOST') ?: 'localhost').';dbname=combat2;charset=utf8', 'root', '');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    
    catch(Exception $e){
    
        die('Erreur : '.$e->getMessage());
    
    }
    