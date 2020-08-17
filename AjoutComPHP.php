<?php
include "connexion.php";

require "class.phpmailer.php";
require "class.smtp.php";

$mail = new PHPmailer();
//ici ce qui t'interesse
$mail->IsSMTP();
$mail->Host = "mail.travelwithnico.com";
$mail->SMTPAuth = true;
$mail->CharSet = 'UTF-8';
$mail->Username = 'nico.degouve@travelwithnico.com';
$mail->Password = $passe;
$mail->Port = 25;
$mail->FromName = 'Travel with Nico';
$mail->From='nico.degouve@travelwithnico.com';
$mail->AddAddress('neo.degouve@laposte.net');
//$mail->AddReplyTo('votre@adresse');	
//$mail->Subject='Exemple trouvé sur DVP';
//$mail->Body='Voici un exemple d\'e-mail au format Texte';

$bdd = mysqli_connect($hote, $user, $passe, $nomBase);
            
/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}
else
{
   
    $Pseudo = $_GET['Pseudo'];
    $Comm = $_GET['Comm'];
    $NomPhoto = $_GET['NomPhoto'];

    //Première étape: on vérifie que l'utilisateur a bien evoyé un pseudo ET un commentaire. Si non, on va evoyer le message d'erreur en JSON
    /*A noter que le renvoi du pseudo et du commentaire ne servent plus a rien suite à une mise à jour de ma fonction d'envoi. Je les renvoyais au début pour pouvoir les ré-afficher dans le formulaire 
    mais j'ai trouvé une autre méthode pour les conserver directement dans le javascript sans passer par ces transferts de données inutiles entre 
     fichiers. Avec cette méthode j'avais en plus un problème de pris en charge des retour à la ligne en remettant le texte dans le textarea directement depuis le JSON.*/

    if(!$Comm)
    {
        $MsgErreur = 'Il faut saisir également un commentaire';
    }
    if(!$Pseudo)
    {
        $MsgErreur = 'Il faut saisir également un pseudo';
    }
    if(!$Pseudo && !$Comm)
    {
        $MsgErreur = 'Il faut saisir un pseudo et un commentaire';
    }

    if(!$Comm || !$Pseudo)
    {

        echo '{ 
        "MsgErreur": "' . $MsgErreur . '", ';

        echo '"Pseudo": "' . $Pseudo . '", ';

        $Comm = str_replace("\n"," ",$Comm); //je retransforme mes donnes de la base de donne pour reinjecter les br des retours a la ligne pour que le json saffiche bien
        echo '"Comm": "' . $Comm . '"';

        echo '}';
    }
    //si le pseudo ET le commentaire ont bien été envoyés on va les insérer en base de donnée.
    else
    {
        //$Pseudo = 'ddd';
        //$Comm = 'dskjhfgezlkfhgslkjf';
        //$NomPhoto = 'photos/1457784641.jpeg';

        $affichePhotos = $bdd->query("SELECT * FROM photos WHERE NomPhoto='" . $NomPhoto . "'");
        
        $donnees = mysqli_fetch_array($affichePhotos);

        $donnees['numChamps'];
        $numeromess = $donnees['nummessage']+1;
        $nvllevaleurpseudo = 'pseudo' . $numeromess;
        $nvllevaleurcommentaire = 'Commentaire' . $numeromess;

        $Comm = str_replace("\n","<br />",$Comm);          //Je transforme les br codés en \n par la fonction javascript encodeURIComponent pour les encoder plus bas sous le bon format pour la base de donnée et le php

        $Comm = htmlspecialchars(mysqli_real_escape_string($bdd, $Comm));      // On rajoute cette ligne pour gérer les apostrophe dans les infos envoyées
        $Pseudo = htmlspecialchars(mysqli_real_escape_string($bdd, $Pseudo));

        $mail->Body = $Pseudo . ' à dit:' . $Comm;                        //Création du corps du mail qui sera envoyé
        $mail->Subject = 'Nouveau commentaire sur l\'image: ' . $NomPhoto . '. Catégorie: ' . $donnees['lieu'] . ' dont le titre est: ' . $donnees['Titre'];  //Création du sujet du mail qui sera envoyé        


        if ($numeromess-1 < $donnees['numChamps'])
        {
            
            
            $sql = "UPDATE photos SET ".$nvllevaleurpseudo." = '$Pseudo a dit:', ".$nvllevaleurcommentaire." = '$Comm', nummessage='$numeromess' WHERE NomPhoto='$NomPhoto'";
            $bdd->query($sql);
            
           
            //mysqli_query("UPDATE photos SET ".$nvllevaleurpseudo." = '$Pseudo a dit:', ".$nvllevaleurcommentaire." = '$Comm', nummessage='$numeromess' WHERE NomPhoto='$NomPhoto'");    //Requête SQL qui nous met à jour les valeurs pseudo* et com* (champs déjà créés auparavant)
            $mail->Send();                                              //On s'envoie le petit email pour etre tenu informé de l'ajout d'un nouveau commentaire
            $mail->SmtpClose();                                         //Fermeture de la connection SMTP
            unset($mail);
        }
        elseif ($numeromess >= $donnees['numChamps'])                        //Condition pour ajouter un commentaire en ajoutant un nouveau champs: Si en effet, le numéro de commentaire est plus important que le nombre de champs, il va falloir créer un nouveau champs
        {
            $numeromessMoins1 = $numeromess - 1;
            $numeroChamps = $donnees['numChamps'] + 1;
            $valeurpseudoplacement =  'Commentaire' . $numeromessMoins1;
            $valeurcomplacement = 'pseudo' . $numeromess;

            $sql = "ALTER TABLE photos ADD $nvllevaleurpseudo VARCHAR(20) NOT NULL AFTER ".$valeurpseudoplacement." ,ADD $nvllevaleurcommentaire TEXT NOT NULL AFTER ".$valeurcomplacement."";      //Requête d'ajout de 2 champs pseudo et commentaires dans la table en indiquant où on veut les positionner
            $bdd->query($sql);
            
            $sql2 = "UPDATE photos SET ".$nvllevaleurpseudo." = '$Pseudo a dit:', ".$nvllevaleurcommentaire." = '$Comm', nummessage='$numeromess' WHERE NomPhoto='$NomPhoto'";
            $bdd->query($sql2);
            
            $sql3 = "UPDATE photos SET numChamps='$numeroChamps'"; 
            $bdd->query($sql3);
            
            
            //mysql_query("ALTER TABLE photos ADD $nvllevaleurpseudo VARCHAR(20) NOT NULL AFTER ".$valeurpseudoplacement." ,ADD $nvllevaleurcommentaire TEXT NOT NULL AFTER ".$valeurcomplacement."");      //Requête d'ajout de 2 champs pseudo et commentaires dans la table en indiquant où on veut les positionner
            //mysql_query("UPDATE photos SET ".$nvllevaleurpseudo." = '$Pseudo a dit:', ".$nvllevaleurcommentaire." = '$Comm', nummessage='$numeromess' WHERE NomPhoto='$NomPhoto'");                                     //Requête SQL qui nous met à jour les valeurs pseudo* et com* (maintenant que les champs ont été créés)
            //mysql_query("UPDATE photos SET numChamps='$numeroChamps'"); 
            $mail->Send();                                              //On s'envoie le petit email pour etre tenu informé de l'ajout d'un nouveau commentaire
            $mail->SmtpClose();                                         //Fermeture de la connection SMTP
            unset($mail);
        }

        else
        {
            echo 'pb d\'ajout pour une raison inconue. L\'administrateur a été averti';
            $mail->Body = 'PROBLEME D\'ENTREE DANS LA BASE DE DONNEES!!' . $Comm . 'Catégorie: ' . $donnees['lieu'] . ' dont le titre est: ' . $donnees['Titre'];                   //Création du corps du mail qui sera envoyé
            $mail->Send();
            $mail->SmtpClose();                                         //Fermeture de la connection SMTP
            unset($mail);
        }
    }
   
}