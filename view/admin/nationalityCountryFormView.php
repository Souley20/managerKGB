<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/nationalityCountryFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez une nationalité et son pays</title>
    <link rel="stylesheet" href="../../css/nationalityCountryFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/nationalityCountryScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous ajoutez une nationalité et son pays dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($nationalityCountryFormMessage)) : ?>
                        <p><?php echo $nationalityCountryFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez une nationalité et son pays</h2>
                <form action="" id="nationalityCountryForm" method="post">
                    <input type="text" name="nationalityWritten" placeholder="Entrez ici la nationalité que vous souhaitez ajouter.">
                    <input type="text" name="countryWritten" placeholder="Entrez ici le pays de votre nationalité que vous souhaitez ajouter.">
                    <input type="submit" value="Ajoutez" name="nationalityCountryFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>