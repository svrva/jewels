<?php
include 'CNX.php';

$erreur = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
$res=$bdd ->prepare("INSERT INTO admin(username,password) VALUES(?,?)");
$res->execute([$_POST['username'],$_POST['password']]);

    if ($username === "admin" && $password === "admin123") {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $erreur = "Identifiants incorrects !";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion Admin - Auroraa_jwelss</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Jost', sans-serif;
         background: #FAF8F3; 
         display: flex; 
         justify-content: center; 
         align-items: center; 
         height: 100vh; margin: 0; }
        .login-box {
        background: #fff; 
        padding: 2.5rem; 
        border-radius: 8px; 
        border: 1px solid #E8E0D0; 
        width: 100%; 
        max-width: 380px; 
        text-align: center;
         }

        h2 { 
        margin-bottom: 1.5rem; 
        color: #1A1008; 
        font-weight: 400; 
        letter-spacing: 1px;
     }

        input { 
        width: 100%; 
        padding: 0.8rem; 
        margin-bottom: 1rem; 
        border: 1px solid #E8E0D0; 
        border-radius: 4px; 
        background: #FAF8F3; 
        box-sizing: border-box; 
    }

        button { 
        width: 100%; 
        padding: 0.8rem; 
        background: #5f4d3e; 
        color: #D4AF37; 
        border: none; 
        border-radius: 4px; 
        cursor: pointer; 
        font-size: 1rem; 
    }

        button:hover { 
        background: #B8860B; 
        color: #fff;
     }

        .error { color: red; margin-bottom: 1rem; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Espace Admin</h2>
        <?php if(!empty($erreur)) echo "<p class='error'>$erreur</p>"; ?>
        <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>