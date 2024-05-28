<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/specialityUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez une spécialité</title>
    <link rel="stylesheet" href="../../css/specialityFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/specialityScript.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="homeView.php"><img src="../../assets/pictures/home.png" alt="icône accueil application"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <p>A l'aide du formulaire ci-dessous modifiez une spécialité dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($specialityUpdateFormMessage)) : ?>
                        <p><?php echo $specialityUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération de la spécialité est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévue. Cette erreur fera alors que notre variable contenant notre spécialité ($specialityRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas:-->
                <?php if (!empty($specialityRetrieved)) : ?>
                    <h2>Modifiez une spécialité</h2>
                    <form action="" id="specialityForm" method="post">
                        <input type="text" name="specialityWritten" value="<?php echo $specialityRetrieved; ?>" placeholder="Entrez ici la spécialité que vous souhaitez modifier.">
                        <input type="submit" value="Modifiez" name="specialityUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>