<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/missionTypeFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez un type de mission</title>
    <link rel="stylesheet" href="../../css/missionTypeFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/missionTypeScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous ajoutez un type de mission dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($missionTypeFormMessage)) : ?>
                        <p><?php echo $missionTypeFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez un type de mission</h2>
                <form action="" id="missionTypeForm" method="post">
                    <input type="text" name="missionTypeWritten" placeholder="Entrez ici le type de mission que vous souhaitez ajouter.">
                    <input type="submit" value="Ajoutez" id="missionTypeFormSubmit" name="missionTypeFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>