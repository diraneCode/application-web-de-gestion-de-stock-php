<?php

require './../class/Database.php';

$db = Database::Connect();

$quantite = $_GET['quantite'];
$id = $_GET['idStock'];
$re = $db->query("UPDATE stock SET quantite_stock = '$quantite' WHERE id = '$id'");
header('location: ./../index.php?p=stock');  