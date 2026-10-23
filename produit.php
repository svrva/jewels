<?php
include 'CNX.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $requete = $bdd->prepare("SELECT * FROM produits WHERE id = ?");
    $requete->execute([$id]);
    $produit = $requete->fetch();
    
    if (!$produit) {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo htmlspecialchars($produit['nom']); ?> - Auroraa_jwelss
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * {
             box-sizing: border-box; 
             margin: 0; padding: 0; 
            }
        body { font-family: 'Jost', sans-serif; background: #FAF8F3; color: #1A1008; }
        
        header {
            background: #1A1008;
             padding: 1.5rem 2rem;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
        }
        .logo { 
            font-family: 'Playfair Display', serif; font-size: 1.6rem;
             color: #D4AF37;
            text-decoration: none; }

        .container {
         max-width: 900px;
         margin: 4rem auto;
         padding: 0 2rem;
         display: flex; 
         gap: 3rem;
         flex-wrap: wrap; }
        .product-image { 
         flex: 1;
         min-width: 300px; 
        }

        .product-image img {
        width: 100%;
        border-radius: 12px;
        border: 1px solid #E8E0D0;
        object-fit: cover;
        aspect-ratio: 1;
        }
        .product-details { 
        flex: 1;
        min-width: 300px;
        display: flex;
        flex-direction: column;
        justify-content: center; }
        
        .category { 
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 2px;
        color: #7A6E60;
         margin-bottom: 0.5rem;
         }

        h1 { 
         font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        margin-bottom: 1rem;
        }
        .price {
         color: #B8860B;
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
         }
        .description {
        color: #5f4d3e; 
        line-height: 1.6;
        margin-bottom: 2rem; }

        .btn-add { background: #5f4d3e;
         color: #D4AF37;
        padding: 1rem 2rem;
        border-radius: 6px;
        border: none;
         cursor: pointer;
        font-family: 'Jost', sans-serif;
        font-size: 1rem;
        text-decoration: none;
        text-align: center;
         transition: 0.2s;
         }
        .btn-add:hover { 
            background: #B8860B;
             color: #fff; }
        .back-link { 
        isplay: inline-block;
        margin-top: 1.5rem;
         color: #a18f80;
         text-decoration: none;
        font-size: 0.9rem
         }
        .back-link:hover { 
            color: #1A1008; }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo">N8N_Jwelss</a>
    </header>

    <main class="container">
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
        </div>
        
        <div class="product-details">
            <span class="category"><?php echo htmlspecialchars($produit['categorie']); ?></span>
            <h1><?php echo htmlspecialchars($produit['nom']); ?></h1>
            <div class="price"><?php echo htmlspecialchars($produit['prix']); ?> DHS</div>
            <p class="description">
                Chaque création de notre collection reflète un savoir-faire unique et raffiné, parfait pour sublimer vos tenues d'été.
            </p>
            
            <a href="action_panier.php?action=ajouter&id=<?php echo $produit['id']; ?>" class="btn-add">Ajouter au panier</a>
            <a href="index.php" class="back-link">← Retour aux collections</a>
        </div>
    </main>

</body>
</html>