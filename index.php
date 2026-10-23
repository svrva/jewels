<?php
session_start(); 

include 'CNX.php'; 

try {
    $requete = $bdd->query("SELECT * FROM produits");
    $produits = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}

$nb_articles_panier = isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>N8N_jwelss</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Jost', sans-serif;
            background: #FAF8F3;
            color: #1A1008;
        }

        .radio-filtre,
        .products-wrap,
        .pcard {
            display: none;
        }

        header {
            background: #1A1008;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: #D4AF37;
            letter-spacing: 1px;
        }

        .cart-btn {
            border: 1px solid #B8860B;
            color: #D4AF37;
            padding: 0.5rem 1.2rem;
            border-radius: 2rem;
            background: none;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .hero {
            background: #8d7566;
            padding: 4rem 2rem;
            text-align: center;
            color: #fff;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            margin-bottom: 0.5rem;
        }

        .hero h1 em {
            color: #D4AF37;
            font-style: italic;
        }

        .hero p {
            color: #7A6E60;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 2px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin: 3rem 0 1.5rem;
            font-size: 1.6rem;
        }

        .categories {
            display: flex;
            gap: 1.2rem;
            justify-content: center;
            padding: 0 2rem;
            max-width: 1000px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .cat-card {
            background: #fff;
            border: 1px solid #E8E0D0;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            flex: 1;
            min-width: 200px;
            cursor: pointer;
            transition: 0.2s;
            display: block;
        }

        .cat-card:hover {
            border-color: #B8860B;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .cat-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.8rem;
        }

        .cat-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 600;
            color: #1A1008;
        }

        .products-wrap {
            max-width: 1000px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .pcard {
            background: #fff;
            border: 1px solid #E8E0D0;
            border-radius: 12px;
            overflow: hidden;
        }

        .pcard-img {
            width: 100%;
            aspect-ratio: 1;
            object-fit: cover;
        }

        .pcard-body {
            padding: 1.2rem;
        }

        .pcard-name {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            margin-bottom: 0.4rem;
        }

        .pcard-price {
            color: #B8860B;
            font-weight: 500;
            font-size: 1.1rem;
            margin-bottom: 0.8rem;
        }

        .pcard-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            flex: 1;
            padding: 0.6rem;
            border-radius: 6px;
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: 0.8rem;
            text-align: center;
            border: none;
            text-decoration: none;
            transition: 0.2s;
            display: inline-block !important;
            visibility: visible !important;
        }

        .btn-details {
            background: none;
            border: 1px solid #E8E0D0;
            color: #a18f80;
        }

        .btn-details:hover {
            border-color: #B8860B;
            color: #B8860B;
        }

        .btn-add {
            background: #5f4d3e;
            color: #D4AF37;
        }

        .btn-add:hover {
            background: #B8860B;
            color: #fff;
        }

        #check-bracelet:checked~.products-wrap,
        #check-collier:checked~.products-wrap,
        #check-bague:checked~.products-wrap,
        #check-boucle:checked~.products-wrap {
            display: block;
        }

        #check-bracelet:checked~.products-wrap .bracelet,
        #check-collier:checked~.products-wrap .collier,
        #check-bague:checked~.products-wrap .bague,
        #check-boucle:checked~.products-wrap .boucle {
            display: block !important;
        }

        footer {
            background: #1A1008;
            color: #d4bb9e;
            text-align: center;
            padding: 2rem;
            margin-top: 4rem;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <input type="radio" name="collection" id="check-bracelet" class="radio-filtre">
    <input type="radio" name="collection" id="check-collier" class="radio-filtre">
    <input type="radio" name="collection" id="check-bague" class="radio-filtre">
    <input type="radio" name="collection" id="check-boucle" class="radio-filtre">

    <header>
        <div class="logo">N8N_Jwelss</div>
        <a href="panier.php" class="cart-btn">🛍️ Panier (<?php echo $nb_articles_panier; ?>)</a>
    </header>

    <div class="hero">
        <h1>Nos Creations d'ETE!</h1>
        <p>Créations Uniques</p>
    </div>

    <p class="section-title">Choisissez votre collection</p>

    <div class="categories">
        <label for="check-bracelet" class="cat-card">
            <img src="bijou5.jpg" class="cat-img" alt="Bracelets">
            <div class="cat-name">Bracelets</div>
        </label>
        <label for="check-collier" class="cat-card">
            <img src="bijou6.jpg" class="cat-img" alt="Colliers">
            <div class="cat-name">Colliers</div>
        </label>
        <label for="check-bague" class="cat-card">
            <img src="bijou1.jpg" class="cat-img" alt="Bagues">
            <div class="cat-name">Bagues</div>
        </label>
        <label for="check-boucle" class="cat-card">
            <img src="bijou11.jpg" class="cat-img" alt="Boucles d'oreilles">
            <div class="cat-name">Boucles d'oreilles</div>
        </label>
    </div>

    <div class="products-wrap">
        <div class="products-grid">

            <?php if (empty($produits)): ?>
                <p style="grid-column: 1/-1; text-align: center; color: #7A6E60; padding: 2rem;">🚨 Aucun bijou trouvé dans la base de données.</p>
            <?php else: ?>
                
                <?php foreach ($produits as $p): ?>
                    <div class="pcard <?php echo strtolower(trim(htmlspecialchars($p['categorie']))); ?>">
                        <img src="<?php echo htmlspecialchars($p['image']); ?>" class="pcard-img" alt="Bijou">
                        <div class="pcard-body">
                            <div class="pcard-name"><?php echo htmlspecialchars($p['nom']); ?></div>
                            <div class="pcard-price"><?php echo htmlspecialchars($p['prix']); ?> DHS</div>
                            <div class="pcard-actions">
                                <a href="produit.php?id=<?php echo $p['id']; ?>" class="btn-action btn-details">Détails</a>
                                <a href="action_panier.php?action=ajouter&id=<?php echo $p['id']; ?>" class="btn-action btn-add">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>

    <footer>
        <p>©️ 2026 <span>Auroraa_jwelss</span> — Boutiques de luxe</p>
    </footer>

</body>
</html>