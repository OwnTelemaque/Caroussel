/*A noter que je n'ai pas pris en charge l'ajout de caractère de type tabulation dans les commentaires car cela n'est pas censé arriév (mis à part un mauvais copier/coller)
 * cela provoque un bug d'affichage si un tel caractère est inséré car la fonction json ne sai tpas le traiter correctement. Il faudrait procéder de la meme manière que pour
 * les retours chariot mais j'ai eu la flemme de le faire pour l'instant
 *   */

var IdForm = document.getElementById('myForm');
    
var BlockdeDroite = document.getElementById('MenuDroite');
var ZoneCommentaires = document.getElementById('ZoneCommentaires');  

var ProchainePhotoaAfficheraGauche = {};
var ProchainePhotoaAfficheraDroite = {};

var toutesMesPhotos = [];
var TousMesLiens = [];                          //on va récupérer dans ce tableau accessible dans toutes les fonctions les liens de toutes les images présentes en miniatures (grace à la boucle for ci-dessous)


var DivAlbumaCacher = [];           //Cette variable va me permettre de stocker l'album sélectionné pour pouvoir faire des modifs dessus (le déplacer puis le cacher) lorsque l'on passe à un autre album
//var NombredePhotos = toutesMesPhotos.length;




/*------------------------------------------------------------------------*/
/*----------------------------FONCTIONS-----------------------------------*/
/*------------------------------------------------------------------------*/

/*Cette fonction permet la création d'un objet XMLHttpRequest instancié afin d'envoyer un nouveau commentaire*/
function getXMLHttpRequest() {
    var xhr = null;
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest(); 
        }
    } else {
    alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
    return null;
    }
    return xhr;
}     


/*Cette fonction permet de supprimer les commentaire lorsque l'on passe à une photo suivante ou précédente ils seront ré-affichés lors de l'exécution de la fonction displayImg*/
function Refresh() {
    var DivDesCommentairesPublicsaSuprimer = document.getElementById('EmplacementCommentairePublic');   // Je suprime les commentaires public que l'on a ajouté avant de passer à l'image suivante sinon ils restent affichés
    if(DivDesCommentairesPublicsaSuprimer)                                  //Si le div dans lequel les commentaires sont affichés existe...
    {
        DivDesCommentairesPublicsaSuprimer.parentNode.removeChild(DivDesCommentairesPublicsaSuprimer);  //On le vire
    }
}


/* Cette fonction permet de ré-initialiser les éléments lorsque l'on décide de quitter l'image visualisée. (soit en appuyant sur échap soit en cliquant sur le boutton du menu de droite pour quitter) */
function Raz() {
    var Commandes = document.getElementById('Commandes');
    var overlay = document.getElementById('overlay');
    var DivTopChevronMenuDroite = document.getElementById('DivTopChevronMenuDroite');
    var DivGlobalOverlay = document.getElementById('DivGlobalOverlay');
    var ChevronMenuDroite = document.getElementById('ChevronMenuDroite');
    var DivTopChevronMenuDroite = document.getElementById('DivTopChevronMenuDroite');
    var DivBotChevronMenuDroite = document.getElementById('DivBotChevronMenuDroite');

    //lors de l'appuie....
    if(IDmaTempo.ID || IDmaTempo.Status)                                    //Si j'avais un diapo de lancé ou qu'il y en a eu un puis stoppé par la barre d'espace....
    {
        clearInterval(IDmaTempo.ID);                                        //On l'arrete
        IDmaTempo.Status = '';                                              //et on empeche de le relancer si l'on appuie sur la barre d'espace
        IDmaTempo.ID = '';                                                  //on ré-initialise nos variables
        TransformStopToLecture ()                                           //je remet mon boutton en mode lecture et je remet les bons évenements dessus grace a ma fonction
    }
    ChevronMenuDroite.style.backgroundColor = 'rgba(9,9,9,0.9)'; 
    DivTopChevronMenuDroite.style.backgroundColor = 'transparent';          //Je le met en transparent sinon comme le div de fond est déjà en noir transparent si je met la même couleur, cela donne un résultat assombri
    DivBotChevronMenuDroite.style.backgroundColor = 'transparent';

    Commandes.style.display = 'none';                                       //on vire le pannaux d'affichage...
    Commandes.style.width = '75%';                                          //...dont on ré-initialise la taille à 75% pour etre pret à etre affiché si l'on ré-ouvre une photo ensuite

    overlay.style.display = 'none';                                         //même traitement pour l'overlay
    overlay.style.width = '75%';

    BlockdeDroite.style.display = 'none';                                   //même traitement pour le menu de droite
    BlockdeDroite.style.width = '23%';                                      //lui a une taille de 23% en revenche

    //On modifie le sens (change l'image) de notre chevron
    var EmplacementImageChevronMenuDroite = DivTopChevronMenuDroite.firstChild;
    EmplacementImageChevronMenuDroite = EmplacementImageChevronMenuDroite.firstChild;
    EmplacementImageChevronMenuDroite = EmplacementImageChevronMenuDroite.firstChild;
    EmplacementImageChevronMenuDroite.src = 'images/ChevronMenuDroiteVersDroite.png';

    DivGlobalOverlay.style.display = 'none';                                //On cache le div global sinon on ne peut plus rien faire sur la page: il est transparent et nous empeche de cliquer sur les éléments de la page
    document.getElementById('MonHTML').style.overflow = "auto";             //on replace le scroll de la fenetre principale que l'on avait desactivé pour la visualisation des photos

    Refresh();                                                              //On supprime les commentaires publics éventuellemnt affichés pour l'image sinon ils vont se réafficher si on ré-ouvre une image.
}


/* Cette fonction s'occupe d'afficher TOUT LE TEXTE necessaire à la photo (titre, com, com publiques...) elle prend en paramètre le nom de la photo pour laquelle on souhaite afficher les commentaires*/
function AffichageInfosTextuellesPhoto(imageSource) {

    //console.log('Nom de Photo a transformer: ' + imageSource);

    var NomPhotoPourCommentaires = imageSource;                             //petit traitement sur la chaine de caractère pour avoir le nom de photo tel qu'on en a besoin dans la fonction
    NomPhotoPourCommentaires = NomPhotoPourCommentaires.substring(NomPhotoPourCommentaires.lastIndexOf('/') + 1);
    //console.log('Mon nom de photo est: ' + NomPhotoPourCommentaires);

    var xhrLecture = getXMLHttpRequest();                                   //On instancie un nouvel objet XMLHttpRequest en appelant la fonction respective

    xhrLecture.open("GET", "LectureComPHP.php?&NomPhotoAmodif=" + NomPhotoPourCommentaires, true);      //on envoi la seule variable dont on a besoin: le nom de la photo.
    xhrLecture.send(null);

    /*On va attendre que le traitement soit terminé...  Lorsque le traitement est terminé on exécute les taches présentes dans la fonction suivante*/
    xhrLecture.addEventListener('readystatechange', function() {
        if (xhrLecture.readyState === XMLHttpRequest.DONE) { // La constante DONE appartient à l'objet XMLHttpRequest, elle n'est pas globale

            var response = JSON.parse(xhrLecture.responseText);             //je récupere mes echo du fichier LectureComPHP et la fonction JSON.parse soccupe de tout foutre en ordre dans un objet

            //On commence le traitement pour injecter le TITRE et les COMMENTAIRES PERSOS aux bons endroits de notre menu de droite
            var EmplacementTitre = document.getElementById('TitrePhoto');
            EmplacementTitre = EmplacementTitre.firstElementChild;
            //console.log(EmplacementTitre);
            EmplacementTitre.innerHTML = response.titre;

            var EmplacementMonCommentaire = document.getElementById('MonCommentaire');
            EmplacementMonCommentaire = EmplacementMonCommentaire.firstElementChild;
            EmplacementMonCommentaire.innerHTML = response.monCom;

            //Si on a des commentaires publiques à afficher, on les rajoutes....
            if (response.NbCommentaire > 0)
            {
                var EmplacementCommentairesPublics = document.getElementById('AffichageCom');
                var NouveauDivCommentairesPubliques = document.createElement('div');
                NouveauDivCommentairesPubliques.id = 'EmplacementCommentairePublic';
                EmplacementCommentairesPublics.appendChild(NouveauDivCommentairesPubliques);

                var InsertionDesComm = document.getElementById('EmplacementCommentairePublic');
                //console.log(EmplacementCommentairesPublics);

                for (k=1; k<=response.NbCommentaire; k++)
                {
                    var tempPseudo = 'pseudo' + '' + k;
                    //variable a utiliser: response[tempPseudo];

                    var tempCom = 'commentaire' + '' + k;
                    //variable a utiliser: response[tempCom];

                    var newDivCommentPublic = document.createElement('div');
                    newDivCommentPublic.id = 'CommentairePublic';
                    var newPPseudoPublic = document.createElement('p');
                    newPPseudoPublic.id = 'PseudoPublic'
                    var newPCommentPublic = document.createElement('p');
                    newPCommentPublic.id = 'ComPublic'
                    newPPseudoPublic.innerHTML = response[tempPseudo];
                    newPCommentPublic.innerHTML = response[tempCom];
                    newDivCommentPublic.appendChild(newPPseudoPublic);
                    newDivCommentPublic.appendChild(newPCommentPublic);

                InsertionDesComm.appendChild(newDivCommentPublic);
                }                    
            }
        }
    });
}


/*Ma fonction la plus importante: l'affichage de la photo et */
function displayImg(link) {

    var img = new Image(),
        overlay = document.getElementById('overlay'),
        Commandes = document.getElementById('Commandes'),
        DivGlobalOverlay = document.getElementById('DivGlobalOverlay');

    /*on rajoute cet evenement dans lequel le code sera exécuté une fois l'objet img (notre image donc) chargée
    Ce code sera donc exécuté dès que l'image aura fini d'être chargée sur la page*/
    img.addEventListener('load', function() {

        overlay.innerHTML = '';         //on supprime le texte "Chargement en cours puisque l'image est prete a être affichée" 
        overlay.style.display = 'flex';
        Commandes.style.display = 'flex';
        Commandes.style.position = 'fixed';

        MenuDroite.style.display = 'flex';
        DivGlobalOverlay.style.display = 'flex';
        DivGlobalOverlay.style.position = 'fixed';
        DivGlobalOverlay.style.zIndex = '1';

        document.getElementById('MonHTML').style.overflow = "hidden";       //On empeche d'avoir le scroll sur la doite lors de la visualisation des photos

        //gestion de l'affichage de l'image selon que la hauteur et plus grande que la largeur - on teste lles tailles de l'image en fonction des tailles de l'overlay
        if (img.height > overlay.offsetHeight || img.width > overlay.offsetWidth)   //Si on a une image dont la largeur ou la hauteur dépassent celles du DIV overlay...
        {
            if (img.width / img.height < overlay.offsetWidth / overlay.offsetHeight) 
            {
                img.style.height = '100%';
            }
            else if (img.width / img.height > overlay.offsetWidth / overlay.offsetHeight) 
            {
                img.style.width = '100%';
            }
        }
        //on insere notre image
        overlay.appendChild(img);
    });

    //ce code est exécuté avant celui dans le bloc au dessus
    img.src = link;  //on récupère l'image en fonction de la valeur qui a été passée en paramètre de la fonction.
    img.style.display = 'block';    //on modifie l'attribu de l'image pour que cette dernière soit affichée en tant que block

    overlay.innerHTML = '<span>Chargement en cours...</span>';
    var TexteChargementEnCours = overlay.firstChild;
    TexteChargementEnCours.style.color= 'white';


   /////////////traitement de l'affichage des commentaires//////////////////    

    AffichageInfosTextuellesPhoto(img.src);                                //on exécute la fonction

   /////////////FIN TRAITEMENT AFFICHAGE COMMENTAIRES//////////////////


    /////////////traitement du passage aux images suivantes et précédentes//////////////////


    ProchainePhotoaAfficheraGauche = null;
    ProchainePhotoaAfficheraDroite = null;
    var ToutesLesPhotos = TousMesLiens;
    var IDPhotoActuelle = 0;

    //console.log('Compte du tableau: ' + ToutesLesPhotos.length);
    //console.log('Image source: ' + img.src);

    for (j=0; j<ToutesLesPhotos.length; j++)
    {
        if (ToutesLesPhotos[j] == img.src)
        {
            IDPhotoActuelle = j;                    //Je récupère l'ID dans le tableau contenant tous les liens des photos celui de la photo actuellement affichée
        }
    console.log('img src: ' + img.src);
    console.log(ToutesLesPhotos[j].href);
    }
    //console.log('ID actuel: ' + IDPhotoActuelle);


    //enusite on met dans 2 variables différentes l'ID de la photo suivante et précédente à afficher
    IDProchainePhotoaAfficheraGauche = IDPhotoActuelle-1;
    IDProchainePhotoaAfficheraDroite = IDPhotoActuelle+1;

    //console.log('ID de la prochaine photo à gauche: ' + IDProchainePhotoaAfficheraGauche);
    //console.log('ID de la prochaine photo à droite: ' + IDProchainePhotoaAfficheraDroite);

    //on gère le fait d'être en début ou en fin de liste
    if (IDProchainePhotoaAfficheraGauche == -1)
    {
        IDProchainePhotoaAfficheraGauche = ToutesLesPhotos.length - 1;
    }

    if (IDProchainePhotoaAfficheraDroite == ToutesLesPhotos.length)
    {
        IDProchainePhotoaAfficheraDroite = 0;
    }

    //On stocke le résultat de notre recherche dans 2 objets afin d'utiliser ces variables en dehors de cette fonction
    ProchainePhotoaAfficheraGauche = ToutesLesPhotos[IDProchainePhotoaAfficheraGauche];
    ProchainePhotoaAfficheraDroite = ToutesLesPhotos[IDProchainePhotoaAfficheraDroite];
    //console.log('Prochaine photo a afficher à gauche: ' + ProchainePhotoaAfficheraGauche);
    //console.log('Prochaine photo a afficher à droite: ' + ProchainePhotoaAfficheraDroite);
    //console.log('Mon objet: ' + ProchainePhotoaAfficheraGauche);
}

/*-------------------------------------------------------------------------*/
/*---------------------------Fin des Fonctions-----------------------------*/
/*-------------------------------------------------------------------------*/





/*-------------------------------------------------------------------------*/
/*------------------------------EVENEMENTS---------------------------------*/
/*-------------------------------------------------------------------------*/




/*-------- FIN de l'évênement de désactivation d'ouverture dans une nouvelle image --------*/



/*-------------Evenement permettant de surveiller l'envoi de nouveaux commentaires par le formulaire---------------*/

IdForm.addEventListener('submit', function(e) {

    //on récupère les données à envoyer (pseudo + comm)
    var LePseudo = document.getElementsByName('pseudo');
    var LeComm = document.getElementsByName('Comm');

    LePseudo = LePseudo[0].value;
    LeComm = LeComm[0].value;

    var NomPhotoSRC = document.getElementById('overlay');
    NomPhotoSRC = NomPhotoSRC.getElementsByTagName('img');
    NomPhotoSRC = NomPhotoSRC[0].src;
    //console.log('nom photo: ' + NomPhoto);
    NomPhoto = NomPhotoSRC.substring(NomPhotoSRC.lastIndexOf('/') + 1);     //Traitement sur la chaine de caractère pour récupérer uniquement le nom de la photo et pas tout le lien

    //console.log(NomPhoto);
    //console.log(LePseudo);
    //console.log(LeComm);

    //préparation de l'envoi des données
    var xhrEnvoi = getXMLHttpRequest();                                     //On instancie un nouvel objet XMLHttpRequest en appelant la fonction respective

    LePseudo = encodeURIComponent(LePseudo);
    LeComm = encodeURIComponent(LeComm);

    xhrEnvoi.open("GET", "AjoutComPHP.php?Pseudo=" + LePseudo + "&Comm=" + LeComm + "&NomPhoto=" + NomPhoto, true);
    xhrEnvoi.send(null);   //envoi des données vers le fichier AjoutComPHP.php

    //pendant que les données sont envoyées on va afficher notre .gif de chargement.
    //Pour éviter que l'utilisateur ne clique sur quoi que ce soit en atteandant la fin du traitement, on cache toute la page en affichant notre div DivGlobalOverlay

    var MaFenetre = document.getElementById('DivGlobalOverlay');
    var overlay = document.getElementById('overlay');
    var Commandes = document.getElementById('Commandes');
    var MenuDroite = document.getElementById('MenuDroite');
    var ChevronMenuDroite = document.getElementById('ChevronMenuDroite');
    var IMGloader = document.createElement('img');

    //on affiche notre grande page noire
    MaFenetre.style.backgroundColor = 'rgba(0,0,0,0.9)';
    MaFenetre.style.display = 'flex';
    MaFenetre.style.flexDirection = 'column';
    MaFenetre.style.justifyContent = 'center';
    MaFenetre.style.alignItems = 'center';

    //on cache le reste
    MaFenetre.style.verticalAlign = 'middle';
    overlay.style.display = 'none';
    Commandes.style.display = 'none';
    MenuDroite.style.display = 'none';
    ChevronMenuDroite.style.display = 'none';

    //On rajoute notre petit gif
    IMGloader.src = 'images/loader.gif';
    IMGloader.id = 'IMGloader';
    IMGloader.position = 'absolute';

    MaFenetre.appendChild(IMGloader);


    /*On va attendre que le traitement soit terminé...  Lorsque le traitement est terminé on exécute les taches présentes dan sla fonction suivante*/
    xhrEnvoi.addEventListener('readystatechange', function() {
        if (xhrEnvoi.readyState === XMLHttpRequest.DONE) { // La constante DONE appartient à l'objet XMLHttpRequest, elle n'est pas globale

            var overlay = document.getElementById('overlay');
            var Commandes = document.getElementById('Commandes');
            var MenuDroite = document.getElementById('MenuDroite');
            var IMGaSUP = document.getElementById('IMGloader');
            var ChevronMenuDroite = document.getElementById('ChevronMenuDroite');
            var DivGlobalOverlay = document.getElementById('DivGlobalOverlay');

            // On supprime en premier lieu notre gif
            IMGaSUP.parentNode.removeChild(IMGaSUP);

            //On ré-affiche tous nos éléments
            overlay.style.display = 'flex';
            Commandes.style.display = 'flex';
            Commandes.style.position = 'fixed';
            MenuDroite.style.display = 'block';
            ChevronMenuDroite.style.display = 'flex';

            //On cache notre DivGlobalOverlay
            DivGlobalOverlay.style.backgroundColor = 'transparent';
            DivGlobalOverlay.style.display = 'flex';
            DivGlobalOverlay.style.flexDirection = 'row';
            DivGlobalOverlay.style.justifyContent = 'flex-end';
            DivGlobalOverlay.style.position = 'fixed';
            DivGlobalOverlay.style.zIndex = '1';

            //Si on a un message d'erreur renvoyé de la page AjoutComPHP.php, on l'affiche
            if (xhrEnvoi.responseText != '')
            {
                var responseErreur = JSON.parse(xhrEnvoi.responseText);             //je récupere mes echo du fichier LectureComPHP et la fonction JSON.parse soccupe de tout foutre en ordre dans un objet
                alert(responseErreur.MsgErreur);
            }
            //Sinon on vide notre formulaire pour éviter que ce qui a été saisi reste dedans
            else
            {                    
                var LePseudo = document.getElementsByName('pseudo');
                var LeComm = document.getElementsByName('Comm');
                LePseudo[0].value = '';
                LeComm[0].value = '';
            }

            // Une fois le commentaire publique envoyé je vais rafraichir les commentaire pour l'afficher directement. je dois donc dans un premier temps effacer ceux en cour avant d'exécuter ma fonction qui va se charger de tout ré-afficher. (si je ne suprime pas avant j'ai les commentaires en double)
            var DivDesCommentairesPublicsaSuprimer = document.getElementById('EmplacementCommentairePublic');   // Je suprime les commentaires public que l'lon a ajouté avant de passer à l'image suivante sinon ils restent affichés
            if(DivDesCommentairesPublicsaSuprimer)
            {
                DivDesCommentairesPublicsaSuprimer.parentNode.removeChild(DivDesCommentairesPublicsaSuprimer);
            }
            //On fait appel ensuite à notre fonction d'affichage des commentaires publiques pour tout ré-afficher. On passe en paramètre le nom de notre photo car on va en avoir besoin dans la fonction
            AffichageInfosTextuellesPhoto(NomPhotoSRC);                    //on exécute la fonction avec le nom de l'image en paramètre
        }
    });
    e.preventDefault();             // On empeche d'etre redirigé sur une autre page en cliquant sur le boutton envoyer
});

/*----------------FIN EVENEMENT de surveillance d'envoi de commentaires-------------------*/



/*-------- evênements surveillants le click sur les bouttons des commandes pour passer aux images suivantes et précédentes-------*/

var BoutonGauche = document.getElementById('Gauche');
var BoutonDroit = document.getElementById('Droite');

//on rajoute l'évênement sur le div de gauche
BoutonGauche.addEventListener('click', function() {
    var ProchainePhotoaAfficher = ProchainePhotoaAfficheraGauche;       //on stocke dans une variable locale l'ID de la photo à afficher à gauche (précédement calculé dans la fonction d'affichage de l'image displayImg et ensuite placé dans un objet)
    //console.log('objet récupéré?: ' + ProchainePhotoaAfficher);
    Refresh();                                                          //j'exécute ma fonction me permettant de virer les commentaires si il y en a. Ils seront ré-insérés si besoin lors de l'exécution de la fonction displayImg
    displayImg(ProchainePhotoaAfficher);                                //on exécute notre fonction d'affichage de l'image qui va se charger d'afficher l'image et tous les commentaires associés maintenant que notre champs est vierge
});

//on rajoute l'évênement sur le div de droite, même principe qu'au dessus
BoutonDroit.addEventListener('click', function() {
    var ProchainePhotoaAfficher = ProchainePhotoaAfficheraDroite;
    //console.log('objet récupéré?: ' + ProchainePhotoaAfficher);
    Refresh();                                                          
    displayImg(ProchainePhotoaAfficher);                            
});


/*-------- FIN EVENEMENTS surveillance click sur les pannaux de commande d'affichage img suivante et précédente-----*/




/*------------------------- évênement surveillant le focus du textarea ----------------------*/
/*En effet, on souhaite bloquer le fait de passer aux images suivantes et précédentes en utilisant les fleches de directions lorsque nous sommes en train de saisir des infos dans les champs du formulaire (textarea et input)*/


//création de variable globale et d'évenements testant le focus sur la zone de commentaires pour s'assurer que lorsque cette derniere est focusée l'appuie sur les fleches de direction ne permette pas la navigation sur les photos
var GlobFocus = {
            oui: '0'
};
var TestFocusCom = document.getElementById('TextAreaCom');
//lorsque l'on a le focus, la variable globale GlobFocus2 vaut 1
TestFocusCom.addEventListener('focus', function() {
    var GlobFocus2 = GlobFocus;
    GlobFocus2.oui = '1';
    if(IDmaTempo.ID || IDmaTempo.Status)                                    //Si j'avais un diapo de lancé ou qu'il y en a eu un puis stoppé par la barre d'espace....
    {
        clearInterval(IDmaTempo.ID);                                        //On l'arrete
        IDmaTempo.Status = '';                                              //et on empeche de le relancer si l'on appuie sur la barre d'espace
        IDmaTempo.ID = '';                                                  //on ré-initialise nos variables
        IndicationPause();                                                  //Je lance ma fonction pour afficher le logo PAUSE lors de l'aapuie sur le boutton
        TransformStopToLecture ()                                           //je remet mon boutton en mode lecture et je remet les bons évenements dessus grace a ma fonction
    }
});
//Si on a perd le focus, GlobFocus2 repasse à 0
TestFocusCom.addEventListener('blur', function() {
    var GlobFocus2 = GlobFocus;
    GlobFocus2.oui = '0';
});

var TestFocusPseudo = document.getElementById('pseudo');
TestFocusPseudo.addEventListener('focus', function() {
    var GlobFocus2 = GlobFocus;
    GlobFocus2.oui = '1';
    if(IDmaTempo.ID || IDmaTempo.Status)                                    //Si j'avais un diapo de lancé ou qu'il y en a eu un puis stoppé par la barre d'espace....
    {
        clearInterval(IDmaTempo.ID);                                        //On l'arrete
        IDmaTempo.Status = '';                                              //et on empeche de le relancer si l'on appuie sur la barre d'espace
        IDmaTempo.ID = '';                                                  //on ré-initialise nos variables
        IndicationPause();                                                  //Je lance ma fonction pour afficher le logo PAUSE lors de l'aapuie sur le boutton
        TransformStopToLecture ()                                           //je remet mon boutton en mode lecture et je remet les bons évenements dessus grace a ma fonction
    }
});
TestFocusPseudo.addEventListener('blur', function() {
    var GlobFocus2 = GlobFocus;
    GlobFocus2.oui = '0';
});



/*-------------- FIN EVENEMENT de vérif du focus sur Textarea et input---------------*/



/*-----------------évênement permettant de gérer l'action lors de l'appui sur les fleches de direction----------------------*/

//On s'occupe de la fleche de gauche
document.addEventListener('keyup', function(e) {
    if(overlay.style.display == 'flex')
    {
        var ProchainePhotoaAfficher = ProchainePhotoaAfficheraGauche;   //cette variable est issue de notre fonction d'affichage de l'image dans laquelle on avait calculer les ID image suivante et précédente

        if (e.keyCode == 37 && GlobFocus.oui=='0')                      //on met l'évênement uniquement si le textarea et le input n'ont pas le focus
        {
            Refresh();                                                  //on exécute notre fonction qui rafraichi les commentaires
            displayImg(ProchainePhotoaAfficher);                        //on exécute notre fonction qui affiche l'image en lui passant en paramètre le line de la prochaine photo à afficher
        }
    }
});
//même principe que ci-dessus
document.addEventListener('keyup', function(e) {
    if(overlay.style.display == 'flex')
    {
        var ProchainePhotoaAfficher = ProchainePhotoaAfficheraDroite;
        if (e.keyCode == 39 && GlobFocus.oui=='0')
        {
            Refresh();
            displayImg(ProchainePhotoaAfficher);
        }
    }
});

/*-------------- FIN EVENEMENT de surveillance de l'appuie sur les touches de direction---------------*/



/*-------------------Evenements de DIAPORAMA----------------------*/

/*Notre variable globale qui va nous permettre de stocker l'identifiant de l'action temporelle lancée (pour pouvoir l'arreter plus tard dans une autre fonction), la vitesse de défillement si cette derniere est modifiée (pour pouvoir la conserver au moment ou l'on relance le diapo), le status actuel (diapo en cours ou pas)*/
var IDmaTempo = {ID: '', Vitesse: '', Status: ''};

/*Une premiere fonction qui va me permettre de remplacer le boutton LECTURE en boutton STOP lorsqu'il y aura lieu et de remettre les bons observatuers d'evenement sur le nouveau boutton*/
function TransformLectureToStop () {

    var IMGBouttonLecStop = document.getElementById('IMGBouttonLecStop');
    IMGBouttonLecStop.parentNode.removeChild(IMGBouttonLecStop);

    var DivBouttonLecStop = document.getElementById('DivBouttonLecStop');
    var IMGBouttonLecStop = document.createElement('img');
    IMGBouttonLecStop.src = 'images/Pause.png';
    IMGBouttonLecStop.id = 'IMGBouttonLecStop';
    DivBouttonLecStop.appendChild(IMGBouttonLecStop);
    
    // Lors de l'appui sur le boutton STOP
    var IMGBouttonLecStop = document.getElementById('IMGBouttonLecStop');
    IMGBouttonLecStop.addEventListener('click', function() {

        console.log('j\ai cliqué');
        //On remet notre evenement d'arret + remplacement du boutton en LECTURE
        if(IDmaTempo.Status == '1')
        {
            console.log('Arret du diapo');
            IDmaTempo.Status = '0';
            clearInterval(IDmaTempo.ID);
            IndicationPause();                                                  //Je lance ma fonction pour afficher le logo PAUSE lors de l'aapuie sur le boutton
            TransformStopToLecture();
        }
    });
}

/*Meme principe qu'au dessus sauf que cette fois ci on remplace le boutton STOP en LECTURE*/
function TransformStopToLecture () {
    
    var IMGBouttonLecStop = document.getElementById('IMGBouttonLecStop');
    IMGBouttonLecStop.parentNode.removeChild(IMGBouttonLecStop);
    
    var DivBouttonLecStop = document.getElementById('DivBouttonLecStop');
    var IMGBouttonLecStop = document.createElement('img');
    IMGBouttonLecStop.src = 'images/Lecture.png';
    IMGBouttonLecStop.id = 'IMGBouttonLecStop';
    DivBouttonLecStop.appendChild(IMGBouttonLecStop);
    
    
    // Appui sur le boutton LECTURE
    var IMGBouttonLecStop = document.getElementById('IMGBouttonLecStop');
    IMGBouttonLecStop.addEventListener('click', function() {

        console.log('j\ai cliqué');
        //Si on est dans le cas ou c'est la premiere fois qu'on lance le diapo, on initialise la vitesse à 2000
        if(IDmaTempo.Status == '' && IDmaTempo.ID == '')
        {
            console.log('Diapo lancée - vitesse 2000');
            IDmaTempo.Status = '1';
            IDmaTempo.Vitesse = 2000;
            IDmaTempo.ID = MaTempo(2000);
            IndicationPlay('images/PlayDiapo.png', 'IMGPlayDiapo');             //Je lance ma fonction pour afficher le logo lecture lors du lancement du diapo
            TransformLectureToStop();                                           //et on remplace le boutton
        }
        //Sinon, c'est qu'on a déjà utilisé les autres boutons de vitesse donc on relance avec la vitesse précédement choisie.
        else
        {
            if(IDmaTempo.ID)
            {
                console.log('je supprime l\'ancien diapo...')
                clearInterval(IDmaTempo.ID);
            }
            console.log('Diapo lancée vitesse: ' + IDmaTempo.Vitesse);
            IDmaTempo.Status = '1';
            IDmaTempo.ID = MaTempo(IDmaTempo.Vitesse);
            IndicationPlay('images/PlayDiapo.png', 'IMGPlayDiapo');             //Je lance ma fonction pour afficher le logo lecture lors du lancement du diapo
            TransformLectureToStop();                                           //et on remplace le boutton
        }
    });
}



/*Cette fonction permet d'afficher brievement le logo PAUSE lorsque l'on appuie sur le boutton PAUSE - meme principe que ci-dessus*/
function IndicationPause() {
    
    /*Tout d'abord on crée notre image que l'on insèrera au centre du pannau de commandes*/
    var Centre = document.getElementById('Centre');
    var IMGPauseDiapo = document.createElement('img');
    IMGPauseDiapo.src = 'images/PauseDiapo.png';
    IMGPauseDiapo.id = 'IMGPauseDiapo';
    IMGPauseDiapo.style.width = '100%';
    IMGPauseDiapo.style.opacity = '0.6';                                         //je pars avec une opacité de moitié dès le début car c'est pas très beau si l'icone est très blafarde
    IMGPauseDiapo.style.transitionProperty = 'opacity';                          //On utilise une transition sur l'opacité (on n epeut pas le faire sur la propriété display)
    IMGPauseDiapo.style.transitionDuration = '1s';
    IMGPauseDiapo.style.display = 'block';
    Centre.appendChild(IMGPauseDiapo);

    /*Afin de pouvoir lancer ma transition j'ai besoin d'un evenement déclencheur: une tempo de 100ms par exemeple*/
    setTimeout(function() {
        var PauseDiapo = document.getElementById('IMGPauseDiapo');
        PauseDiapo.style.opacity = '0';            
    }, 100);
    /*Des que l'évènement est terminé, je vire mon image (au bout donc du temps de ma transition + celui que l'on a attendu pour déclencher la transistion)*/
    setTimeout(function() {
        var PauseDiapo = document.getElementById('IMGPauseDiapo');
        PauseDiapo.parentNode.removeChild(PauseDiapo);  //On le vire
    }, 1100);
}

/*Cette fonction permet d'afficher brievement le logo de lecture lorsque l'on appuie sur le boutton play (soit le play normal soit le 3sec, 5sec... selon les arguments que l'on passe à la fonction*/
function IndicationPlay(SRCimage, IDimage) {
    
    /*Tout d'abord on crée notre image que l'on insèrera au centre du pannau de commandes*/
    var Centre = document.getElementById('Centre');
    var IMGPlay = document.createElement('img');
    IMGPlay.src = SRCimage;
    IMGPlay.id = IDimage;
    IMGPlay.style.width = '100%';
    IMGPlay.style.opacity = '0.6';                                         //je pars avec une opacité de moitié dès le début car c'est pas très beau si l'icone est très blafarde
    IMGPlay.style.transitionProperty = 'opacity';                          //On utilise une transition sur l'opacité (on n epeut pas le faire sur la propriété display)
    IMGPlay.style.transitionDuration = '1s';
    IMGPlay.style.display = 'block';
    Centre.appendChild(IMGPlay);

    /*Afin de pouvoir lancer ma transition j'ai besoin d'un evenement déclencheur: une tempo de 100ms par exemeple*/
    /*Je découpe cela de cette manière pour assurer la compatibilité IE10*/
    function FonctionOpacity(IDMonimage) {
        var Play = document.getElementById(IDMonimage);
        Play.style.opacity = '0'; 
    }
    setTimeout(function() {
        FonctionOpacity(IDimage);        
    }, 100);
    
    /*Des que l'évènement est terminé, je vire mon image (au bout donc du temps de ma transition + celui que l'on a attendu pour déclencher la transistion)*/
    function FonctionSuppressionImage(IDMonimage) {
        var Play = document.getElementById(IDMonimage);
        Play.parentNode.removeChild(Play);  //On le vire
    }
    setTimeout(function() {
        FonctionSuppressionImage(IDimage);
    }, 1100);
}


/*Notre action temporelle dont on stocke le résultat (l'identifiant) dans une variable - Il s'agit d'une closure*/
var MaTempo = function Tempo(vitesse) {

    var FonctionSetInterval = setInterval(function() {                          //la fonction de temporisation

        var ProchainePhotoaAfficher = ProchainePhotoaAfficheraDroite;   

        console.log('j\exécute les fonctions Refresh et DisplayIMG')
        Refresh();
        displayImg(ProchainePhotoaAfficher);
        }, vitesse);                                                            //C'est ici que l'on récupère la valeur de l'argument passé à la fonction (le temps d'interval pour effectuer les actions)

        return FonctionSetInterval;                                             //on retourne l'ID de l'action temporelle
}


// Appui sur le boutton LECTURE au tout départ
var IMGBouttonLecStop = document.getElementById('IMGBouttonLecStop');
IMGBouttonLecStop.addEventListener('click', function() {
    
    console.log('j\ai cliqué');

    if(IDmaTempo.Status == '' && IDmaTempo.ID == '')
    {
        console.log('Diapo lancée - vitesse 2000');
        IDmaTempo.Status = '1';                                                 //On indique que le diaporama est désormais en cours
        IDmaTempo.Vitesse = 2000;                                               //Premiere fois que l'on clique sur LECTURE: on décide d'afficher les photos toutes les 2sec - On le garde en mémoire au cas ou on fasse un PAUSE/REPRISE pour repartir à cette vitesse
        IDmaTempo.ID = MaTempo(2000);                                           //Lors de l'appel de la fonction, on récupère ce qu'elle nous a retourné (son ID) que l'on stocke dans notre variable globale - Ici on passe en paramètre à la fonction la vitesse de défilement
        
        IndicationPlay('images/PlayDiapo.png', 'IMGPlayDiapo');                 //Je lance ma fonction pour afficher le logo lecture lors du lancement du diapo
        TransformLectureToStop();                                               //On va remplacer notre boutton LECTURE en STOP grace à notre fonction
    }   
});


// Appui sur le boutton LECTURE 3sec                                            //Meme principe que ci-dessus sauf qu'on le fait pour le boutton 3sec.
var Boutton3sec = document.getElementById('Boutton3sec');
Boutton3sec.addEventListener('click', function() {

    if(IDmaTempo.ID)    //Si on a déjà un diaporama en cours
    {
        console.log('je supprime l\'ancien diapo...')
        clearInterval(IDmaTempo.ID);                                            //On va arreter celui en cours avant d'en relancer un nouveau. Sinon on aura deux actions temporelles en cours et les images ne vont pas défiler à la vitesse que l'on souhaite
    }
    console.log('Diapo lancé');
    IDmaTempo.Status = '1';
    IDmaTempo.Vitesse = 3000;
    IDmaTempo.ID = MaTempo(3000);
    IndicationPlay('images/Play3sec.png', 'Play3sec');
    TransformLectureToStop();
});

// Appui sur le boutton LECTURE 5sec
var Boutton5sec = document.getElementById('Boutton5sec');
Boutton5sec.addEventListener('click', function() {

    if(IDmaTempo.ID)
    {
        console.log('je supprime l\'ancien diapo...')
        clearInterval(IDmaTempo.ID);
    }
    console.log('Diapo lancé');
    IDmaTempo.Status = '1';
    IDmaTempo.Vitesse = 5000;
    IDmaTempo.ID = MaTempo(5000);
    IndicationPlay('images/Play5sec.png', 'Play5sec');
    TransformLectureToStop();
});

 // Appui sur le boutton LECTURE 8sec
var Boutton8sec = document.getElementById('Boutton8sec');
Boutton8sec.addEventListener('click', function() {

    if(IDmaTempo.ID)
    {
        console.log('je supprime l\'ancien diapo...')
        clearInterval(IDmaTempo.ID);
    }
    console.log('Diapo lancé');
    IDmaTempo.Status = '1';
    IDmaTempo.Vitesse = 8000;
    IDmaTempo.ID = MaTempo(8000);
    IndicationPlay('images/Play8sec.png', 'Play8sec');
    TransformLectureToStop();
});


// Appui sur la barre d'espace                                                  //Memes principes que plus haut mais cette fois ci on gère les évènements de la barre d'espace.
document.addEventListener('keydown', function(e) {
    if (e.keyCode == 32 && GlobFocus.oui=='0')                                  //On met l'évênement uniquement si on a pas le focus sur le textarea ou le input du pseudo
    {
        e.preventDefault();                                                     //cette ligne permet d'éviter que l'aapuie sur la barre d'espace ne fasse descendre l'ascenseur de la page des miniatures en arrière plan (si on est en haut et qu'il y a lieu de descendre) - C'est pas indispensable mais ca évite de voir bouger un truc derrière notre visualisation de photos si jamais
        if(IDmaTempo.Status == '1')                       
        {
            console.log('Arret du diapo par la touche d\'espace');
            IDmaTempo.Status = '0';
            console.log(IDmaTempo.Status);
            clearInterval(IDmaTempo.ID);
            IndicationPause();                                                  //Je lance ma fonction pour afficher le logo PAUSE lors de l'aapuie sur le boutton
            TransformStopToLecture();
        }
        else if (IDmaTempo.Status == '0')                 
        {
            console.log('lancement du diapo par la barre vitesse: ' + IDmaTempo.Vitesse)
            IDmaTempo.Status = '1';
            IDmaTempo.ID = MaTempo(IDmaTempo.Vitesse);
            IndicationPlay('images/PlayDiapo.png', 'IMGPlayDiapo');             //Je lance ma fonction pour afficher le logo lecture lors du lancement du diapo
            TransformLectureToStop();
        }
    }
});


/*-------------------FIN des evenements de DIAPORAMA-------------------------*/



/*-------------- 2évênements permettants de quitter la visualisation des photos---------------*/

// lors de l'appuie sur la touche echap
document.addEventListener('keydown', function(e) {
    if (e.keyCode == 27)
    {
        Raz();                                                              //On appelle notre fonction qui s'occupe de ré-initialiser les attributs des éléments
    }
});

// lors du click sur le boutton en bas du menu de droite 
var DivRetour = document.getElementById('DivRetour');
DivRetour.addEventListener('click', function() {
    Raz();                                                                  //comme ci-dessus, fonction Raz
});

/*--------------FIN évênements permettant de quitter la visualisation des photos---------------*/


/*------------------------------------------------------------------------*/
/*------------------------FIN DES EVENEMENTS------------------------------*/
/*------------------------------------------------------------------------*/



/*------------------------------------------------------------------------*/
/*----------------------------ANIMATIONS----------------------------------*/
/*------------------------------------------------------------------------*/


/*------------Animation Affichant et cachant le menu de droite------------*/

var ChevronPourCliquer = document.getElementById('DivTopChevronMenuDroite');

ChevronPourCliquer.addEventListener('click', function() {
    var overlay = document.getElementById('overlay');
    var Commandes = document.getElementById('Commandes');
    var EmplacementCommentairePublic = document.getElementById('EmplacementCommentairePublic');

    var DivTopChevronMenuDroite = document.getElementById('DivTopChevronMenuDroite');
    var DivBotChevronMenuDroite = document.getElementById('DivBotChevronMenuDroite');

    var ChevronMenuDroite = document.getElementById('ChevronMenuDroite');

    var ImageChevronMenuDroite = DivTopChevronMenuDroite.firstChild;        
        ImageChevronMenuDroite = ImageChevronMenuDroite.firstChild;
        ImageChevronMenuDroite = ImageChevronMenuDroite.firstChild;

    //Dans le cas où l'on détecte que le menu de droite est masqué sur l'affichage actuel...
    if (overlay.offsetWidth / BlockdeDroite.offsetWidth > '50')
    {
        //On va l'afficher.... et donc initialiser tous les éléments de la page comme il se doit
        BlockdeDroite.style.width = '23%';
        overlay.style.width = '75%';
        Commandes.style.width = '75%';
        BlockdeDroite.style.backgroundColor = 'rgba(9,9,9,0.9)';
        ChevronMenuDroite.style.backgroundColor = 'rgba(9,9,9,0.9)';                
        DivTopChevronMenuDroite.style.backgroundColor = 'transparent';          //Je le met en transparent sinon comme le div de fond est déjà en noir transparent si je met la même couleur, cela donne un résultat assombri
        DivBotChevronMenuDroite.style.backgroundColor = 'transparent';
        ImageChevronMenuDroite.src = 'images/ChevronMenuDroiteVersDroite.png';

        /*On met un petit timer pour régler un problème d'affichage des éléments lors du déploiement du menu.
         *En somme, on attend que l'animation soit terminée pour définir les paramètres des éléments suivants:
         */
        setTimeout(function() {
            var DivBasMenuDroite = document.getElementById('DivBasMenuDroite');
            var MonCommentaire = document.getElementById('MonCommentaire');                
            MonCommentaire.style.height = 'auto';                           //ces paramètres permettent d'afficher des ascensseur en conséquences. selon la taille du commentaire perso et celle des commentaires publiques
            MonCommentaire.style.overflow = 'auto';                         
            DivBasMenuDroite.style.whiteSpace = 'normal';
            if (EmplacementCommentairePublic)
            {
                EmplacementCommentairePublic.style.height = 'auto';
                EmplacementCommentairePublic.style.overflow = 'auto';
            }
        }, 1000);
    }
    //Si on a détecté que le menu était déjà affiché, alors on va le cacher.... et donc initialiser tous les éléments en ce sens
    else
    {
        var DivBasMenuDroite = document.getElementById('DivBasMenuDroite');
        var MonCommentaire = document.getElementById('MonCommentaire');
        MonCommentaire.style.height = MonCommentaire.offsetHeight + 'px';
        MonCommentaire.style.overflow = 'hidden';

        if (EmplacementCommentairePublic)
        {
            EmplacementCommentairePublic.style.height = EmplacementCommentairePublic.offsetHeight + 'px';
            EmplacementCommentairePublic.style.overflow = 'hidden';
        }
        DivBasMenuDroite.style.whiteSpace = 'nowrap';
        BlockdeDroite.style.width = '0%';

        Commandes.style.width = '98%';
        overlay.style.width = '98%';                
        ImageChevronMenuDroite.src = 'images/ChevronMenuDroiteVersGauche.png';
        ChevronMenuDroite.style.backgroundColor = 'black';
        DivTopChevronMenuDroite.style.backgroundColor = 'black';
        DivBotChevronMenuDroite.style.backgroundColor = 'black';
    }
});

/*------------------------------------------------------------------------*/
/*--------------------------FIN ANIMATIONS--------------------------------*/
/*------------------------------------------------------------------------*/

var ChoixAlbumIndonesie = document.getElementById('DivChoixIndonesie');
var ChoixAlbumTest = document.getElementById('DivChoixTest');
var ChoixAlbumMelbourne = document.getElementById('DivChoixMelbourne');
var ChoixAlbumAnimaux = document.getElementById('DivChoixAnimaux');


function ChoixAlbum (ChoixAlbum, DivAlbum) {
    ChoixAlbum.addEventListener('click', function() {
        
        /*--------------------------DEBUT AFFICHAGE ET SUPPRESSION DES ALBUMS--------------------------------*/
        
        //console.log('---------DEBUT fonction--------Album: ' + ChoixAlbum.id + '  ' + DivAlbum);
        //console.log('Nombre d\'elements a cacher: ' + DivAlbumaCacher.length);
        
        var LeBody = document.getElementsByTagName("body")[0];
        var MonHTML = document.getElementById('MonHTML');
        
        if (DivAlbumaCacher != '')
        {
            console.log('Etape 1: Div à cacher: ' + DivAlbumaCacher[0].id);
            
            var DivMonAlbumaCacher = document.getElementById(DivAlbumaCacher[0].id);    //je cible mon Album a cacher dans le DOM
           
            //pour eviter un bug d'affichage lorsque je clique 2 fois sur le meme album, je vais initialiser correctement la postition
            var ElementReferencePosition = document.getElementById('referenceAbsolue').offsetLeft;      //je récupère le placement depuis la guahce grace a un petit p que j'ai mis en absolute exprés pour récupérer la valeur de l'offsetLeft

            var ElementReferenceLargeur = document.getElementById('DivChoixAlbum').offsetWidth;        //pour la largeur je récupère celle du div au dessus 
            ElementReferenceLargeur = ElementReferenceLargeur - 11;             //je ne sais pas pourquoi je dois retirer 11 pixels pour que ce soit nikel. Sans doute à cause des marges ou paading.

            var NewoffsetTop = DivMonAlbumaCacher.offsetTop;                    //Comme je vais devoir passer mon élément en absolute pour que mes 2 div puissents etre sur la meme ligne lorsqu'ils glissents de gauche à droite, si je ne spécifie pas la valeur de l'offsetTop sur l'élément passé en absolute, il se retrouve tout en haut de la page.
            
            LeBody.style.overflow = 'hidden';
            MonHTML.style.overflow = 'hidden';
            
            DivMonAlbumaCacher.style.position = 'absolute';                     //je passe donc l'élément en absolute comme expliqué ci dessus
            //console.log('offset top: ' + NewoffsetTop);
            DivMonAlbumaCacher.style.top = NewoffsetTop + 'px';
            
            DivMonAlbumaCacher.style.width = ElementReferenceLargeur + 'px';    //deux paramètres pour éviter les bugs d'affichages            
            DivMonAlbumaCacher.style.left = ElementReferencePosition + 'px';

            DivMonAlbumaCacher.style.animation = 'animationRetireAlbum 2s';     //j'éxécute mon animation
            
            /*Je crée cette fonction qui sera appelée dans la mise en place de l'évênement pour pouvoir supprimer l'évênement en question. Si je créais l'évênement directement avec une fonction anonyme, je ne pourrais pas le supprimer ensuite avec removeEventListener*/
            var fonctionSupAlbum = function(e) {
   
                // console.log('e: ' + e.target);
                //ces instructions seront réalisée lorsque l'évênement sera terminé. Il s'agit de ré-initialiser les valeurs du div de l'album pour le cacher et le remettre à gauche (tel qu'il est défini au chargement de la page au départ)
                
                LeBody.style.overflow = 'initial';
                MonHTML.style.overflow = 'initial';
                
                e.target.style.width = '100%';                                  
                e.target.style.top = '0';
                e.target.style.display = 'none';
                e.target.style.left = '-2000px';
                e.target.style.position = 'relative';
                
                //console.log('Offset fin: ' + e.target.offsetLeft);
                //console.log('fini retir: ' +  e.target.id);

                DivMonAlbumaCacher.removeEventListener('animationend', fonctionSupAlbum);        //je supprime mon evênement de détection de fin d'animation       
            }
            
            DivMonAlbumaCacher.addEventListener('animationend', fonctionSupAlbum);      //je met en place un évênement qui détectera la fin de l'animation. lorsque l'animation est finie, j'éxécute la fonction fonctionSupAlbum;
            
            //Je ré-initialise mes tableaux avant de les remplir avec les nouveaux liens des photos
            toutesMesPhotos = [];
            TousMesLiens = [];
        }
    
        //Je m'occupe de l'ajout de l'album.
        var DivMonAlbum = document.getElementById(DivAlbum);
        var DivCacheTemporairement = document.getElementById('DivCacheTemporairement');
    
        DivMonAlbum.style.display = "flex";     //avant de commencer à le faire glisser je l'affiche.
        LeBody.style.overflow = 'hidden';
        MonHTML.style.overflow = 'hidden';
        
        //ces conditions me permettent d'empecher d'appliquer le zindex à 1 lorsque je sélectionne l'album sur lequel je me trouve déjà - Ce zindex permet d'empecher toute action sur les boutons pendant l'animation
        if (DivAlbumaCacher != '')
        {
            if (DivAlbumaCacher[0].id != DivAlbum)
            {
                DivCacheTemporairement.style.zIndex = '1';
            }
        }
        if (DivAlbumaCacher == '')
        {
            DivCacheTemporairement.style.zIndex = '1';
        }
        

        DivMonAlbum.style.animation = 'animationAjouteAlbum 2s';                //j'éxécute mon animation
        //console.log('j\'ajoute une animation: ' + DivMonAlbum.id);

           var fonctionAjoutAlbum = function(e) {                               //comme ci-dessus meme principe pour la création de l'évênement avec une fonction NON anonyme

               //Une fois l'évênement terminé...
               
               e.target.style.left = '0px';                                     //je fige mon album
               DivCacheTemporairement.style.zIndex = '-2';
               console.log('fini ajout: ' +  e.target.id);
               LeBody.style.overflow = 'initial';
               MonHTML.style.overflow = 'initial';
               
               DivMonAlbum.removeEventListener('animationend', fonctionAjoutAlbum);     //je supprime mon evênement
           }
           
            DivMonAlbum.addEventListener('animationend', fonctionAjoutAlbum);   //ajout de l'évênement par appel de la fonction
            console.log('on ajoute');
               
        /*--------------------------FIN AFFICHAGE ET SUPPRESSION DES ALBUMS--------------------------------*/

       
        //console.log('le div est: ' + DivMonAlbum.id);
        toutesMesPhotos = DivMonAlbum.getElementsByTagName('div');


        var lienaEnvoyer;
        for (i=0; i<toutesMesPhotos.length; i++)
            {
                lienaEnvoyer = toutesMesPhotos[i].style.backgroundImage;     
                lienaEnvoyer = lienaEnvoyer.substring(5, lienaEnvoyer.lastIndexOf('"'));
                var splitted = lienaEnvoyer.split('miniatures/');                       //je coupe ma chaine en deux morceaux que je place respectueusement dans un tableau et je supprime ce qu'il y a entre guillements (miniatures/)
                lienaEnvoyer = splitted[0] + splitted[1];                               //je re-constitue mon lien en concaténant les 2 éléments du tableau
                TousMesLiens[i] = lienaEnvoyer;
                //console.log(lienaEnvoyer);
            }
            
        /*--------------- Evenement permetant de désactiver l'ouverture de l'image dans une nouvelle fenetre lorsque l'on clique sur la miniature ------------------*/

        for (var i = 0; i < toutesMesPhotos.length; i++) {                                  //cette variable est déclarée est calculée au début.
            //console.log(toutesMesPhotos[i]);  
            toutesMesPhotos[i].addEventListener('click', function(e) {              //Cette variable est déclarée est calculée au début et contient les liens de toutes les photos
                e.preventDefault();                                                 //On bloque la redirection 
                var lienaEnvoyer = e.currentTarget.style.backgroundImage;           //On prépare une variable contenant le nom du lien de l'image à afficher. c'est un traitement sur la chaine de caractère pour enlever quelques caractères dérangeants
                //currentTarget est utilisé pour cibler le lien et non l'image On va donc devoir un peu modifier cette variable pour l'utiliser lors de l'appel de notre fonction d'affichage
                lienaEnvoyer = lienaEnvoyer.substring(5, lienaEnvoyer.lastIndexOf('"'));
                var splitted = lienaEnvoyer.split('miniatures/');                       //je coupe ma chaine en deux morceaux que je place respectueusement dans un tableau et je supprime ce qu'il y a entre guillements (miniatures/)
                lienaEnvoyer = splitted[0] + splitted[1];                               //je re-constitue mon lien en concaténant les 2 éléments du tableau
                //console.log('lien a envoyer: ' + lienaEnvoyer);
                //console.log('premiere partie: ' + splitted[0]);
                //console.log('deuxieme partie: ' + splitted[1]);
                //console.log(e.currentTarget.style.backgroundImage); 

                displayImg(lienaEnvoyer);                                           //On en profite pour appeller notre fonction permettant d'afficher notre image
            });
        }
        
        //console.log('div mon album: ' + DivMonAlbum);
        DivAlbumaCacher[0] = DivMonAlbum;                                  //je stocke en variable globale les infos de l'album actuel pour pouvoir les modifier si on sélectionne un autre album
        console.log('--------FIN Fonction ---------il y aura un div à cacher: ' + DivAlbumaCacher[0].id);          
    });
}


//ChoixAlbum(ChoixAlbumIndonesie, 'DivAlbumIndonesie');
//ChoixAlbum(ChoixAlbumTest, 'DivAlbumTest');
ChoixAlbum(ChoixAlbumAnimaux, 'DivAlbumAnimaux');
ChoixAlbum(ChoixAlbumMelbourne, 'DivAlbumMelbourne');
