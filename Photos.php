<?php
include "connexion.php";
?>


<!DOCTYPE html>

<html id="MonHTML" xmlns="http://www.w3.org/1999/xhtml">


     <head>
        <title>ND Caroussel</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="screen" type="text/css" href="css.php" />
        <link rel="icon" type="image/png" href="images/favicone.png" />
    </head>
    
    

    <body id="BackgroundColor">
        
<?php



?>
<table id="TabPrincipal" cellspacing="0" cellpadding="0">
    
    
 
    
    
    <tr class="PagePrincipale">
        <td colspan="2" >



<table id="TabCentral">
    
    <tr>
        <td class="EspaceSousTitre">
           
        </td>
    </tr>
    <tr>
        <td>
            <?php
            
            
            $bdd = mysqli_connect($hote, $user, $passe, $nomBase);
            
            /* Vérification de la connexion */
            if (mysqli_connect_errno()) {
                printf("Échec de la connexion : %s\n", mysqli_connect_error());
                exit();
            }
            
            
            
            
            else
            {
               echo 'je suis connecte';

               
                $affichePhotosMelbourne = $bdd->query("SELECT * FROM photos WHERE lieu='melbourne' ORDER BY ID");
                $affichePhotosAnimaux = $bdd->query("SELECT * FROM photos WHERE lieu='animaux' ORDER BY ID");
                
                //$affichePhotosMelbourne = mysql_query("SELECT * FROM photos WHERE lieu='melbourne' ORDER BY ID");                   
                //$affichePhotosAnimaux = mysql_query("SELECT * FROM photos WHERE lieu='animaux' ORDER BY ID");
               
            }
            ?>
                
            <div id="DivGlobalOverlay">
                <div id="overlay"></div>

                <div id="ChevronMenuDroite">
                    <div id="DivTopChevronMenuDroite"><div><p><img src="images/ChevronMenuDroiteVersDroite.png" /></p></div></div>
                    <div id="DivBotChevronMenuDroite">
                        <!--<div id="DivBouttonStop"><img id="BouttonStop" src="images/Stop.png" /></div>-->
                        <div id="DivBouttonLecStop"><img id="IMGBouttonLecStop" src="images/Lecture.png" /></div>
                        <div id="DivEspaceCommandesTemps"></div>
                        <div id="DivSablier"><img id="Sablier" src="images/sablier.png" /></div>
                        <div id="DivBoutton3sec"><img id="Boutton3sec" src="images/3sec.png" /></div>
                        <div id="DivBoutton5sec"><img id="Boutton5sec" src="images/5sec.png" /></div>
                        <div id="DivBoutton8sec"><img id="Boutton8sec" src="images/8sec.png" /></div>
                    </div>
                </div>

                <div id="MenuDroite">

                    <div id="ZoneCommentaires">

                        <div id="AffichageCom">
                            <div id="TitrePhoto"><h3></h3></div>
                            <div id="MonCommentaire"><p></p></div>
                            <div id="SeparationAvantCommentairesPublics"><p>&nbsp;</p></div>
                        </div>

                        <div id="DivBasMenuDroite">
                            <div id="AjoutCom">
                                <div><p>Ajoute un Commentaire:</p></div>
                                <form id="myForm">
                                    <label class="form_com" for="firstName">Pseudo:</label>
                                    <input name="pseudo" tabindex="1" id="pseudo" width="100%" maxlength="19" type="text" />
                                    <span class="form_com"></span>
                                    <input id="BouttonEnvoyer" type="submit" value="Valider" tabindex="3" />
                                    <br />
                                    <span class="form_com"></span>
                                    <textarea id="TextAreaCom" class="form_com" name="Comm" tabindex="2" maxlength="500" rows="5" cols="10"></textarea>
                                </form>                                
                            </div>
                            <div id="DivRetour"><p>Retour aux images</p></div>
                        </div>
                    </div>

                </div>
            </div>

            <div id="Commandes">
                <div id="Gauche"><div id="Chevron"><p><img src="images/ChevronGauche.png" /></p></div></div>
                <div id="Centre"></div>
                <div id="Droite"><div id="Chevron"><p><img src="images/ChevronDroite.png" /></p></div></div>
            </div>
            

            <div id="DivChoixAlbum">
                <div id="DivCacheTemporairement"></div>
                <p id="referenceAbsolue"></p>
                <div id="DivRegoupantPetitsDivAlbum">
                    <div id="DivChoixMelbourne" style="background-image: url(images/iconesPhotos/melbourne.jpg);">
                        <div class="texteAlbum"><p>Melbourne</p></div>
                    </div>
                    <div id="DivChoixAnimaux" style="background-image: url(images/iconesPhotos/chouette.jpeg);">
                        <div class="texteAlbum"><p>Animaux</p></div>
                    </div>
                </div>
            </div>
            

            <div id="CadrePhotosMiniatures">
                 
                
                <div id="DivAlbumMelbourne">
                    <?php
                    while ($donnees = mysqli_fetch_array($affichePhotosMelbourne))            //On récupère dans un tableau toutes les entrée de la table photos
                    {
                        $image = imagecreatefromjpeg('photos/miniatures/' . $donnees['NomPhoto']);
                        $largeur_image = imagesx($image);
                        $hauteur_image = imagesy($image);
                        $ratio = $largeur_image/$hauteur_image;         //je préfere travailler sur le ratio plutot que la taille en dur au cas ou j'ai une taille un peu tronquée un jour (pb de calcul ou autre)
                        //Selon que l'image a une largeur plus ou moins grande que la hauteur, je vais choisir un css different pour l'affichage de la miiature (donc créer un id différent)
                        if($ratio <= 1) //si le ration est égal à un (meme taille de H et L, cela ne fait pas de grande difference entre un css ou l'autre)
                        {?>
                            <a id="LiensPhotos" href="https://www.nicolasdegouve.com/photos/miniatures/<?php echo $donnees['NomPhoto'];?>" title="Afficher l'image originale"><div id="PetitDivDeLimageL" style="background-image: url(https://www.nicolasdegouve.com/caroussel/photos/miniatures/<?php echo $donnees['NomPhoto'];?>);"></div></a>
                        <?php
                        }
                        else
                        {?>
                            <a id="LiensPhotos" href="https://www.nicolasdegouve.com/photos/miniatures/<?php echo $donnees['NomPhoto'];?>" title="Afficher l'image originale"><div id="PetitDivDeLimageH" style="background-image: url(https://www.nicolasdegouve.com/caroussel/photos/miniatures/<?php echo $donnees['NomPhoto'];?>);"></div></a>
                        <?php
                        }
                    } ?>             
                </div>
                
                <div id="DivAlbumAnimaux">
                    <?php
                    while ($donnees = mysqli_fetch_array($affichePhotosAnimaux))            //On récupère dans un tableau toutes les entrée de la table photos
                    {
                        $image = imagecreatefromjpeg('photos/miniatures/' . $donnees['NomPhoto']);
                        $largeur_image = imagesx($image);
                        $hauteur_image = imagesy($image);
                        $ratio = $largeur_image/$hauteur_image;         //je préfere travailler sur le ratio plutot que la taille en dur au cas ou j'ai une taille un peu tronquée un jour (pb de calcul ou autre)
                        //Selon que l'image a une largeur plus ou moins grande que la hauteur, je vais choisir un css different pour l'affichage de la miiature (donc créer un id différent)
                        if($ratio <= 1) //si le ration est égal à un (meme taille de H et L, cela ne fait pas de grande difference entre un css ou l'autre)
                        {?>
                            <a id="LiensPhotos" href="https://www.nicolasdegouve.com/photos/miniatures/<?php echo $donnees['NomPhoto'];?>" title="Afficher l'image originale"><div id="PetitDivDeLimageL" style="background-image: url(https://www.nicolasdegouve.com/caroussel/photos/miniatures/<?php echo $donnees['NomPhoto'];?>);"></div></a>
                        <?php
                        }
                        else
                        {?>
                            <a id="LiensPhotos" href="https://www.nicolasdegouve.com/photos/miniatures/<?php echo $donnees['NomPhoto'];?>" title="Afficher l'image originale"><div id="PetitDivDeLimageH" style="background-image: url(https://www.nicolasdegouve.com/caroussel/photos/miniatures/<?php echo $donnees['NomPhoto'];?>);"></div></a>
                        <?php
                        }
                    } ?>             
                </div>
                
                
                
                
                <?php               
                //} ?>
                
            </div>

        </td>
    </tr>
</table>

<script src="js/GestionCaroussel.js"></script>

<?php        
include "BasPage.php";
?>