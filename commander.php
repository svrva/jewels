<?php
include 'CNX.php';

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    header('Location: index.php');
    exit();
}

$total_commande = 0;
$ids = implode(',', array_keys($_SESSION['panier']));
$requete = $bdd->query("SELECT * FROM produits WHERE id IN ($ids)");
$liste_produits = $requete->fetchAll();

foreach ($liste_produits as $p) {
    $quantite = $_SESSION['panier'][$p['id']];
    $total_commande += $p['prix'] * $quantite; 
}

$commande_validee = false;
$numero_commande = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars($_POST['nom']);
    $telephone = htmlspecialchars($_POST['telephone']);
    $adresse = htmlspecialchars($_POST['adresse']);

    if (!empty($nom) && !empty($telephone) && !empty($adresse)) {
        $commande_validee = true;
        $numero_commande = ""; 
        
        $_SESSION['panier'] = array();
    }
}

$nb_articles_panier = isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finaliser ma commande - N8N_jwelss</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; 
        margin: 0; 
        padding: 0; }
        body { font-family: 'Jost', sans-serif;
         background: #FAF8F3;
          color: #1A1008; }
        
        header {
            background: #1A1008;
             padding: 1.5rem 2rem;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }
        .logo { font-family: 'Playfair Display', serif; 
        font-size: 1.6rem;
         color: #D4AF37;
          text-decoration: none; }

        .container { max-width: 600px;
         margin: 4rem auto; 
         padding: 2rem; 
         background: #fff;
          border-radius: 12px;
           border: 1px solid #E8E0D0; }
        h1 { font-family: 'Playfair Display', serif; 
        font-size: 2rem;
         margin-bottom: 1.5rem; 
        text-align: center; }
        
        .total-box { background: #FAF8F3;
         padding: 1rem;
          border-radius: 6px; 
          text-align: center;
           font-size: 1.1rem; 
           margin-bottom: 2rem; 
           border: 1px dashed #B8860B; }
        .total-box strong { color: #B8860B; 
        font-size: 1.3rem; 
        font-family: 'Playfair Display', serif; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block;
         margin-bottom: 0.5rem; 
         font-weight: 500; 
         font-size: 0.9rem; 
         color: #5f4d3e;
          text-transform: uppercase; 
          letter-spacing: 0.5px; }
        input, textarea { width: 100%;
         padding: 0.8rem;
          border: 1px solid #E8E0D0; 
          border-radius: 6px; 
          font-family: 'Jost', sans-serif; 
          font-size: 1rem;
           background: #FAF8F3; }
        input:focus, textarea:focus { outline: none; 
        border-color: #5f4d3e; 
        background: #fff; }

        .btn-submit { display: block;
         width: 100%;
          background: #5f4d3e;
           color: #D4AF37;
            padding: 1rem;
             border-radius: 6px;
              border: none;
               font-family: 'Jost', sans-serif; 
               font-size: 1rem;
                font-weight: 500;
                 cursor: pointer;
                  transition: 0.2s;
                   margin-top: 2rem; }
                   
        .btn-submit:hover { 
        background: #B8860B;
         color: #fff; }

        .success-box { text-align: center;
         padding: 2rem 1rem; }
        .success-icon { font-size: 3rem;
         color: #B8860B;
          margin-bottom: 1rem; }
        .success-box p { color: #5f4d3e; 
        line-height: 1.6;
         margin-bottom: 1.5rem; }
        .order-number { font-weight: bold; 
        color: #1A1008; 
        background: #FAF8F3;
         padding: 0.5rem 1rem; 
         border-radius: 4px; 
         display: inline-block; 
         margin-bottom: 2rem; }
        .btn-home { display: inline-block;
         background: #5f4d3e;
          color: #D4AF37;
           padding: 0.8rem 2rem; 
           border-radius: 6px; 
           text-decoration: none; 
           transition: 0.2s; }
        .btn-home:hover { background: #B8860B;
         color: #fff; }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo">Auroraa_jwelss</a>
    </header>

    <main class="container">
        <?php if ($commande_validee): ?>
            <div class="success-box">
                <div class="success-icon">✨</div>
                <h1>Merci pour votre commande</h1>
                <p>Vos bijoux précieux sont en cours de préparation. Un conseiller va vous contacter par téléphone pour confirmer la livraison.</p>
                <div class="order-number">Référence : <?php echo $numero_commande; ?></div>
                <div>
                    <a href="index.php" class="btn-home">Retour à la boutique</a>
                </div>
            </div>
        <?php else: ?>
            <h1>Informations de Livraison</h1>
            
            <div class="total-box">
                Montant total à régler à la livraison : <strong><?php echo $total_commande; ?> DHS</strong>
            </div>

            <form action="commander.php" method="POST">
                <div class="form-group">
                    <label for="nom">Nom & Prénom complet</label>
                    <input type="text" id="nom" name="nom" required placeholder="Ex: Amina Alami">
                </div>

                <div class="form-group">
                    <label for="telephone">Numéro de Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" required placeholder="Ex: 0612345678">
                </div>

                <div class="form-group">
                    <label for="adresse">Adresse complète de livraison</label>
                    <textarea id="adresse" name="adresse" rows="4" required placeholder="Ex: Appartement 4, Immeuble B, Rue Ain Chock, Casablanca"></textarea>
                </div>

                <button type="submit" class="btn-submit">Confirmer ma commande</button>
            </form>
        <?php endif; ?>
    </main>

</body>
</html>
