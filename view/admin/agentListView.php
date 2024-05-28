<?php
// J'appelle le controller qui gère l'affichage des agents:
require_once('../../controller/admin/agentListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des agents</title>
    <link rel="stylesheet" href="../../css/agentListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/agentScript.js" defer></script>
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
            <h2>Liste des agents</h2>
            <div id="messageContent">
                <?php if (isset($agentListViewMessage)) : ?>
                    <p><?php echo $agentListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allAgentIdentities)) : ?>
                    <div id="emptyAgentListContainer">
                        <p>Aucun agent à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="agentListContainer">
                        <?php foreach ($allAgentIdentities as $agentId => $agentName) : ?>
                            <div class="agentItemContainer">
                                <p><?php echo $agentName; ?></p>
                                <p><a href=<?php echo "agentUpdateFormView.php?id=" . $agentId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "agentDeleteView.php?id=" . $agentId ?>>Supprimez</a></p>
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