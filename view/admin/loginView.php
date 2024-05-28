<?php
// J'appelle le script du controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/loginController.php')
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Connexion</title>
    <link rel="stylesheet" href="../../css/loginViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/loginScript.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div href="../../index.php" id="navContent-assets/pictures//home">
            <a href="../../index.php"><img src="../../assets/pictures//home.png" alt="icône accueil application"></a>
        </div>
        <!-- navContent block end -->
        <!-- header block start -->
        <header>
            <img src="../../assets/pictures/logo-kgb.png" alt="Logo de l'application">
            <p>Bienvenue sur l'espace administration de cette application.</p>
        </header>
        <!-- header block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <div id="formMessage">
                <?php if (isset($formMessage)) : ?>
                    <p><?php echo $formMessage; ?></p>
                <?php endif; ?>
            </div>
            <h2>Connectez-vous</h2>
            <form action="" id="loginForm" method="post">
                <input type="email" name="emailWritten" placeholder="Entrez ici votre email.">
                <input type="password" name="passwordWritten" placeholder="Entrez ici votre mot de passe.">
                <input type="submit" value="Connexion" id="loginFormSubmit" name="loginFormSubmit">
            </form>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>