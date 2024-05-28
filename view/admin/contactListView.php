<?php
// J'appelle le controller qui gère l'affichage des contacts:
require_once('../../controller/admin/contactListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des contacts</title>
    <link rel="stylesheet" href="../../css/contactListViewStyle.css">
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
            <h2>Liste des contacts
            </h2>
            <div id="messageContent">
                <?php if (isset($contactListViewMessage)) : ?>
                    <p><?php echo $contactListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allContactIdentities)) : ?>
                    <div id="emptyContactListContainer">
                        <p>Aucun contact à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="contactListContainer">
                        <?php foreach ($allContactIdentities as $contactId => $contactName) : ?>
                            <div class="contactItemContainer">
                                <p><?php echo $contactName; ?></p>
                                <p><a href=<?php echo "contactUpdateFormView.php?id=" . $contactId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "contactDeleteView.php?id=" . $contactId ?>>Supprimez</a></p>
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