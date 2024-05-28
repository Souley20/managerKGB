<?php
// J'appelle le controller qui gère l'affichage des agents avec leur ou leurs spécialité(és):
require_once('../../controller/admin/agentSpecialityListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des agents -> specialités</title>
    <link rel="stylesheet" href="../../css/agentSpecialityListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/agentSpecialityScript.js" defer></script>
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
            <h2>Liste des agents -> specialités</h2>
            <div id="messageContent">
                <?php if (isset($agentSpecialityListViewMessage)) : ?>
                    <p><?php echo $agentSpecialityListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allAgentIdentitiesWithSpecialities)) : ?>
                    <div id="emptyAgentSpecialityListContainer">
                        <p>Aucun agent avec sa spécialité à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="agentSpecialityListContainer">
                        <?php foreach ($allAgentIdentitiesWithSpecialities as $agentId => $agentData) : ?>
                            <?php foreach ($agentData as $agentName => $specialityData) : ?>
                                <?php foreach ($specialityData as $specialityId => $specialityName) : ?>
                                    <div class="agentSpecialityItemContainer">
                                        <p><?php echo $agentName . ' -> ' . $specialityName; ?></p>
                                        <p><a href=<?php echo "agentSpecialityUpdateFormView.php?agId=" . $agentId . "&spId=" . $specialityId ?>>Modifiez</a></p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
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