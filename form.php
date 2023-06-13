<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Merci de votre inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section>
        <h1>Merci pour votre inscription !</h1>
        
        <p>Votre demande a bien été envoyée. Nous vous contacterons dans les plus brefs délais pour confirmer votre inscription.</p>
        
        <p>En attendant, vous pouvez consulter notre <a href="https://www.cs-les-passerelles.fr/">site web</a> pour en savoir plus sur nos produits et services.</p>
    </section>
    <?php
        if(isset($_POST["envoi"])){
            // Connexion
            require_once 'login.php';
                        
            // Requête pour récupérer l'ID le plus haut des dossier existants
            $req = "SELECT MAX(id_dossier) as last_dossier FROM dossier";
            $result = $bdd->prepare($req);
                        
            $result->execute();
            $data = $result->fetch();
                        
            $last_dossier = $data['last_dossier'];
                        
            // Attribution d'un nouvel ID non utilisé au dossier actuel
            $nouvel_id_dossier = $last_dossier + 1;
                        
            // Insertion des informations de l'assurance
            $req = "SELECT numero_police FROM assurance WHERE EXISTS (SELECT * FROM assurance WHERE numero_police=:numero_police)";
            $result = $bdd->prepare($req);
            $result->bindParam(':numero_police',$numero_police);
                        
            $numero_police = $_POST["numero_police"];
            $result->execute();
            $res = $result->fetch();
                        
            if ($res===false){
                $req = "INSERT INTO assurance (numero_police, nom_assurance) VALUES (:numero_police, :nom_assurance)";
                $result = $bdd->prepare($req);
                $result->bindParam(':numero_police',$numero_police);
                $result->bindParam(':nom_assurance',$nom_assurance);
                $nom_assurance = $_POST["nom_assurance"];
                $result->execute();
            }
        
        
            // Insertion des informations du dossier avec le nouvel ID
        
            $req = "INSERT INTO Dossier (id_dossier, statut, adresse, code_postal, commune, date_dossier, numero_police) VALUES (:id_dossier, :statut, :adresse, :code_postal, :commune, :date_dossier, :numero_police)";
            $result = $bdd->prepare($req);
            $result->bindParam(':id_dossier',$nouvel_id_dossier);
            $result->bindParam(':statut',$statut);
            $result->bindParam(':adresse',$adresse);
            $result->bindParam(':code_postal',$code_postal);
            $result->bindParam(':commune',$commune);
            $result->bindParam(':date_dossier',$date_dossier);
            $result->bindParam(':numero_police',$numero_police);
        
            $statut = $_POST["statut"];
            $adresse = $_POST["user_adresse"];
            $code_postal = $_POST["code_postal"];
            $commune = $_POST["user_commune"];
            $date_dossier = date('Y/m/d');
            $result->execute();
        
            //inserer un adherent
        
            // Requête pour récupérer l'ID le plus haut des adherents existants
            $req = "SELECT MAX(id_adherent) as last_adherent FROM adherent";
            $result = $bdd->prepare($req);
        
            $result->execute();
            $data = $result->fetch();
        
            $last_adherent = $data['last_adherent'];
        
            // Attribution d'un nouvel ID non utilisé à l'adhérent actuel
            $nouvel_id_adherent = $last_adherent + 1;
        
            // Insertion des données pour chaque adhérent du dossier    
            $req="INSERT INTO adherent (id_adherent,nom_adherent,prenom_adherent,date_naissance,filiation,id_dossier) VALUES (:id_adherent,:nom,:prenom,:date_naissance,:filiation,:id_dossier)";
            $result = $bdd->prepare($req);
            
            $nom_adherent = $_POST["nom"];
            $prenom_adherent = $_POST["prenom"];
            $date_naissance = $_POST["naissance"];
            $filiation = $_POST["filiation"];
            
            for ($i = 0; $i < count($nom_adherent); $i++) {
                $result->bindParam(':id_adherent', $nouvel_id_adherent);
                $result->bindParam(':nom', $nom_adherent[$i]);
                $result->bindParam(':prenom', $prenom_adherent[$i]);
                $result->bindParam(':date_naissance', $date_naissance[$i]);
                $result->bindParam(':filiation', $filiation[$i]);
                $result->bindParam(':id_dossier',$nouvel_id_dossier);
                $result->execute();
                $nouvel_id_adherent = $nouvel_id_adherent + 1;
            }
            
            //inserer les contacts
            
            // Requête pour récupérer l'ID le plus haut des contacts existants
            $req = "SELECT MAX(id_contact) as last_contact FROM contact";
            $result = $bdd->prepare($req);
            
            $result->execute();
            $data = $result->fetch();
            
            $last_contact = $data['last_contact'];
            
            // Attribution d'un nouvel ID non utilisé au contact actuel
            $nouvel_id_contact = $last_contact + 1;
            
            $req="INSERT INTO contact (id_contact,tel,e_mail,refus_info,id_dossier) VALUES (:id_contact,:tel,:e_mail,:refus_info,:id_dossier)";
            $result = $bdd->prepare($req);
            
            $result->bindParam(':id_contact',$nouvel_id_contact);
            $result->bindParam(':tel',$tel);
            $result->bindParam(':e_mail',$e_mail);
            $result->bindParam(':refus_info',$refus_info);
            $result->bindParam(':id_dossier',$nouvel_id_dossier);
            
            $nouvel_id_contact = $nouvel_id_contact +1;
            $tel = $_POST["tel_1"];
            $e_mail = $_POST["e-mail_1"];
            $refus_info = isset($_POST["refus_info"]);
            $result->execute();
            
            if ($_POST["tel_2"]!=null or $_POST["e-mail_2"]!=null){
                $nouvel_id_contact = $nouvel_id_contact +1;
                $tel = $_POST["tel_2"];
                $e_mail = $_POST["e-mail_2"];
                $result->execute();
            }
            
            if ($_POST["tel_3"]!=null or $_POST["e-mail_3"]!=null){
                $nouvel_id_contact = $nouvel_id_contact +1;
                $tel = $_POST["tel_3"];
                $e_mail = $_POST["e-mail_3"];
                $result->execute();
            }
            
            $bdd=null;
        }
    ?>
</body>
</html>