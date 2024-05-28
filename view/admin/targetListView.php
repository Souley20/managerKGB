<?php
// J'appelle le controller qui gère l'affichage des cibles:
require_once('../../controller/admin/targetListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des cibles</title>
    <link rel="stylesheet" href="../../css/targetListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/targetScript.js" defer></script>
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
            <h2>Liste des cibles</h2>
            <div id="messageContent">
                <?php if (isset($targetListViewMessage)) : ?>
                    <p><?php echo $targetListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allTargetIdentities)) : ?>
                    <div id="emptyTargetListContainer">
                        <p>Aucune cible à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="targetListContainer">
                        <?php foreach ($allTargetIdentities as $targetId => $targetName) : ?>
                            <div class="targetItemContainer">
                                <p><?php echo $targetName; ?></p>
                                <p><a href=<?php echo "targetUpdateFormView.php?id=" . $targetId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "targetDeleteView.php?id=" . $targetId ?>>Supprimez</a></p>
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