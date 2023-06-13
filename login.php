<?php
$dsn="mysql:host=127.0.0.1;port=3306;dbname=bd_adherent";
$user="root";
$pass="";

try{
    $bdd=new PDO ($dsn,$user,$pass);
    }

    catch (PDOException $e){
        echo "Le code erreur est : ".$e->getCode();
        echo "<br>Le message : ".$e->getMessage();
        echo "<br>Le fichier : ".$e->getFile();
    }
?>