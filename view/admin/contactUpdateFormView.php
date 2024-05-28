<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/contactUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez un contact</title>
    <link rel="stylesheet" href="../../css/contactFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/contactScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous modifiez les données d'un contact dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($contactUpdateFormMessage)) : ?>
                        <p><?php echo $contactUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération du contact est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant les données de notre contact ($contactDatasRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($contactDatasRetrieved)) : ?>
                    <h2>Modifiez un contact</h2>
                    <form action="" id="contactForm" method="post">
                        <input type="text" name="firstnameWritten" value="<?php echo $contactDatasRetrieved['firstname']; ?>" placeholder="Entrez ici le prénom de votre contact.">
                        <input type="text" name="lastnameWritten" value="<?php echo $contactDatasRetrieved['lastname']; ?>" placeholder="Entrez ici le nom de votre contact.">
                        <div id="dateOfBirthContainer">
                            <label>Date de naissance:</label>
                            <input type="date" value="<?php echo $contactDatasRetrieved['dateOfBirth']; ?>" name="dateOfBirthSelected">
                        </div>
                        <select name="nationalityIdSelected">
                            <?php if (empty($allNationalitiesData)) : ?>
                                <option value="">Veuillez sélectioner la nationalité de votre contact</option>
                                <option value="">Aucune nationalité à afficher</option>
                            <?php else : ?>
                                <?php foreach ($allNationalitiesData as $nationalityId => $nationalityData) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement la nationalité choisie à la création du contact: -->
                                    <?php if ($nationalityData['name'] == $contactDatasRetrieved['nationality']) : ?>
                                        <option value="<?php echo $nationalityId; ?>" selected><?php echo $nationalityData['name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $nationalityId; ?>"><?php echo $nationalityData['name']; ?></option>
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
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement la mission choisie à la création du contact: -->
                                    <?php if ($missionTitle == $contactDatasRetrieved['missionTitle']) : ?>
                                        <option value="<?php echo $missionId; ?>" selected><?php echo $missionTitle; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $missionId; ?>"><?php echo $missionTitle; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="submit" value="Modifiez" name="contactUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>