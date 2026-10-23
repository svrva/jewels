<?php
session_start();

include 'CNX.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

try {
    $requete = $bdd->query("SELECT * FROM produits");
    $produits = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Admin - Gestion des Bijoux</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Jost', sans-serif; 
            background: #FAF8F3; 
            padding: 2rem; 
            color: #1A1008; 
        }
        .header-admin { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 2rem; 
            border-bottom: 2px solid #E8E0D0; 
            padding-bottom: 1rem; 
        }
        h1 { 
            font-size: 1.8rem; 
            color: #1A1008; 
        }
        .btn { 
            padding: 0.6rem 1.2rem; 
            border-radius: 4px; 
            text-decoration: none; 
            font-size: 0.9rem; 
            display: inline-block; 
            transition: all 0.3s ease;
        }
        .btn-add { 
            background: #5f4d3e; 
            color: #D4AF37; 
            font-weight: 500;
        }
        .btn-add:hover { 
            background: #B8860B; 
            color: #fff; 
        }
        .btn-mod {
            background-color: #5f4d3e; 
            color: #D4AF37; 
            padding: 0.4rem 0.8rem; 
            text-decoration: none; 
            border-radius: 4px; 
            margin-right: 5px; 
            font-size: 0.85rem;
            display: inline-block;
            transition: 0.2s;
        }
        .btn-mod:hover {
            background: #B8860B;
            color: white;
        }
        .btn-del { 
            background: #c0392b; 
            color: white; 
            padding: 0.4rem 0.8rem; 
            border-radius: 4px; 
            text-decoration: none; 
            display: inline-block;
        }
        .btn-del:hover { 
            background: #e74c3c; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            border: 1px solid #E8E0D0; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        th, td { 
            padding: 1rem; 
            text-align: left; 
            border-bottom: 1px solid #E8E0D0; 
            vertical-align: middle;
        }
        th { 
            background: #5f4d3e; 
            color: white; 
            font-weight: 400; 
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
        tr:hover {
            background: #FAF8F3;
        }
        img { 
            width: 50px; 
            height: 50px; 
            object-fit: cover; 
            border-radius: 4px; 
            border: 1px solid #E8E0D0;
        }
        .actions-cell {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="header-admin">
        <h1>Gestion du catalogue — Auroraa_jwelss</h1>
        <a href="ajouter_produit.php" class="btn btn-add">+ Ajouter un bijou</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom du Bijou</th>
                <th>Prix</th>
                <th>Catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($produits)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #7A6E60; padding: 2rem;">
                        Aucun bijou en stock actuellement. Cliquez sur le bouton ci-dessus pour en ajouter !
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td><img src="<?php echo htmlspecialchars($p['image']); ?>" alt="Bijou"></td>
                    <td><strong><?php echo htmlspecialchars($p['nom']); ?></strong></td>
                    <td><?php echo htmlspecialchars($p['prix']); ?> DHS</td>
                    <td><?php echo htmlspecialchars($p['categorie']); ?></td>
                    <td>
                        <div class="actions-cell">
                            <a href="modifier.php?id=<?php echo $p['id']; ?>" class="btn-mod">Modifier</a>
                            
                            <a href="supprimer.php?id=<?php echo $p['id']; ?>" 
                               class="btn btn-del" 
                               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce magnifique bijou ?')">
                               Supprimer
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

</body>
</html>