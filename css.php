<?php
header("Content-type: text/css; charset: UTF-8");

/*-------------------------- Couleur de fond de site -------------------------*/

$BGColor = "#333333";

/*------------------------ Mise en Forme Texte général -----------------------*/

$CouleurTitresPages = "#ff845b";
$CouleurTitreNouvelles = "#D5A597";
$CouleurDateBaniere = "#FFFFFF";
$TexteClairSurFondSombre = "#F1CA6B";
$TexteContrasteSombre = "#ffdf55";
$CouleurTexteSurArrierePlan = "#FFFFFF";

/*-------------------------- Mise en Forme Tableaux --------------------------*/

$BackgroundColor = "#936519";
$BackgroundColorPagePrincipale = "#f8f2ec";
$BackgroundColorBasPage = "#74491f";

/*------------------------ Mise en Forme Caroussel Photos --------------------*/

$TitrePhoto = "#D5A597";
$MonComm = "#ff845b";
$PseudoPublic = "#FFFFFF";
$CommPublic = "#D5A597";
$BGcolorBouttonEnvoyer = "#D5A597";
$AjoutComTXT = "#FFFFFF";
$LabelPseudo = "#FFFFFF";
$DivRetour = "#D5A597";
$TexteDivRetour = "#FFFFFF";
$DivRetourHover = "#ff845b";
$TexteDivRetourHover = "#000000";

/*--------------------- Mise en Forme Menu déroulant -------------------------*/

$ArrierePlanMenuDeroulant = "#74491f";
$LiensMenuPrincipal = "#FFFFFF";
$FondBouttonOval = "#ce5a2b";
$LiensSousMenu = "#000000";
$SelectionSousMenu = "#b3481a";
$TexteSelectionSousMenu = "#FFFFFF";

/*------------------- Mise en Forme des Images et Videos ---------------------*/

$OmbrePhotosetVideosNouvelles = "#000000";

?>

/*---------------Fichier CSS pour le site TravelwithNico.com----------------->*/
/*Structure:

1 MENU DEROULANT

2 PAGE DES PHOTOS

3 INITIALISATIONS
  -Mise en forme du texte rapide
  -Mise en forme des Liens
  -Mise en forme des flex
  -Mise en forme des images et videos
  -Mise en forme des tableaux

4 PAGE AJOUT DE NOUVELLES

/*------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*----------------------------------------------------------------------MENU DEROULANT------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*
1
*/
/*----------------------------------------------------------------------------*/
/*---------------------Organisation du menu déroulant------------------------>*/
/*----------------------------------------------------------------------------*/

#DivMenuDeroulant {
    width: 90%;
    margin-left: auto;                                                          /*Si 'margin-left' et 'margin-right' valent 'auto', leurs valeurs effectives sont égales, ce qui centre l'élément dans son bloc conteneur.*/
    margin-right: auto;

   
}

.fancyNav{
    /* Affects the UL element */
    overflow: hidden;
    display: inline-block;
    
    /*retirer l'espace sur la gauche*/
    list-style: none;
    margin-left: 0;                 
    padding-left: 0;
    
}

.fancyNav li{
    /* Specifying a fallback color and we define CSS3 gradients for the major browsers: */

    
    background-color: #f0f0f0;
    background-image: -webkit-gradient(linear,left top, left bottom,from(#fefefe), color-stop(0.5,#f0f0f0), color-stop(0.51, #e6e6e6));
    background-image: -moz-linear-gradient(#fefefe 0%, #f0f0f0 50%, #e6e6e6 51%);
    background-image: -o-linear-gradient(#fefefe 0%, #f0f0f0 50%, #e6e6e6 51%);
    background-image: -ms-linear-gradient(#fefefe 0%, #f0f0f0 50%, #e6e6e6 51%);
    background-image: linear-gradient(#fefefe 0%, #f0f0f0 50%, #e6e6e6 51%);

    border-right: 1px solid rgba(9, 9, 9, 0.125);

    /* Adding a 1px inset highlight for a more polished efect: */

    box-shadow: 1px -1px 0 rgba(255, 255, 255, 0.6) inset;
    -moz-box-shadow: 1px -1px 0 rgba(255, 255, 255, 0.6) inset;
    -webkit-box-shadow: 1px -1px 0 rgba(255, 255, 255, 0.6) inset;

    position:relative;

    z-index: 0;             /*permet de masquer le menu déroulant lorsque l'on regarde les photos en caroussel (sinon il apparait...)*/
    
    float: left;
    list-style: none;
}


.fancyNav li:after{

    /* This creates a pseudo element inslide each LI */	

    content:'.';
    text-indent:-9999px;
    overflow:hidden;
    position:absolute;
    width:100%;
    height:100%;
    top:0;
    left:0;
    z-index:1;
    opacity:0;

    /* Gradients! */

    background-image:-webkit-gradient(linear, left top, right top, from(rgba(168,168,168,0.5)),color-stop(0.5,rgba(168,168,168,0)), to(rgba(168,168,168,0.5)));
    background-image:-moz-linear-gradient(left, rgba(168,168,168,0.5), rgba(168,168,168,0) 50%, rgba(168,168,168,0.5));
    background-image:-o-linear-gradient(left, rgba(168,168,168,0.5), rgba(168,168,168,0) 50%, rgba(168,168,168,0.5));
    background-image:-ms-linear-gradient(left, rgba(168,168,168,0.5), rgba(168,168,168,0) 50%, rgba(168,168,168,0.5));
    background-image:linear-gradient(left, rgba(168,168,168,0.5), rgba(168,168,168,0) 50%, rgba(168,168,168,0.5));

    /* Creating borders with box-shadow. Useful, as they don't affect the size of the element. */

    box-shadow:-1px 0 0 #a3a3a3,-2px 0 0 #fff,1px 0 0 #a3a3a3,2px 0 0 #fff;
    -moz-box-shadow:-1px 0 0 #a3a3a3,-2px 0 0 #fff,1px 0 0 #a3a3a3,2px 0 0 #fff;
    -webkit-box-shadow:-1px 0 0 #a3a3a3,-2px 0 0 #fff,1px 0 0 #a3a3a3,2px 0 0 #fff;

    /* This will create a smooth transition for the opacity property */

    -moz-transition:0.25s all;
    -webkit-transition:0.25s all;
    -o-transition:0.25s all;
    transition:0.25s all;
}

/* Treating the first LI and li:after elements separately */

.fancyNav li:first-child{
	border-radius: 4px 0 0 4px;
}

.fancyNav li:first-child:after,
.fancyNav li.selected:first-child:after{
	box-shadow:1px 0 0 #a3a3a3,2px 0 0 #fff;
	-moz-box-shadow:1px 0 0 #a3a3a3,2px 0 0 #fff;
	-webkit-box-shadow:1px 0 0 #a3a3a3,2px 0 0 #fff;
	
	border-radius:4px 0 0 4px;
}

.fancyNav li:last-child{
	border-radius: 0 4px 4px 0;
}

/* Treating the last LI and li:after elements separately */

.fancyNav li:last-child:after,
.fancyNav li.selected:last-child:after{
	box-shadow:-1px 0 0 #a3a3a3,-2px 0 0 #fff;
	-moz-box-shadow:-1px 0 0 #a3a3a3,-2px 0 0 #fff;
	-webkit-box-shadow:-1px 0 0 #a3a3a3,-2px 0 0 #fff;
	
	border-radius:0 4px 4px 0;
}

.fancyNav li:hover:after,
.fancyNav li.selected:after,
.fancyNav li:target:after{
	/* This property triggers the CSS3 transition */
	opacity:1;
}

.fancyNav:hover li.selected:after,
.fancyNav:hover li:target:after{
	/* Hides the targeted li when we are hovering on the UL */
	opacity:0;
}

.fancyNav li.selected:hover:after,
.fancyNav li:target:hover:after{
	opacity:1 !important;
}

/* Styling the anchor elements */

.fancyNav li a{
	color: #5d5d5d;
	display: inline-block;
	font: 15px/1 Lobster,Arial,sans-serif;
	padding: 12px 20px 14px;
	position: relative;
	text-shadow: 1px 1px 0 rgba(255, 255, 255, 0.6);
	z-index:2;
	text-decoration:none !important;
	white-space:nowrap;
}

.fancyNav a.homeIcon{
	background:url('images/home.png') no-repeat center center;
	display: block;
	overflow: hidden;
	padding-left: 12px;
	padding-right: 12px;
	text-indent: -9999px;
	width: 16px;
}




/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------MISE EN FORME-----------------------------------------------------------------------*/
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/

/*
2
*/
/*----------------------------------------------------------------------------*/
/*-----------------------------Page des photos------------------------------->*/
/*----------------------------------------------------------------------------*/

#DivChoixAlbum {
    display: flex;
    width: 100%;
    
    background-color: rgba(255,255,255,0.4);
    margin-bottom: 20px;
}

/*ce div me permet lorsque je le passe à zindex 1 d'empecher de cliquer sur les boutton de choix des album. Le zindex est defini a 1 uniquement lors de l'exécution de l'evenement*/
#DivCacheTemporairement {
    disaplay: flex;
    position: absolute;
    width: 90%;
    height: 150px;
    z-index: -2;
}

#DivRegoupantPetitsDivAlbum {
    display: flex;
    justify-content: space-around;
    width: 100%;
    padding: 10px;
}

#DivRegoupantPetitsDivAlbum > div{      /*Selectionne tous les div dans lesquel j'ai mes bouttons pour choisir l'album a voir*/
    background-position : center center;
    background-size: auto 100px;

    display: flex;
    justify-content: center;
    align-items: center;

    cursor: pointer;
    
    width: 100px;
    height: 100px;
    
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;

    box-shadow: 2px 2px 8px black;
    -webkit-box-shadow: 2px 2px 8px black;
    -moz-box-shadow: 2px 2px 8px black;
    
    color: transparent;
    font-size: 20px;
    
    transition-property: font-size, color, text-shadow;
    transition-duration: 1s;
}


/*-----------Animation bouttons Albums-----------*/

#DivRegoupantPetitsDivAlbum > div:hover {
    color: <?php echo $TexteContrasteSombre; ?>;
    text-shadow: 1px 1px 2px black, 0 0 25px orange, 0 0 5px red;
    font-size: 40px;
}


/*------------FIN animation--------------*/

#CadrePhotosMiniatures {
    display: flex;
}

#CadrePhotosMiniatures > div{               /*selectionne le div qui se trouve juste en dessous de CadrePhotosMiniatures*/
    display: none;
    flex-wrap: wrap;
    position: relative;
    top: 0; left: -2000px;
    width: 100%;
    justify-content: center;

    background-color: rgba(9,9,9,0.8);
    
    padding: 5px;
    
    box-shadow: -2px 2px 10px <?php echo $TexteContrasteSombre; ?>;
    -webkit-box-shadow: -2px 2px 10px <?php echo $TexteContrasteSombre; ?>;
    -moz-box-shadow: -2px 2px 10px <?php echo $TexteContrasteSombre; ?>;
    
    flex: 4;
    color: black;
}

/*cet element me permet de récupérer la valeur de la position par rapport au bord gauche de l'écran*/
#referenceAbsolue {
    position: absolute;     /*c'est pour cela qu'il est en position absolute*/
    z-index: -1;            /*et que je le fou derrière pour qu'il ne gêne rien et soit comme transparent*/
}

/*Mes 2 animations pour faire glisser mes albums - meme action mais j'en ai tout de meme fait 2 pour éviter les problèmes lorsque les animations se font simulatanéments*/
@keyframes animationRetireAlbum {
    0% {
        transform: translateX(0px);
    }
    100% {
        transform: translateX(2000px);
    }
}

@keyframes animationAjouteAlbum {
    0% {
        transform: translateX(0px);
    }
    100% {
        transform: translateX(2000px);
    }
}



#ImageMiniature{
    border: none;
}

#PetitDivDeLimageH{
    margin: 2px;
    width: 100px;
    height: 100px;
    background-size: auto 100px;
    background-position: center center;
    background-repeat: no-repeat;
    border: 1px solid black;
}
#PetitDivDeLimageL{
    margin: 2px;
    width: 100px;
    height: 100px;
    background-size: 100px auto;
    background-position: center center;
    background-repeat: no-repeat;
    border: 1px solid black;
}
  
/*il s'agit du Div qui va s'afficher au dessus de la page web pour afficher les photos*/                                                                                    
#overlay {
    display : none; /* Par défaut, on cache l'overlay */
    position: absolute;
    top: 0; left: 0;
    width: 75%; height: 100%;
    justify-content: center;
    align-items: center;
    background-color: rgba(0,0,0,0.9);

    transition-property: width;
    transition-duration: 1s;
}


/*il s'agit du div qui se met devant tout pour me permettre d'afficher le .gif d'attente lorsqu'un commentaire est envoyé*/
#DivGlobalOverlay
{
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    display: none;
    justify-content: flex-end;
}

/*Div qui se met sur l'espace de la phtot pour que je puisse mettre les commande de gauche et droite pour détéecter les clics de la souris afin de passer aux images suivantes*/
#Commandes {
    display : none;
    position: absolute;
    top: 0; left: 0;
    width: 75%; height: 100%;
    text-align: center;
    justify-content: space-between;
    z-index: 2; 
    
    transition-property: width;
    transition-duration: 1s;
}
/*l'icone du chevron*/
#Chevron img{
    height: 50px;
    padding-left: 30px;
    padding-right: 30px;
}


/*les pannaux de gauche et droite*/
#Gauche {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    flex: 1;
}

#Centre {
    display: flex;
    align-items: center;
    justify-content: center;
    flex: 1;
}

#Droite{
    display: flex;
    align-items: center;
    justify-content: flex-end;
    flex: 1;
}


/*Le div de droite dans lequel je vais agencer les commentaires*/
#MenuDroite {
    display: none;
    width: 23%; height: 100%;
    z-index: 3;
    background-color: rgba(9,9,9,0.9);
    
    transition-property: background-color, width; /* Active la transition sur background-color */
    transition-duration: 1s;
}

/*le div de 3px de large dans lequel va se trouver le div sur lequel cliquer pour afficher/masquer les commentaires et le menu du diaporama*/
#ChevronMenuDroite {
    display: flex;
    flex-direction: column;
    width: 2%;
    background-color: rgba(9,9,9,0.9);
    align-items: center;
    height: 100%;
    
    
    transition-property: background-color;
    transition-duration: 1s;
}

/*le div permettant d'afficher/masquer les commentaires */
#DivTopChevronMenuDroite
{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    
    transition-property: background-color;
    transition-duration: 1s;
}
/*son image*/
#DivTopChevronMenuDroite img{
    height: 20px;
}

/*Le div du menu du diaporama*/
#DivBotChevronMenuDroite
{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    width: 100%;
    //height: 50%;
    
    transition-property: background-color;
    transition-duration: 1s;
}
/*pour centrer les icones (les divs donc)*/
#DivBotChevronMenuDroite div{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

/*et ses images...*/
#DivBotChevronMenuDroite img{
    width: 70%;
}
#DivBotChevronMenuDroite img:hover{
    cursor: pointer;
}
#DivSablier img:hover{              /*par contre je ne veux pas de difference au niveau du curseur quand je passe sur l'icone du sablier*/
    cursor: default;
}
#DivEspaceCommandesTemps{
    height: 20px;
}

#IMGPlayDiapo{
    

    transition-property: width;
    transition-duration: 1s;
}




/*Le div dans lequel je vais agencer tous mes div pour afficher les commentaires*/
#ZoneCommentaires {
    width: 100%;
    display: flex;
    height: 100%;
    flex-direction: column;
    justify-content: space-between;
}   

/*Div dans lequel je vais mettre 3 div: celui du titre de la photo, celui de mon commentaire et celui faisant office de séparation aves les comm publiques (les 3 suivants)*/
#AffichageCom {
    display: flex;
    flex-direction: column;
    overflow: auto;
}
#TitrePhoto {
    text-align: center;
}
#TitrePhoto h3 {
    color: <?php echo $TitrePhoto; ?>;
}

#MonCommentaire {
    height: auto;
    min-height: 20px;
    text-align : justify;
    padding-left: 10px;
    padding-right: 10px;
    font-color: red;   
    overflow: auto;
}
#MonCommentaire p {
    color: <?php echo $MonComm; ?>;
}

#SeparationAvantCommentairesPublics {
    height: 20px;
    border-bottom: 1px solid white;
}

/*Ces 2 div sont insérés en javascript uniquement lorsqu'un commentaire publique doit etre affiché.*/
#EmplacementCommentairePublic {
    height: auto;
    min-height: 20px;
    overflow: auto;
    padding-top: 10px;
    padding-left: 10px;
    padding-right: 10px;
}
/*Crée un div pour chaque commentaire publique*/
#CommentairePublic {
    text-align: justify;
    padding-bottom: 10px;
}
/*mise en forme de l'affichage du texte du pseudo et du commentaire*/
#PseudoPublic {
    font-weight : bold;
    color: <?php echo $PseudoPublic; ?>;
}
#ComPublic {
    white-space: wrap;
    color: <?php echo $CommPublic; ?>;
}


/*Div de bas de page dans lequel se trouve le formulaire d'ajout de commentaire et le boutton de retour aux photos qui doivent etre alignés en bas*/
#DivBasMenuDroite {
    padding-top: 10px;
    padding-bottom: 5px;
}

/*div concernant les éléments du formulaire*/
#AjoutCom {
    align: left;
    padding-bottom: 10px;
    width: 95%;
}

/*le texte "ajouter un commentaire"*/
#AjoutCom p {
    color: <?php echo $AjoutComTXT; ?>;
}
/*le texte ""pseudo*/
#AjoutCom label {
    color: <?php echo $LabelPseudo; ?>;
}
/*le input*/
#pseudo {
    padding: 2px;
    border: 1px solid white;
    border-radius: 2px;
    outline: none; 
}
#pseudo:focus {
    border-color: rgba(82, 168, 236, 0.75);
    box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -webkit-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -moz-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
}
#AjoutCom textarea {
    width: 95%;
    padding: 2px;
    border: 1px solid white;
    border-radius: 2px;
    outline: none;  
}
#AjoutCom textarea:focus {
    border-color: rgba(82, 168, 236, 0.75);
    box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -webkit-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -moz-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
}
/*Le boutton envoyer*/
#BouttonEnvoyer {
    border: none;
    background-color: <?php echo $BGcolorBouttonEnvoyer; ?>;
    height: 24px;
    font-family: cursive;
}
#BouttonEnvoyer:hover {
    border-color: rgba(82, 168, 236, 0.75);
    box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -webkit-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -moz-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    color: white;
}

/*Le div dans lequel se trouve le boutton de retour*/
#DivRetour {
    display: flex;
    width: 95%;
    align-items: center;
    justify-content: center;
    background-color: <?php echo $DivRetour; ?>;
    color: <?php echo $TexteDivRetour; ?>;
    //text-align: center;
    height: 30px;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    white-space = nowrap;    
    overflow: hidden;
}
#DivRetour:hover {
    background-color: <?php echo $DivRetourHover; ?>;
    color: <?php echo $TexteDivRetourHover; ?>;
    cursor: pointer;
}


/*-----------------------------Fin page des photos----------------------------------*/



/*
3
*/
/*----------------------------------------------------------------------------*/
/*-------------------------------Initialisations------------------------------*/
/*----------------------------------------------------------------------------*/


#BackgroundColor {
    background-image: url("images/fond.jpeg");
    background-size: 100%;
    background-repeat: no-repeat;
    background-attachment: fixed;
}


/*----------------------------------------------------------------------------*/
/*-----------------------Mise en forme du texte rapide------------------------*/
/*----------------------------------------------------------------------------*/

p {
    display: inline;                          
}

.TexteSurArrierePlan {
    color: <?php echo $CouleurTexteSurArrierePlan; ?>;
}

#date { /* Mise en forme de la date sur la baniere */
  color: <?php echo $CouleurDateBaniere; ?>;
  position: absolute;
  right: 20px;
  top: 12px;
}

.TexteBasPage {
    font-size: 13px;
}

.TexteNouvelle {
    -webkit-column-count:3;             /*Nombre de colonnes*/
    -moz-column-count: 3; 
    column-count: 3; 
    
    -webkit-column-gap: 50px;          /*Espace de séparation en tre les colonnes*/
    -moz-column-gap: 50px;
    column-gap: 50px;
    
    
}

.ClairSurFondSombre {
  color: <?php echo $TexteClairSurFondSombre; ?>;
}



/*----------------------------------------------------------------------------*/
/*---------------------------Mise en forme des Liens--------------------------*/
/*----------------------------------------------------------------------------*/

a /* Tous les liens sur le site */
{
text-decoration: none; /*Pas de soulignage*/
color: #936519;
}

a img /* Enleve les contours sur toutes les images servants de liens */
{
  border: none;
}

a.ClairSurFondSombre {
  color: <?php echo $TexteClairSurFondSombre; ?>;
}


/*----------------------------------------------------------------------------*/
/*-----------------------------Mise en forme des Flex-------------------------*/
/*----------------------------------------------------------------------------*/

.DivConteneurNouvelles {
    display: flex;
    justify-content: space-between;
    text-align: justify;
}

.DivElementsNouvellesTexte {
    background-color: rgba(255,255,255,0.8);
    padding: 5px;
    box-shadow: -2px 2px 10px <?php echo $TexteContrasteSombre; ?>;
    -webkit-box-shadow: -2px 2px 10px <?php echo $TexteContrasteSombre; ?>;
    -moz-box-shadow: -2px 2px 10px <?php echo $TexteContrasteSombre; ?>;
    flex: 4;
    color: black;
    
}

.DivElementsNouvellesImages {
    flex: 1; 
    display: flex;
    flex-direction: column;
    justify-content: top;
    align-items: center;
    text-align: center;
    padding-left: 10px;
}


/*----------------------------------------------------------------------------*/
/*----------------------Mise en forme des images et videos--------------------*/
/*----------------------------------------------------------------------------*/



/*cours suivi sur openclassroom. me sert de modele*/

.phototest {

    -webkit-transform-origin: 0 0;/* Safari, Chrome */
    -ms-transform-origin: 0 0; /* IE */
    -moz-transform-origin: 0 0; /* Firefox */
    -o-transform-origin: 0 0; /* Opera */
    transform-origin: 100% 100%; /* La transformation partira du coin en haut à gauche */

    transform: rotate(10deg) scale(1.3) skewY(-15deg);
    -webkit-transform: rotate(10deg); /* Safari */
}
/* fin du modele */

/*Il s'agit des images rajoutée depuis la base de donnée dans les nouvelles*/
.ImagesNouvelles {
    box-shadow: 0 0 3px <?php echo $OmbrePhotosetVideosNouvelles; ?>;
    -webkit-box-shadow: 0 0 3px <?php echo $OmbrePhotosetVideosNouvelles; ?>;
    -moz-box-shadow: 0 0 3px <?php echo $OmbrePhotosetVideosNouvelles; ?>;
   
}

.ImagesVideos {
    box-shadow: 0 0 8px <?php echo $OmbrePhotosetVideosNouvelles; ?>;
    -webkit-box-shadow: 0 0 8px <?php echo $OmbrePhotosetVideosNouvelles; ?>;
    -moz-box-shadow: 0 0 8px <?php echo $OmbrePhotosetVideosNouvelles; ?>;
}


/*----------------------------------------------------------------------------*/
/*---------------------------Mise en forme des tableaux-----------------------*/
/*----------------------------------------------------------------------------*/
                                    

/*-----------------------Mise en forme Tableau Principal----------------------*/



#TabPrincipal {                                                                   /*Centrage*/
    margin-left: auto;                                                          
    margin-right: auto;
    width: 100%;  
    border-spacing: 0px;
    padding: 5px;    
}

#TabPrincipal tr.TrMenuDeroulant{
    width: 80%;
}

#imageBaniere {
    vertical-align: bottom;
}
#TabPrincipal tr.Baniere {                                                      /*Tr de la baniere*/

  border: 10px solid red;
}


#TabPrincipal tr.PagePrincipale {                                          /*     Couleur de fond de la page principale*/
   /* background-color: <?php echo $BackgroundColorPagePrincipale; ?>;                          /*On défini une couleur*/
    height: 100%;
}

#TabPrincipal tr.BasPage {                                                      /*Tr du bas de page*/
    background: <?php echo $BackgroundColorBasPage; ?> url(images/gradient.png) repeat-x 0px -100px  !important;                   /*On défini une couleur*/
}

/*------------------Mise en forme Tableau de la page centrale-----------------*/


#TabCentral {
    margin-left: auto;                                                          /*Si 'margin-left' et 'margin-right' valent 'auto', leurs valeurs effectives sont égales, ce qui centre l'élément dans son bloc conteneur.*/
    margin-right: auto;
    width: 90%;                                                                 /*On utilise 90% de l'espace de la page centrale'*/
}


#TabCentral td.TitrePage {
    vertical-align: bottom;
    height: 70px;
    color: <?php echo $CouleurTitresPages; ?>;
    font-size: 25px;
    font-family: cursive;
    text-align: center;  
    vertical-align: bottom;
}

#TabCentral td.EspaceSousTitre {
    height: 50px;
}





/*----------------------- Tableau de l'ajout de photo-------------------------*/

#TabPhotos {
    margin-left: auto;                                                          /*On centre notre tableau*/
    margin-right: auto;
    width: 100%;                                                                /*On lui donne toute la place à occuper à l'interieur de TabCentral'*/
    background-color: <?php echo $CouleurArriereplanPhotos; ?>;
    vertical-align: top;
    //border-spacing: 0px;
    //padding: 2px;
}

#TabPhotos td {
    vertical-align: top; 
    border: 0px solid <?php echo $CouleurCadreTableauPhotos; ?>;                                                  /*Afin de laisser des espaces entre les differents commentaires et un cadre de couleur bleue*/
}    

#TabPhotos td.ColonnePhotos{
    width: 60%;
}

#TabPhotos td#null {                                                       /*Pour tout le reste, les contours sont cachés? */
    border: hidden;
}


  

/*------------------- Tableau des suppressions de photos ---------------------*/


#TabPhotosSup {
    width: 100%;
}

#TabPhotosSup td.ColonnePhotos {
    max-width: 50%;
    min-width: 50%;   
}

#TabPhotos td.ColonnePhotoASup {
    width: 80%;
}


/*-------------- Tableau des nouvelles sur l'index----------------*/

.TableauNouvelles {
    width: 100%;
    
}

.TableauNouvelles td.TableauNouvellesTDtitre {
    text-align: left;
    width: 100%;
    color: <?php echo $CouleurTitreNouvelles; ?>;
    font-weight: bold;
}

.TableauNouvelles td.TableauNouvellesTDdates {
   white-space: nowrap;                                                         /*empeche le retour à la ligne automatique*/
   color: <?php echo $CouleurTitreNouvelles; ?>;
   font-weight: bold;
}

.TableauNouvelles td.TableauNouvellesTDEspace {
   height: 20px;                                                     
}



/*
4
*/
/*----------------------------------------------------------------------------*/
/*----------------------------Page ajout de nouvelles-------------------------*/
/*----------------------------------------------------------------------------*/

#DivGlobalNouvelle {
    display: flex;
    flex-direction: column;
    width: 90%;    
    //border: 1px solid blue;
}

#DivTopBouttonEnvoyerNouvelle {
    display: flex;
    justify-content: flex-end;
    width: 100%;
    text-align: right;    
}
#DivBouttonEnvoyerNouvelle {
    width: 20%;
}
#BouttonEnvoyerNouvelle {
    width: 100%;
    border: none;
    background-color: <?php echo $BGcolorBouttonEnvoyer; ?>;
    height: 24px;
    font-family: cursive;
    cursor: pointer;
    border-color: rgba(82, 168, 236, 0.75);
    
    box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -webkit-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    -moz-box-shadow: 0 0 8px rgba(82, 168, 236, 0.5);
    
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
}
#BouttonEnvoyerNouvelle:hover {
    color: white;
}

#DivContenantGaucheDroiteNouvelle {
    display: flex;
    width: 100%;    
    //border: 1px solid red;
}

#DivGaucheNouvelle {
    display: flex;
    flex-direction: column;
    align-items: left;
    
    width: 80%
}
#DivTitreDateNouvelle {
    display: flex;
    align-items: left;
}
#DivTitreNouvelle {
    margin-right: 10px;
}

#Div3PhotosNouvelle {
    display: flex;
    align-items: left;
}

#DivCommandesGraphiques {
    display: flex;
    align-items: left;
}
#DivCommandesGraphiques Div {
    margin-left: 5px;
    margin-right: 5px;
}
#DivCommandesGraphiques p:hover {
    cursor: pointer;
}
#DivGras {
    font-weight: bold;
}
#DivSouligne {
    text-decoration: underline;
}
#DivItalic {
    font-style: italic;
}
#DivTaille {
    font-size: 15px;
}

#DivTexteNouvelle {
    display: flex;
    flex-direction: column;
    align-items: left;
}

#DivDroiteNouvelle {
    display: flex;
    flex-direction: column;
    align-items: left;
    margin-top: 50px;
    width: 20%
}

#DivAjoutPhotos {
    display: flex;
    width: 100%;
    flex-direction: column;
}

#DivAjoutVideos {
    display: flex;
    flex-direction: column;
}


#DivEspaceNouvelle {
    widht: 100px;
    height: 20px;
}
#DivInsertionImage p {
    font-weight: bold;
    color: white;
}
#DivInsertionImage .TexteAjoutNouvelle {
    color: <?php echo '#ff845b';?>;
}
#DivInsertionImage p:hover {
    cursor: pointer;
}

#DivInsertionVideo p {
    font-weight: bold;
    color: white;
}
#DivInsertionVideo  .TexteAjoutNouvelle {
    color: <?php echo '#ff845b';?>;
}
#DivInsertionVideo p:hover {
    cursor: pointer;
}


