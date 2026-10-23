<?php
include 'CNX.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}
if (isset($_GET['id'])) {
    $id_delete = intval($_GET['id']);
    
    $req = $bdd->prepare("DELETE FROM produits WHERE id = ?");
    $req->execute([$id_delete]);
}

header('Location: admin.php');
exit();
?>