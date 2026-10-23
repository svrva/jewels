<?php
session_start();
include 'CNX.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

$message = "";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $req = $bdd->prepare("SELECT * FROM produits WHERE id = ?");
    $req->execute([$id]);
    $produit = $req->fetch();
    
    if (!$produit) {
        die("Produit introuvable !");
    }
} else {
    die(" ID de produit manquant !");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prix = floatval($_POST['prix']);
    $categorie = trim($_POST['categorie']);
    $image = trim($_POST['image']);

    if (!empty($nom) && !empty($prix) && !empty($categorie) && !empty($image)) {
        try {
            $update = $bdd->prepare("UPDATE produits SET nom = ?, prix = ?, categorie = ?, image = ? WHERE id = ?");
            $update->execute([$nom, $prix, $categorie, $image, $id]);
            
            header('Location: admin.php');
            exit();
        } catch (Exception $e) {
            $message = "<p style='color: red;'>🚨 Erreur lors de la modification : " . $e->getMessage() . "</p>";
        }
    } else {
        $message = "<p style='color: red;'>⚠️ Veuillez remplir tous les champs !</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Bijou — Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif; background: #FAF8F3; padding: 2rem; color: #1A1008; }
        .form-container { max-width: 500px; margin: 2rem auto; background: white; padding: 2rem; border-radius: 8px; border: 1px solid #E8E0D0; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
        h1 { font-size: 1.5rem; text-align: center; margin-bottom: 1.5rem; }
        label { display: block; margin-top: 1rem; font-size: 0.9rem; font-weight: 500; }
        input, select { width: 100%; padding: 0.6rem; margin-top: 0.3rem; border: 1px solid #E8E0D0; border-radius: 4px; font-family: 'Jost', sans-serif; }
        .btn-submit { background: #5f4d3e; color: #D4AF37; border: none; margin-top: 1.5rem; width: 100%; padding: 0.7rem; cursor: pointer; font-weight: 500; transition: 0.2s; border-radius: 4px; }
        .btn-submit:hover { background: #B8860B; color: white; }
        .back-link { display: block; text-align: center; margin-top: 1rem; color: #7A6E60; text-decoration: none; font-size: 0.9rem; }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>🛠️ Modifier le bijou n°<?php echo $produit['id']; ?></h1>
        
        <?php echo $message; ?>

        <form action="modifier.php?id=<?php echo $id; ?>" method="POST">
            
            <label for="nom">Nom du bijou</label>
            <input type="text" name="nom" id="nom" required value="<?php echo htmlspecialchars($produit['nom']); ?>">

            <label for="prix">Prix (DHS)</label>
            <input type="number" name="prix" id="prix" required value="<?php echo htmlspecialchars($produit['prix']); ?>">

            <label for="categorie">Catégorie</label>
            <select name="categorie" id="categorie" required>
                <option value="Bague" <?php if($produit['categorie'] == 'Bague') echo 'selected'; ?>>Bague</option>
                <option value="Collier" <?php if($produit['categorie'] == 'Collier') echo 'selected'; ?>>Collier</option>
                <option value="Bracelet" <?php if($produit['categorie'] == 'Bracelet') echo 'selected'; ?>>Bracelet</option>
                <option value="boucle" <?php if($produit['categorie'] == 'boucle') echo 'selected'; ?>>Boucle d'oreille</option>
            </select>

            <label for="image">Nom du fichier image</label>
            <input type="text" name="image" id="image" required value="<?php echo htmlspecialchars($produit['image']); ?>">

            <button type="submit" class="btn-submit">Enregistrer les modifications</button>
        </form>

        <a href="admin.php" class="back-link">← Annuler et retourner à la gestion</a>
    </div>

</body>
</html>