<?php
// J'appelle le controller qui gère l'affichage des planques:
require_once('../../controller/admin/stashListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des planques</title>
    <link rel="stylesheet" href="../../css/stashListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/stashScript.js" defer></script>
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
            <h2>Liste des planques</h2>
            <div id="messageContent">
                <?php if (isset($stashListViewMessage)) : ?>
                    <p><?php echo $stashListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allStashesCodes)) : ?>
                    <div id="emptyStashListContainer">
                        <p>Aucune planque à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="stashListContainer">
                        <?php foreach ($allStashesCodes as $stashCode) : ?>
                            <div class="stashItemContainer">
                                <p><?php echo $stashCode; ?></p>
                                <p><a href=<?php echo "stashUpdateFormView.php?id=" . $stashCode ?>>Modifiez</a></p>
                                <p><a href=<?php echo "stashDeleteView.php?id=" . $stashCode ?>>Supprimez</a></p>
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