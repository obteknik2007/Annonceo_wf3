<?php
session_start();

//Connextion à la bdd 'annonceo'
$pdo = new PDO('mysql:host=localhost;dbname=annonceo','root','',array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//racine du site
define('RACINE_SITE','/annonceo/');

//init variable de contenu
$contenu = '';

//inclusion du fichier de fonctions
require_once('functions.php');
?>