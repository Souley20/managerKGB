<?php
// J'appelle le controller qui gère la soumission de mon formulaire:
require_once('../../controller/admin/userUpdateFormController.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace administration - Modifiez un utilisateur</title>
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
            <p>A l'aide du formulaire ci-dessous modifiez les données d'un utilisateur dans votre base de données.</p>
            <div id="mainContent">
                <div id="formMessage">
                    <?php if (isset($userUpdateFormMessage)) : ?>
                        <p><?php echo $userUpdateFormMessage; ?></p>
                    <?php endif; ?>
                </div>
                <!-- Si une erreur dans la récupération de l'utilisateur est arrivée nous aurons l'affichage de celle-ci dans l'endroit prévu. Cette erreur fera alors que notre variable contenant les données de notre utilisateur ($userDatasRetrieved) sera vide. Il est alors inutile d'afficher le formulaire de modification. Je décide donc pour cela de vérifier si cette variable est vide ou pas. -->
                <?php if (!empty($userDatasRetrieved)) : ?>
                    <h2>Modifiez un utilisateur</h2>
                    <form action="" id="userForm" method="post">
                        <input type="text" name="firstnameWritten" value="<?php echo $userDatasRetrieved['firstname']; ?>" placeholder="Entrez ici le prénom de votre utilisateur.">
                        <input type="text" name="lastnameWritten" value="<?php echo $userDatasRetrieved['lastname']; ?>" placeholder="Entrez ici le nom de votre utilisateur.">
                        <input type="email" name="emailWritten" value="<?php echo $userDatasRetrieved['email']; ?>" placeholder="Entrez ici le mail de votre utilisateur.">
                        <!-- Je suis ici dans un formulaire de modification, il n'est pas dans la norme et pas très sécuritaire d'afficher le mot de passe (même si celui-ci dans le cas présent est sous sa forme crypté car c'est dans cet état que je l'ai récupéré de ma base de donnée), je prend donc le parti de ne pas permettre la modification du mot de passe grâce à ce formulaire. -->
                        <input type="password" placeholder="Donnée non modifiable" disabled>
                        <div id="createdAtContainer">
                            <label>Créé le:</label>
                            <input type="date" value="<?php echo $userDatasRetrieved['createdAt']; ?>" name="createdAtSelected">
                        </div>
                        <select name="roleIdSelected">
                            <?php if (empty($allRolesData)) : ?>
                                <option value="">Veuillez sélectioner le rôle de votre utilisateur</option>
                                <option value="">Aucun rôle à afficher</option>
                            <?php else : ?>
                                <?php foreach ($allRolesData as $roleId => $roleName) : ?>
                                    <!-- Etant donné que nous sommes dans un formulaire de modification, je décide de sélectionner directement la rôle choisi à la création de l'utilisateur: -->
                                    <?php if ($roleName == $userDatasRetrieved['roleName']) : ?>
                                        <option value="<?php echo $roleId; ?>" selected><?php echo $roleName; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $roleId; ?>"><?php echo $roleName; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="submit" value="Modifiez" name="userUpdateFormSubmit">
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <!-- mainContainer block end -->
    </div>
    <!-- mainWrapper block end -->
</body>

</html>