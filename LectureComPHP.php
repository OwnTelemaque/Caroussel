<?php
include "connexion.php";



$bdd = mysqli_connect($hote, $user, $passe, $nomBase);
            
/* Vérification de la connexion */
if (mysqli_connect_errno()) {
    printf("Échec de la connexion : %s\n", mysqli_connect_error());
    exit();
}
else
{
   

    $NomPhoto = $_GET['NomPhotoAmodif'];
    
    //$NomPhoto = "1477018795.jpeg";
    
    $affichePhotos = $bdd->query("SELECT * FROM photos WHERE NomPhoto='" . $NomPhoto . "'");




}


//$donnees = mysql_fetch_array($affichePhotos);


$donnees = mysqli_fetch_array($affichePhotos);   



    

    echo '{ 
        "titre": "' . $donnees['Titre'] . '", ';
    
    $donneesMonCommentaires = str_replace("&lt;br /&gt;","<br />",$donnees['Commentaire']); //je retransforme mes donnes de la base de donne pour reinjecter les br des retours a la ligne pour que le json saffiche bien
    echo '"monCom": "' . $donneesMonCommentaires . '", ';
         
    for ($i=0; $i<$donnees['nummessage']; $i++)
        {
            $index = $i+1;
            echo '"pseudo' . $index . '": "' . $donnees['pseudo'.$index] . '", ';  
        }
        
    for ($i=0; $i<$donnees['nummessage']; $i++)
        {
            $index = $i+1;
            $donneesCommentaires = str_replace("&lt;br /&gt;","<br />",$donnees['Commentaire'.$index]); //je retransforme mes donnes de la base de donne pour reinjecter les br des retours a la ligne pour que le json saffiche bien
            $donneesCommentaires = " " . $donneesCommentaires;
            echo '"commentaire' . $index . '": "' . $donneesCommentaires . '", ';
        }    
        
    echo '"NbCommentaire": "' . $donnees['nummessage'] . '"';
        
    echo '}';
    

    
?>