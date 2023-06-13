<?php
if(isset($_POST["code_postal"])){
            require_once 'login_com.php';
            
            $code_postal = $_POST["code_postal"];
            if (strlen($code_postal)<5){
                $code_postal = $code_postal."%";
            }
            
            $req = "SELECT ville_nom_reel FROM villes_france_free WHERE ville_code_postal LIKE :code_postal";
            $result = $bdd->prepare($req);
            $result->bindParam(':code_postal',$code_postal);
                        
            $result->execute();
            $communes = array();
            
            while ($row = $result->fetch()) {
                $communes[] = $row["ville_nom_reel"];
            }
            
            $communes_str = implode(',', $communes);
            echo $communes_str;
            exit;
        }
?>