<?php
// J'appelle le controller qui gère l'affichage des utilisateurs:
require_once('../../controller/admin/userListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des utilisateurs</title>
    <link rel="stylesheet" href="../../css/userListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/userScript.js" defer></script>
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
            <h2>Liste des utilisateurs</h2>
            <div id="messageContent">
                <?php if (isset($userListViewMessage)) : ?>
                    <p><?php echo $userListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allUsersIdentities)) : ?>
                    <div id="emptyUserListContainer">
                        <p>Aucun utilisateur à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="userListContainer">
                        <?php foreach ($allUsersIdentities as $userId => $userName) : ?>
                            <div class="userItemContainer">
                                <p><?php echo $userName; ?></p>
                                <p><a href=<?php echo "userUpdateFormView.php?id=" . $userId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "userDeleteView.php?id=" . $userId ?>>Supprimez</a></p>
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