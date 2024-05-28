<?php
// J'appelle le controller qui gère l'affichage des rôles:
require_once('../../controller/admin/roleListViewController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Liste des rôles</title>
    <link rel="stylesheet" href="../../css/roleListViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
            <h2>Liste des rôles</h2>
            <div id="messageContent">
                <?php if (isset($roleListViewMessage)) : ?>
                    <p><?php echo $roleListViewMessage; ?></p>
                <?php endif; ?>
            </div>
            <div id="mainContent">
                <?php if (empty($allRoles)) : ?>
                    <div id="emptyRoleListContainer">
                        <p>Aucun rôle à afficher.</p>
                    </div>
                <?php else : ?>
                    <div id="roleListContainer">
                        <?php foreach ($allRoles as $roleId => $roleName) : ?>
                            <div class="roleItemContainer">
                                <p><?php echo $roleName; ?></p>
                                <p><a href=<?php echo "roleUpdateFormView.php?id=" . $roleId ?>>Modifiez</a></p>
                                <p><a href=<?php echo "roleDeleteView.php?id=" . $roleId ?>>Supprimez</a></p>
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