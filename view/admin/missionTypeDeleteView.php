<?php
// J'appelle le controller qui gère la suppression ou non du type de mission:
require_once('../../controller/admin/missionTypeDeleteController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Supprimer un type de mission</title>
    <link rel="stylesheet" href="../../css/commonDeleteViewStyle.css">
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
            <h2>Supprimer un type de mission</h2>
            <div id="messageContent">
                <?php if (isset($missionTypeDeleteViewMessage)) : ?>
                    <p><?php echo $missionTypeDeleteViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <div id="deleteContent">
                    <p>Voulez vous vraiment supprimer ce type de mission ?</p>
                    <p>Attention en supprimant ce type de mission, vous allez agir sur d'autres données de votre application.</p>
                    <div id="deleteButtons">
                        <p><a href=<?php echo "missionTypeDeleteView.php?id=" . $_GET['id'] . "&confirm=yes"; ?>>Oui</a></p>
                        <p><a href=<?php echo "missionTypeDeleteView.php?id=" . $_GET['id'] . "&confirm=no"; ?>>Non</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>