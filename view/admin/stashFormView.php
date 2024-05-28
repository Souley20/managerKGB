<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/stashFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez une planque</title>
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
            <p>A l'aide du formulaire ci-dessous ajoutez les données d'une planque dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($stashFormMessage)) : ?>
                        <p><?php echo $stashFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez une planque</h2>
                <form action="" id="stashForm" method="post">
                    <input type="text" name="addressWritten" placeholder="Entrez ici l'adresse complète de votre planque.">
                    <input type="text" name="typeWritten" placeholder="Entrez ici le type de votre planque.">
                    <select name="countryIdSelected">
                        <?php if (empty($allCountriesData)) : ?>
                            <option value="">Veuillez sélectioner le pays de la planque</option>
                            <option value="">Aucun pays à afficher</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner le pays de la planque</option>
                            <?php foreach ($allCountriesData as $countryId => $countryData) : ?>
                                <option value="<?php echo $countryId; ?>"><?php echo $countryData['country']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <select name="missionIdSelected">
                        <?php if (empty($allMissionsData)) : ?>
                            <option value="">Veuillez sélectioner la mission souhaitée</option>
                            <option value="">Aucune mission à afficher</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner la mission souhaitée</option>
                            <?php foreach ($allMissionsData as $missionId => $missionTitle) : ?>
                                <option value="<?php echo $missionId; ?>"><?php echo $missionTitle; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <input type="submit" value="Ajoutez" id="stashFormSubmit" name="stashFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>