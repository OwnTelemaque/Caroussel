<?php
//session_start();
//include "baniere.php";


$hote="localhost:3306";
$user="demo_caroussel";
$passe="F@nette05";
$nomBase="demo_caroussel";

//include "connexion.php";
?>






<!DOCTYPE html>

<html>


     <head>
        <title>CV</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" media="screen" type="text/css" href="css/css.css" />
        <link rel="icon" type="image/png" href="/Images/favicon.png" />
    </head>
    
    

    <body id="BackgroundColor">
        
<?php



?>
<table id="TabPrincipal" cellspacing="0" cellpadding="0">
    
    
 
    
    <tr class="TrMenuDeroulant">
        <td colspan="2">
            <div id="DivMenuDeroulant">
                <div id="nav">
                    <nav>
                        <ul class="fancyNav">
                            <li id="news"><a href="index.php">Nouvelles</a></li>
                            <li id="news"><a href="Photos.php" class="NoLink">Photos</a></li>
                            <li id="about"><a href="infosPays.php" class="NoLink">Infos pays</a></li>
                            <li id="services"><a href="administration.php" class="NoLink">Administration</a></li>
                            <li id="contact"><a href="contact.php">Contact</a></li>
                            <li id="home"><a href="http://travelwithnico.com" class="homeIcon">Retour Accueil</a></li>
                        </ul>
                    </nav>
                </div>
            </div>           
        </td>
    </tr>
    <tr class="PagePrincipale">
        <td colspan="2" >





<table id="TabCentral" border="0">
    
    <!--
    <tr align="center">
        <td class="TitrePage">
            <div>
                
                <br />
            </div>   
        </td>                
    </tr>
    <tr>
        <td class="EspaceSousTitre">
            <div></div>
        </td>
    </tr>
    -->
    
    <tr>
        <td>
            <?php
            
            
            $bdd = mysqli_connect($hote, $user, $passe, $nomBase);
            
            
            /*
            if (!$idConnection)                                             
            {
                echo "Connexion à la base de données impossible !";         
            }
            elseif (! mysqli_select_db("$nomBase"))                          
            {
                echo "Impossible de sélectionner la base de données !";     
            }
            */
            
            
            /* Vérification de la connexion */
            if (mysqli_connect_errno()) {
                printf("Échec de la connexion : %s\n", mysqli_connect_error());
                exit();
            }
            
            
           
            /*
            $bdd = new PDO('mysql:host=localhost:3306;dbname=demo_projets;charset=utf8', 'demo_nico', 'F@nette05');
            if (!$bdd)                                             
            {
                echo "Connexion à la base de données impossible !";         
            }
            elseif (! mysqli_select_db("$nomBase"))                          
            {
                echo "Impossible de sélectionner la base de données !";     
            }
            
            */
            
            else                                                         
            {
                
                echo 'je suis connecte a la bdd';
                
                
               // $afficheNouvelles = mysqli_query("SELECT * FROM nouvelles ORDER BY ID DESC");
                
                $afficheNouvelles = $bdd->query('SELECT * FROM nouvelles ORDER BY ID DESC');
                
                
                /* Requête "Select" retourne un jeu de résultats */
                //$afficheNouvelles = mysqli_query($bdd, "SELECT * FROM nouvelles");
                   
                
               
                
                

                    /* Libération du jeu de résultats */
                    //mysqli_free_result($afficheNouvelles);
                
                
                
                echo 'select';
                
                
                
                
                while ($donnees = mysqli_fetch_array($afficheNouvelles))
                
                
                //while ($donnees = $afficheNouvelles->fetch())
                {
                    echo 'affichage';
                    
                    ?>
            
                    
                    <div class="DivConteneurNouvelles">
                        <div class="DivElementsNouvellesTexte">
                            <table class="TableauNouvelles" border='0'>
                                <tr>
                                    <td class="TableauNouvellesTDdates">
                                        <?php echo $donnees['Date'] . ":";?>        
                                    </td>
                                    <td align= "left" class="TableauNouvellesTDtitre">
                                        <?php echo $donnees['Titre'];?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="TableauNouvellesTDEspace" colspan="2"><div></div></td>
                                </tr>
                                <tr>
                                    <td class="TableauNouvellesTDtexte" colspan="2">
                                        <section class="TexteNouvelle">
                                            <?php echo nl2br(html_entity_decode($donnees['Texte']));?>
                                        </section>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="DivElementsNouvellesImages">
                            <?php
                            if (($donnees['Photo1'] != NULL) OR (($donnees['Photo1'] == 1)))
                            {?>    
                            <div class="Photo1Nouvelles">
                                <img src="photosNouvelles.php?num=<?php echo $donnees['ID'];?>&amp;photo=Photo1" width="100%" alt="Chargement en cours...">
                            </div>
                            <?php
                            }
                            if ($donnees['Photo2'] != NULL)
                            {?>
                            <div class="Photo2Nouvelles">
                                <img src="photosNouvelles.php?num=<?php echo $donnees['ID'];?>&amp;photo=Photo2" width="100%" alt="Chargement en cours...">
                            </div>
                            <?php
                            }
                            if ($donnees['Photo3'] != NULL)
                            {?>
                            <div class="Photo3Nouvelles">
                                <img src="photosNouvelles.php?num=<?php echo $donnees['ID'];?>&amp;photo=Photo3" width="100%"  alt="Chargement en cours...">   
                            </div>
                            <?php
                            }?>
                        </div>      
                    </div>
                    <br />
                    <br />                    
                <?php    
                }
                $afficheNouvelles->closeCursor(); // Termine le traitement de la requête
                 
            }
            
            
            
            ?>           
        </td>
    </tr>
    
</table>    
<script src="js/AffichagePhotoOrigineNouvelles.js"></script>




        </td>
        
    </tr>
    <tr class="BasPageold">
            <td>

                <?php
                if($_SESSION['TestConnexion'] == 1)
                { ?>
                <a class="ClairSurFondSombre" href="deconnexion.php">Déconnexion</a>
                <?php
                }
                else
                {
                    ?>
                    <div>&nbsp;</div>
                    <?php
                }
                ?>
            </td>    
            <!--
            <td align="center">
                
                <div>
                    <p class="TexteBasPage">
                        Ce site fonctionne avec les navigateurs Firefox, Google Chrome et Internet Explorer
                    </p>
                </div>            
            
            </td>   
            -->
    </tr>    
</table>    <!-- Fin de la table du tableau principal -->

</body>

</html>






<?php
//include "BasPage.php";
?>

    
