<?php
require_once('../../controller/admin/missionFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez une mission</title>
    <link rel="stylesheet" href="../../css/missionFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/missionScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous ajoutez les données d'une mission dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($missionFormMessage)) : ?>
                        <p><?php echo $missionFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez une mission</h2>
                <form action="" method="post" id="missionForm">
                    <input type="text" name="titleWritten" placeholder="Entrez ici le titre de votre mission">
                    <input type="text" name="codeNameWritten" placeholder="Entre ici le code de votre mission">
                    <textarea name="descriptionWritten" placeholder="Ecrivez ici la description de votre mission"></textarea>
                    <select name="countryIdSelected">
                        <!-- Si le tableau $allCountriesData est vide alors je décide d'afficher un message disant qu'aucun pays n'est disponible, sinon j'affiche les différentes pays: -->
                        <?php if (empty($allCountriesData)) : ?>
                            <option value="">Veuillez sélectionner le pays de la mission</option>
                            <option value="">Aucun pays disponible</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner le pays de la mission</option>
                            <?php foreach ($allCountriesData as $countryId => $countryData) : ?>
                                <option value="<?php echo $countryId; ?>"><?php echo $countryData['country']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <div class="missionDateContent">
                        <label>Début de mission:</label>
                        <input type="datetime-local" name="missionStartSelected">
                    </div>
                    <div class="missionDateContent">
                        <label>Fin de mission:</label>
                        <input type="datetime-local" name="missionEndSelected">
                    </div>
                    <select name="specialityIdSelected">
                        <!-- Si le tableau $allSpecialitiesData est vide alos je décide d'afficher un message disant qu'aucune spécialités n'est disponible, sinon j'affiche les différentes spécialités: -->
                        <?php if (empty($allSpecialitiesData)) : ?>
                            <option value="">Veuillez sélectionner la spécialité</option>
                            <option value="">Aucune spécialité disponible</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner la spécialité</option>
                            <?php foreach ($allSpecialitiesData as $specialityId => $specialityName) : ?>
                                <option value="<?php echo $specialityId; ?>"><?php echo $specialityName; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <select name="missionTypeIdSelected">
                        <!-- Si le tableau $allMissionTyoeData est vide alos je décide d'afficher un message disant qu'aucun tyoe de mission n'est disponible, sinon j'affiche les différents types de mission: -->
                        <?php if (empty($allMissionTypeData)) : ?>
                            <option value="">Veuillez sélectionner le type de mission</option>
                            <option value="">Aucun type de mission disponible</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner le type de mission</option>
                            <?php foreach ($allMissionTypeData as $missionTypeId => $missionTypeName) : ?>
                                <option value="<?php echo $missionTypeId; ?>"><?php echo $missionTypeName; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <select name="missionStatusIdSelected">
                        <?php if (empty($allMissionStatusData)) : ?>
                            <option value="">Veuillez sélectionner le statut de mission</option>
                            <option value="">Aucun statut de mission disponible</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner le statut de mission</option>
                            <?php foreach ($allMissionStatusData as $missionStatusId => $missionStatusName) : ?>
                                <option value="<?php echo $missionStatusId; ?>"><?php echo $missionStatusName; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <input type="submit" value="Ajoutez" name="missionFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>