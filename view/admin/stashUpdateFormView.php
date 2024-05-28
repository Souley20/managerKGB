<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/stashUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez une planque</title>
    <link rel="stylesheet" href="../../css/stashFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/stashScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous modifiez les données d'une planque dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($stashUpdateFormMessage)) : ?>
                        <p><?php echo $stashUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération de la planque est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant les données de notre planque ($stashDatasRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($stashDatasRetrieved)) : ?>
                    <h2>Modifiez une planque</h2>
                    <form action="" id="stashForm" method="post">
                        <input type="text" name="addressWritten" value="<?php echo $stashDatasRetrieved['address']; ?>" placeholder="Entrez ici l'adresse complète de votre planque.">
                        <input type="text" name="typeWritten" value="<?php echo $stashDatasRetrieved['type']; ?>" placeholder="Entrez ici le type de votre planque.">
                        <select name="countryIdSelected">
                            <?php if (empty($allCountriesData)) : ?>
                                <option value="">Veuillez sélectioner le pays de votre planque</option>
                                <option value="">Aucun pays à afficher</option>
                            <?php else : ?>
                                <?php foreach ($allCountriesData as $countryId => $countryData) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement le pays choisi à la création de la planque: -->
                                    <?php if ($countryData['country'] == $stashDatasRetrieved['countryName']) : ?>
                                        <option value="<?php echo $countryId; ?>" selected><?php echo $countryData['country']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $countryId; ?>"><?php echo $countryData['country']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <select name="missionIdSelected">
                            <?php if (empty($allMissionsData)) : ?>
                                <option value="">Veuillez sélectioner la mission souhaitée</option>
                                <option value="">Aucune mission à afficher</option>
                            <?php else : ?>
                                <?php foreach ($allMissionsData as $missionId => $missionTitle) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement la mission choisie à la création de la planque: -->
                                    <?php if ($missionTitle == $stashDatasRetrieved['missionTitle']) : ?>
                                        <option value="<?php echo $missionId; ?>" selected><?php echo $missionTitle; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $missionId; ?>"><?php echo $missionTitle; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="submit" value="Modifiez" name="stashUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>