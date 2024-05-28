<?php
require_once('../../controller/admin/missionUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez une mission</title>
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
            <p>A l'aide du formulaire ci-dessous modifiez les données d'une mission dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($missionUpdateFormMessage)) : ?>
                        <p><?php echo $missionUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération de la mission est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant les données de notre mission ($missionDatasRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($missionDatasRetrieved)) : ?>
                    <h2>Modifiez une mission</h2>
                    <form action="" method="post" id="missionForm">
                        <input type="text" name="titleWritten" value="<?php echo $missionDatasRetrieved['title']; ?>" placeholder="Entrez ici le titre de votre mission">
                        <input type="text" name="codeNameWritten" value="<?php echo $missionDatasRetrieved['codeName']; ?>" placeholder="Entre ici le code de votre mission">
                        <textarea name="descriptionWritten" placeholder="Ecrivez ici la description de votre mission"><?php echo $missionDatasRetrieved['description']; ?></textarea>
                        <select name="countryIdSelected">
                            <!-- Si le tableau $allCountriesData est vide alors je décide d'afficher un message disant qu'aucun pays n'est disponible, sinon j'affiche les différentes pays: -->
                            <?php if (empty($allCountriesData)) : ?>
                                <option value="">Veuillez sélectionner le pays de la mission</option>
                                <option value="">Aucun pays disponible</option>
                            <?php else : ?>
                                <?php foreach ($allCountriesData as $countryId => $countryData) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement le pays choisi à la création de la mission: -->
                                    <?php if ($countryData['country'] == $missionDatasRetrieved['countryName']) : ?>
                                        <option value="<?php echo $countryId; ?>" selected><?php echo $countryData['country']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $countryId; ?>"><?php echo $countryData['country']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <div class="missionDateContent">
                            <label>Début de mission:</label>
                            <input type="datetime-local" name="missionStartSelected" value="<?php echo $missionDatasRetrieved['missionStart']; ?>">
                        </div>
                        <div class="missionDateContent">
                            <label>Fin de mission:</label>
                            <input type="datetime-local" name="missionEndSelected" value="<?php echo $missionDatasRetrieved['missionEnd']; ?>">
                        </div>
                        <select name="specialityIdSelected">
                            <!-- Si le tableau $allSpecialitiesData est vide alos je décide d'afficher un message disant qu'aucune spécialités n'est disponible, sinon j'affiche les différentes spécialités: -->
                            <?php if (empty($allSpecialitiesData)) : ?>
                                <option value="">Veuillez sélectionner la spécialité</option>
                                <option value="">Aucune spécialité disponible</option>
                            <?php else : ?>
                                <?php foreach ($allSpecialitiesData as $specialityId => $specialityName) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement la spécialité choisie à la création de la mission: -->
                                    <?php if ($specialityName == $missionDatasRetrieved['specialityName']) : ?>
                                        <option value="<?php echo $specialityId; ?>" selected><?php echo $specialityName; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $specialityId; ?>"><?php echo $specialityName; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <select name="missionTypeIdSelected">
                            <!-- Si le tableau $allMissionTyoeData est vide alos je décide d'afficher un message disant qu'aucun tyoe de mission n'est disponible, sinon j'affiche les différents types de mission: -->
                            <?php if (empty($allMissionTypeData)) : ?>
                                <option value="">Veuillez sélectionner le type de mission</option>
                                <option value="">Aucun type de mission disponible</option>
                            <?php else : ?>
                                <?php foreach ($allMissionTypeData as $missionTypeId => $missionTypeName) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement le type de mission choisie à la création de la mission: -->
                                    <?php if ($missionTypeName == $missionDatasRetrieved['missionTypeName']) : ?>
                                        <option value="<?php echo $missionTypeId; ?>" selected><?php echo $missionTypeName; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $missionTypeId; ?>"><?php echo $missionTypeName; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <select name="missionStatusIdSelected">
                            <?php if (empty($allMissionStatusData)) : ?>
                                <option value="">Veuillez sélectionner le statut de mission</option>
                                <option value="">Aucun statut de mission disponible</option>
                            <?php else : ?>
                                <?php foreach ($allMissionStatusData as $missionStatusId => $missionStatusName) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement le statut de mission choisie à la création de la mission: -->
                                    <?php if ($missionStatusName == $missionDatasRetrieved['missionStatusName']) : ?>
                                        <option value="<?php echo $missionStatusId; ?>" selected><?php echo $missionStatusName; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $missionStatusId; ?>"><?php echo $missionStatusName; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="submit" value="Modifiez" name="missionUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>