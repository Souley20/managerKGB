<?php
// J'appelle le controller qui géère la soumission de mon formulaire:
require_once('../../controller/admin/userFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Ajoutez un utilisateur</title>
    <link rel="stylesheet" href="../../css/userFormViewStyle.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/userScript.js" defer></script>
</head>

<body>
    <!-- mainWrapper block start -->
    <div id="mainWrapper">
        <!-- navContent block start -->
        <div id="navContent">
            <a href="homeView.php"><img src="../../assets/pictures//home.png" alt="icône accueil application"></a>
        </div>
        <!-- navContent block end -->
        <!-- mainContainer block start -->
        <div id="mainContainer">
            <p>A l'aide du formulaire ci-dessous ajoutez les données d'un utilisateur dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($userFormMessage)) : ?>
                        <p><?php echo $userFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <h2>Ajoutez un utilisateur</h2>
                <form action="" id="userForm" method="post">
                    <input type="text" name="firstnameWritten" placeholder="Entrez ici le prénom de votre utilisateur.">
                    <input type="text" name="lastnameWritten" placeholder="Entrez ici le nom de votre utilisateur.">
                    <input type="email" name="emailWritten" placeholder="Entrez ici le mail de votre utilisateur.">
                    <input type="password" name="passwordWritten" placeholder="Entrez ici le mot de passe de votre utilisateur.">
                    <div id="createdAtContainer">
                        <label>Créé le:</label>
                        <input type="date" name="createdAtSelected">
                    </div>
                    <select name="roleIdSelected">
                        <?php if (empty($allRolesData)) : ?>
                            <option value="">Veuillez sélectioner le rôle de votre utilisateur</option>
                            <option value="">Aucun rôle à afficher</option>
                        <?php else : ?>
                            <option value="">Veuillez sélectioner le rôle de votre utilisateur</option>
                            <?php foreach ($allRolesData as $roleId => $roleName) : ?>
                                <option value="<?php echo $roleId; ?>"><?php echo $roleName; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <input type="submit" value="Ajoutez" name="userFormSubmit">
                </form>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>