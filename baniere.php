<?php
//session_start();
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

$date = date("d-m-Y");
$heure=date("H");
$heure=$heure+9;
$minute=date("i");
if ($heure== 24)
{
    $heure = 00;
}
if ($heure== 25)
{
    $heure = 01;
}
if ($heure== 26)
{
    $heure = 02;
}
if ($heure== 27)
{
    $heure = 03;
}
if ($heure== 28)
{
    $heure = 04;
}
if ($heure== 29)
{
    $heure = 05;
}
if ($heure== 30)
{
    $heure = 06;
}
if ($heure== 31)
{
    $heure = 07;
}
if ($heure== 32)
{
    $heure = 08;
}
if ($heure== 33)
{
    $heure = 09;
}
if ($heure== 34)
{
    $heure = 10;
}
if ($heure== 35)
{
    $heure = 11;
}


?>
<table id="TabPrincipal" cellspacing="0" cellpadding="0">
    <tr class="Baniere">
            <td colspan="2">        
            <div id="date">        
                <?php
                echo "Nous sommes le";
                ?>
                <b>
                <?php
                echo $date;
                ?>
                </b>
                <?php
                echo " et il est";
                ?>
                <b>
                <?php
                echo $heure . "h" . $minute;
                ?>
                </b>
                <?php
                echo "à Melbourne";
                ?>
                <!--
                <td bgcolor=""></td>
                -->
            </div>
            </td>
    </tr>
    
 
    
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