<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/missionTypeUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez un type de mission</title>
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
            <p>A l'aide du formulaire ci-dessous modifiez un type de mission dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($missionTypeUpdateFormMessage)) : ?>
                        <p><?php echo $missionTypeUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération du type de mission est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévue. Cette erreur fera alors que notre variable contenant notre type de mission ($missionTypeRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas:-->
                <?php if (!empty($missionTypeRetrieved)) : ?>
                    <h2>Modifiez un type de mission</h2>
                    <form action="" id="missionTypeForm" method="post">
                        <input type="text" name="missionTypeWritten" value="<?php echo $missionTypeRetrieved; ?>" placeholder="Entrez ici le type de mission que vous souhaitez modifier.">
                        <input type="submit" value="Modifiez" name="missionTypeUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>