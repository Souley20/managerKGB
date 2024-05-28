<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/RoleFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez un rôle</title>
    <link rel="stylesheet" href="../../css/roleFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/roleScript.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="homeView.php"><img src="../../assets/pictures//home.png" alt="icône accueil application"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <p>A l'aide du formulaire ci-dessous ajoutez un rôle dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($roleFormMessage)) : ?>
                        <p><?php echo $roleFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez un rôle</h2>
                <form action="" id="roleForm" method="post">
                    <input type="text" name="roleWritten" placeholder="Entrez ici le rôle que vous souhaitez ajouter.">
                    <input type="submit" value="Ajoutez" id="roleFormSubmit" name="roleFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>