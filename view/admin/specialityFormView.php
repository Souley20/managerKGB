<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/specialityFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez une spécialité</title>
    <link rel="stylesheet" href="../../css/specialityFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/specialityScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous ajoutez une spécialité dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($specialityFormMessage)) : ?>
                        <p><?php echo $specialityFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez une spécialité</h2>
                <form action="" id="specialityForm" method="post">
                    <input type="text" name="specialityWritten" placeholder="Entrez ici la spécialité que vous souhaitez ajouter.">
                    <input type="submit" value="Ajoutez" id="specialityFormSubmit" name="specialityFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>