<?php
// J'appelle le controller qui gère l'affichage des missions:
require_once('../../controller/admin/missionListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des missions</title>
    <link rel="stylesheet" href="../../css/missionListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/missionScript.js" defer></script>
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
            <h2>Liste des missions</h2>
            <div id="messageContent">
                <?php if (isset($missionListViewMessage)) : ?>
                    <p><?php echo $missionListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allMissions)) : ?>
                    <div id="emptyMissionListContainer">
                        <p>Aucune mission à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="missionListContainer">
                        <?php foreach ($allMissions as $missionId => $missionName) : ?>
                            <div class="missionItemContainer">
                                <p><?php echo $missionName; ?></p>
                                <p><a href=<?php echo "missionUpdateFormView.php?id=" . $missionId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "missionDeleteView.php?id=" . $missionId ?>>Supprimez</a></p>
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