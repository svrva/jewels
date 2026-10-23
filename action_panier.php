<?php
include 'CNX.php';

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($action == 'ajouter' && $id > 0) {
    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id]++;
    } else {
        $_SESSION['panier'][$id] = 1;
    }
    header('Location: panier.php');
    exit();
}

if ($action == 'supprimer' && $id > 0) {
    if (isset($_SESSION['panier'][$id])) {
        unset($_SESSION['panier'][$id]);
    }
    header('Location: panier.php');
    exit();
}

if ($action == 'vider') {
    $_SESSION['panier'] = array();
    header('Location: panier.php');
    exit();
}

header('Location: index.php');
exit();
?>