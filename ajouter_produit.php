<?php
include 'CNX.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $prix = intval($_POST['prix']);
    $image = htmlspecialchars($_POST['image']); 
    $categorie = htmlspecialchars($_POST['categorie']);

    if (!empty($nom) && $prix > 0 && !empty($image)) {
        $req = $bdd->prepare("INSERT INTO produits (nom, prix, image, categorie) VALUES (?, ?, ?, ?)");
        $req->execute([$nom, $prix, $image, $categorie]);
        
        header('Location: admin.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Bijou</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif; 
        background: #FAF8F3; padding: 3rem;
     }
        .form-box { max-width: 500px;
         margin: 0 auto; 
         background: white;
        padding: 2rem; 
        border-radius: 8px;
         border: 1px solid #E8E0D0;
         }
        h2 { 
        margin-bottom: 1.5rem;
         color: #1A1008; }
        label { 
            display: block;
             margin-bottom: 0.4rem; 
             font-size: 0.9rem; 
             color: #5f4d3e; }

        input, select { width: 100%;
         padding: 0.8rem; 
         margin-bottom: 1.2rem;
          border: 1px solid #E8E0D0;
           border-radius: 4px; 
           box-sizing: border-box; }
        .btn-group { display: flex;
         gap: 1rem; }
        button, .btn-back { flex: 1;
         padding: 0.8rem; 
         text-align: center;
          border-radius: 4px;
           text-decoration: none;
            font-size: 1rem;
             cursor: pointer; 
             border: none; }
        button { background: #5f4d3e;
         color: #D4AF37; }
        button:hover { background: #B8860B;
         color: #fff; }
        .btn-back { background: #7A6E60; 
        color: white; }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Ajouter un nouveau bijou</h2>
        <form action="ajouter_produit.php" method="POST">
            <label>Nom du bijou</label>
            <input type="text" name="nom" required placeholder="Ex: Collier Diamant Pur">

            <label>Prix (Chiffre unique en DHS)</label>
            <input type="number" name="prix" required placeholder="Ex: 180">

            <label>Nom exact du fichier image</label>
            <input type="text" name="image" required placeholder="Ex: bijou6.jpg">

            <label>Catégorie</label>
            <select name="categorie">
                <option value="bague">Bague</option>
                <option value="collier">Collier</option>
                <option value="bracelet">Bracelet</option>
                <option value="boucle">boucle d'oreille</option>
            </select>

            <div class="btn-group">
                <a href="admin.php" class="btn-back">Annuler</a>
                <button type="submit">Enregistrer</button>
            </div>
        </form>
    </div>
</body>
</html>