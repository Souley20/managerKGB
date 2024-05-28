<?php
// J'appelle le controller qui gère l'affichage des statuts de mission:
require_once('../../controller/admin/missionStatusListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des Statuts de missions</title>
    <link rel="stylesheet" href="../../css/missionStatusListViewStyle.css">
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
            <h2>Liste des statuts de mission</h2>
            <div id="messageContent">
                <?php if (isset($missionStatusListViewMessage)) : ?>
                    <p><?php echo $missionStatusListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allMissionsStatus)) : ?>
                    <div id="emptyMissionStatusListContainer">
                        <p>Aucun statut de mission à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="missionStatusListContainer">
                        <?php foreach ($allMissionsStatus as $missionStatusId => $missionStatusName) : ?>
                            <div class="missionStatusItemContainer">
                                <p><?php echo $missionStatusName; ?></p>
                                <p><a href=<?php echo "missionStatusUpdateFormView.php?id=" . $missionStatusId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "missionStatusDeleteView.php?id=" . $missionStatusId ?>>Supprimez</a></p>
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