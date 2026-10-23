<?php
include 'CNX.php';

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

$produits_panier = array();
$total_general = 0;

if (!empty($_SESSION['panier'])) {
    $ids = implode(',', array_keys($_SESSION['panier']));
    
    $requete = $bdd->query("SELECT * FROM produits WHERE id IN ($ids)");
    $liste_produits = $requete->fetchAll();
    
    foreach ($liste_produits as $p) {
        $id_produit = $p['id'];
        $quantite = $_SESSION['panier'][$id_produit];
         
        $prix_numerique = intval(preg_replace('/[^0-9]/', '', $p['prix']));
        $sous_total = $prix_numerique * $quantite;
        $total_general += $sous_total;
        
        $p['quantite'] = $quantite;
        $p['sous_total'] = $sous_total;
        $produits_panier[] = $p;
    }
}

$nb_articles_panier = isset($_SESSION['panier']) ? count($_SESSION['panier']) : 0;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Auroraa_jwelss</title>
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
        .logo { 
        font-family: 'Playfair Display', serif; 
        font-size: 1.6rem; color: #D4AF37; 
        text-decoration: none; }

        .cart-btn { 
        border: 1px solid #B8860B;
        color: #D4AF37;
        padding: 0.5rem 1.2rem;
        border-radius: 2rem; 
        background: none;
        text-decoration: none;
        font-size: 0.9rem; }

        .container {
             max-width: 900px;
              margin: 4rem auto;
               padding: 0 2rem;
             }

        h1 { 
            font-family: 'Playfair Display', serif;
             font-size: 2.2rem;
              margin-bottom: 2rem;
               text-align: center; }

        table { width: 100%;
         border-collapse: collapse;
          margin-bottom: 2rem; 
          background: #fff; 
          border-radius: 12px; 
          overflow: hidden; 
          border: 1px solid #E8E0D0;
        }
        th { background: #5f4d3e;
         color: #D4AF37;
          text-align: left;
           padding: 1rem; 
           font-weight: 500; 
           font-size: 0.9rem; 
           text-transform: uppercase; 
           letter-spacing: 1px; 
        }
        td { padding: 1.5rem 1rem;
         border-bottom: 1px solid #E8E0D0; 
         vertical-align: middle; }
        
        .prod-info { 
            display: flex; 
            align-items: center; 
            gap: 1rem; }
        .prod-img { width: 70px; 
        height: 70px; 
        object-fit: cover; 
        border-radius: 6px; 
        border: 1px solid #E8E0D0;
     }
        .prod-name { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.1rem; 
            font-weight: 600;
         }
        
        .price { 
        color: #B8860B; 
        font-weight: 500; }
        
        .btn-remove { 
        color: #a18f80; 
        text-decoration: none; 
        font-size: 0.85rem; 
        transition: 0.2s; 
    }
        .btn-remove:hover { 
        color: #cc3333; }

        .cart-footer { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: #fff; 
            padding: 1.5rem; 
            border-radius: 12px; 
            border: 1px solid #E8E0D0; 
            flex-wrap: wrap; 
            gap: 1.5rem; 
        }
        .total-box { 
            font-size: 1.2rem; }

        .total-box span { 
            font-family: 'Playfair Display', serif; 
            font-size: 1.6rem; 
            color: #B8860B; 
            font-weight: bold; 
            margin-left: 0.5rem;
         }

        .actions-btn { 
            display: flex; gap: 1rem; }
        .btn { 
            padding: 0.8rem 1.8rem; 
            border-radius: 6px; 
            text-decoration: none; 
            font-family: 'Jost', sans-serif; 
            font-size: 0.9rem; 
            text-align: center; 
            cursor: pointer; 
            transition: 0.2s; 
            border: none; }
        .btn-checkout { 
            background: #5f4d3e; 
            color: #D4AF37; 
            font-weight: 500; }
        .btn-checkout:hover { 
            background: #B8860B; 
            color: #fff; }
        .btn-clear { 
            background: none; 
            border: 1px solid #E8E0D0;
         color: #a18f80; }
        .btn-clear:hover { 
        border-color: #1A1008; 
        color: #1A1008; }

        .empty-msg { 
        text-align: center; 
        padding: 4rem 2rem; 
        background: #fff; 
        border-radius: 12px; 
        border: 1px solid #E8E0D0; }
        .empty-msg p { 
        color: #7A6E60; 
        margin-bottom: 1.5rem; 
         font-size: 1.1rem; }
        .btn-shop { 
        display: inline-block;
             background: #5f4d3e; 
        color: #D4AF37; 
        padding: 0.8rem 2rem; 
        border-radius: 6px; 
        text-decoration: none; 
        transition: 0.2s;
             }
        .btn-shop:hover { 
        background: #B8860B; 
        color: #fff; }
    </style>
</head>
<body>

    <header>
        <a href="index.php" class="logo">N8N_Jwelss</a>
        <a href="panier.php" class="cart-btn">🛍️ Panier (<?php echo $nb_articles_panier; ?>)</a>
    </header>

    <main class="container">
        <h1>Votre Panier</h1>

        <?php if (empty($produits_panier)): ?>
            <div class="empty-msg">
                <p>Votre panier est actuellement vide.</p>
                <a href="index.php" class="btn-shop">Découvrir nos créations</a>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Bijou</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Sous-total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits_panier as $p): ?>
                        <tr>
                            <td>
                                <div class="prod-info">
                                    <img src="<?php echo htmlspecialchars($p['image']); ?>" class="prod-img">
                                    <span class="prod-name"><?php echo htmlspecialchars($p['nom']); ?></span>
                                </div>
                            </td>
                            <td class="price"><?php echo htmlspecialchars($p['prix']); ?> DHS</td>
                            <td><?php echo $p['quantite']; ?></td>
                            <td class="price"><?php echo $p['sous_total']; ?> DHS</td>
                            <td>
                                <a href="action_panier.php?action=supprimer&id=<?php echo $p['id']; ?>" class="btn-remove">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-footer">
                <div class="total-box">
                    Total estimé : <span><?php echo $total_general; ?> DHS</span>
                </div>
                <div class="actions-btn">
                    <a href="action_panier.php?action=vider" class="btn btn-clear">Vider le panier</a>
                    <a href="commander.php" class="btn btn-checkout">Passer la commande</a>
                </div>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>