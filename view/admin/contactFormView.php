<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/contactFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez un contact</title>
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
            <p>A l'aide du formulaire ci-dessous ajoutez les données d'un contact dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($contactFormMessage)) : ?>
                        <p><?php echo $contactFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez un contact</h2>
                <form action="" id="contactForm" method="post">
                    <input type="text" name="firstnameWritten" placeholder="Entrez ici le prénom de votre contact.">
                    <input type="text" name="lastnameWritten" placeholder="Entrez ici le nom de votre contact.">
                    <div id="dateOfBirthContainer">
                        <label>Date de naissance:</label>
                        <input type="date" name="dateOfBirthSelected">
                    </div>
                    <select name="nationalityIdSelected">
                        <?php if (empty($allNationalitiesData)) : ?>
                            <option value="">Veuillez sélectioner la nationalité de votre contact</option>
                            <option value="">Aucune nationalité à afficher</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner la nationalité de votre contact</option>
                            <?php foreach ($allNationalitiesData as $nationalityId => $nationalityData) : ?>
                                <option value="<?php echo $nationalityId; ?>"><?php echo $nationalityData['name']; ?></option>
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
                    <input type="submit" value="Ajoutez" id="contactFormSubmit" name="contactFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>