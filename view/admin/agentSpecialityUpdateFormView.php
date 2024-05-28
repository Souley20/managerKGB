<?php
require_once('../../controller/admin/agentSpecialityUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez la spécialité d'un agent</title>
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
            <p>A l'aide du formulaire ci-dessous modifiez la spécialité d'un agent dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($agentSpecialityUpdateFormMessage)) : ?>
                        <p><?php echo $agentSpecialityUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération de l'agent avec sa spécilaité arrive nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant les données de notre cible ($agentSpecialityDatasRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($agentSpecialityDatasRetrieved)) : ?>
                    <h2>Modifiez la spécialité d'un agent</h2>
                    <form action="" method="post" id="agentSpecialityForm">
                        <select name="agentIdSelected">
                            <option value="<?php echo $agentSpecialityDatasRetrieved['id']; ?>"><?Php echo $agentSpecialityDatasRetrieved['identity']; ?></option>
                        </select>
                        <select name="specialityIdSelected">
                            <!-- Si le tableau $allSpecialitiesData est vide alos je décide d'afficher un message disant qu'aucune spécialités n'est disponible, sinon j'affiche les différentes spécialités: -->
                            <?php if (empty($allSpecialitiesData)) : ?>
                                <option value="">Veuillez sélectionner la spécialité</option>
                                <option value="">Aucune spécialité disponible</option>
                            <?php else : ?>
                                <?php foreach ($allSpecialitiesData as $specialityId => $specialityName) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement la spécialité choisie à la création du couple agent -> spécialité: -->
                                    <?php if ($specialityName == $agentSpecialityDatasRetrieved['speciality']) : ?>
                                        <option value="<?php echo $specialityId; ?>" selected><?php echo $specialityName; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $specialityId; ?>"><?php echo $specialityName; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="submit" value="Modifiez" name="agentSpecialityUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>