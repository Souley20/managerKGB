<?php
// J'appelle ici le constructeur qui va gérer cette page:
require_once('../controller/missionFrontListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des missions</title>
    <link rel="stylesheet" href="../css/missionFrontListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../js//missionFrontListView.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="../index.php"><img src="../assets/pictures/arrow.png" alt="Icone page précédente"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <h1>Liste des missions</h1>
            <div id="messageContent">
                <?php if (isset($missionListViewMessage)) : ?>
                    <p><?php echo $missionListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <!-- Comme vu dans le contrôteur, mon tableau $allMissionsData peut être vide. Je décide donc de gérer cet état ici: -->
                <?php if (empty($allMissionsDatas)) : ?>
                    <p>Aucune mission à afficher.</p>
                <?php else : ?>
                    <!-- Si mon tableau n'est pas vide -->
                    <?php foreach ($allMissionsDatas as $missionId => $missionData) : ?>
                        <div class="cardContainer">
                            <h2><?php echo $missionData['title']; ?></h2>
                            <p><span class="bold">Code: </span><?php echo $missionData['code_name']; ?></p>
                            <p><span class="bold">Statut: </span><?php echo $missionData['missionStatus']; ?>.</p>
                            <p><a href=<?php echo "missionDetailView.php?id=" . $missionId; ?>>En savoir plus</a></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
    <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>