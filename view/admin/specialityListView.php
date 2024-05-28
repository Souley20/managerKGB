<?php
// J'appelle le controller qui gère l'affichage des spécialités:
require_once('../../controller/admin/specialityListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des spécialtés</title>
    <link rel="stylesheet" href="../../css/specialityListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/specialityScript.js" defer></script>
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
            <h2>Liste des spécialités</h2>
            <div id="messageContent">
                <?php if (isset($specialityListViewMessage)) : ?>
                    <p><?php echo $specialityListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allSpecialities)) : ?>
                    <div id="emptySpecialityListContainer">
                        <p>Aucune spécialité à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="specialityListContainer">
                        <?php foreach ($allSpecialities as $specialityId => $specialityName) : ?>
                            <div class="specialityItemContainer">
                                <p><?php echo $specialityName; ?></p>
                                <p><a href=<?php echo "specialityUpdateFormView.php?id=" . $specialityId ?>>Modifiez</a></p>
                                <p><a href="<?php echo "specialityDeleteView.php?id=" . $specialityId ?>">Supprimez</a></p>
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