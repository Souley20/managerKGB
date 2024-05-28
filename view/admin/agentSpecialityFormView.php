<?php
require_once('../../controller/admin/agentSpecialityFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez la spécialité d'un agent</title>
    <link rel="stylesheet" href="../../css/agentSpecialityFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/agentSpecialityScript.js" defer></script>
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
            <p>A l'aide du formulaire ci-dessous ajoutez la spécialité d'un agent dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($agentSpecialityFormMessage)) : ?>
                        <p><?php echo $agentSpecialityFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez la spécialité d'un agent</h2>
                <form action="" method="post" id="agentSpecialityForm">
                    <select name="agentIdSelected">
                        <!-- Si le tableau $allAgentsData est vide alos je décide d'afficher un message disant qu'aucun agent n'est disponible, sinon j'affiche les agents: -->
                        <?php if (empty($allAgentsData)) : ?>
                            <option value="">Veuillez sélectionner l'agent</option>
                            <option value="">Aucun agent disponible</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectionner l'agent</option>
                            <?php foreach ($allAgentsData as $agentId => $agentName) : ?>
                                <option value="<?php echo $agentId; ?>"><?php echo $agentName; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
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
                    <input type="submit" value="Ajoutez" name="agentSpecialityFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>