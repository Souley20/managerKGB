<?php
// J'appelle le controller qui gère la suppression ou non du contact:
require_once('../../controller/admin/contactDeleteController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Supprimer un contact</title>
    <link rel="stylesheet" href="../../css/commonDeleteViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/contactScript.js" defer></script>
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
            <h2>Supprimer un contact</h2>
            <div id="messageContent">
                <?php if (isset($contactDeleteViewMessage)) : ?>
                    <p><?php echo $contactDeleteViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <div id="deleteContent">
                    <p>Voulez vous vraiment supprimer ce contact ?</p>
                    <p>Attention en supprimant ce contact, vous allez agir sur d'autres données de votre application.</p>
                    <div id="deleteButtons">
                        <p><a href=<?php echo "contactDeleteView.php?id=" . $_GET['id'] . "&confirm=yes"; ?>>Oui</a></p>
                        <p><a href=<?php echo "contactDeleteView.php?id=" . $_GET['id'] . "&confirm=no"; ?>>Non</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>