<?php
// J'appelle le controller qui gère l'affichage des types de mission:
require_once('../../controller/admin/missionTypeListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des types de missions</title>
    <link rel="stylesheet" href="../../css/missionTypeListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/missionTypeScript.js" defer></script>
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
            <h2>Liste des types de missions</h2>
            <div id="messageContent">
                <?php if (isset($missionTypeListViewMessage)) : ?>
                    <p><?php echo $missionTypeListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allMissionsType)) : ?>
                    <div id="emptyMissionTypeListContainer">
                        <p>Aucun type de mission à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="missionTypeListContainer">
                        <?php foreach ($allMissionsType as $missionTypeId => $missionTypeName) : ?>
                            <div class="missionTypeItemContainer">
                                <p><?php echo $missionTypeName; ?></p>
                                <p><a href=<?php echo "missionTypeUpdateFormView.php?id=" . $missionTypeId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "missionTypeDeleteView.php?id=" . $missionTypeId ?>>Supprimez</a></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>