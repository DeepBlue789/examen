<?php
//--------------------------------------------- Connexion BDD
$serveur = "localhost";
$base = "root";
$user = "";
$pass = "testing2";

//Requête de connexion
$mysqli = new mysqli($serveur, $base, $user, $pass);
//Message d'erreur
if ($mysqli->connect_error) die('Un problème est survenu lors de la tentative de connexion à la BDD : ' . $mysqli->connect_error);
// Affichage en UTF8
$mysqli->set_charset("utf8"); 
