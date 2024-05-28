<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/RoleRepository.php');
require_once('../../model/User.php');
require_once('../../model/UserRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Dans le formulaire affiché par la vue de ce contrôleur, j'ai 1 champ qui est une liste déroulante. Cette liste déroulante affiche en matière de choix les rôles. Ces informations sont disponibles dans la base de données. Je vais donc aller chercher ces informations à l'aide de la classe qui gére chacune de ces informations. 
        // Pour cela je vais avoir besoin de me connecter à ma base de données avec PDO et donc dans un premier je dois créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        //Je me connecte à la base de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Maintenant je peux instancier ma classe RoleRepository:
        $roleRepository = new RoleRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllRoles(). A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (userFormView.php):
        $allRolesData = $roleRepository->getAllRoles();
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['userFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exception est lancée:
            if (!empty($_POST['firstnameWritten']) && !empty($_POST['lastnameWritten']) && !empty($_POST['emailWritten']) && !empty($_POST['passwordWritten']) && !empty($_POST['createdAtSelected']) && !empty($_POST['roleIdSelected'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" les saisies de mon utilisateur en un code "sécurisé":
                $firstnameWritten = htmlspecialchars($_POST['firstnameWritten']);
                $lastnameWritten = htmlspecialchars($_POST['lastnameWritten']);
                $emailWritten = htmlspecialchars($_POST['emailWritten']);
                $passwordWritten = htmlspecialchars($_POST['passwordWritten']);
                // Afin d'être sûr d'avoir toujours le prénom de notre utilisateur avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de le formater:
                $firstnameWrittenFormated = ucfirst(strtolower($firstnameWritten));
                // Afin d'être sûr d'avoir toujours le nom de notre utilisateur avec le même format (Lettre capitale), je décide de le formater:
                $lastnameWrittenFormated = strtoupper($lastnameWritten);
                // Il faut que je hashe le mot de passe de l'utilisateur:
                $passwordHashed = password_hash($passwordWritten, PASSWORD_DEFAULT);
                // Maintenant il faut que je créé un nouvel objet Datetime dont je vais avoir besoin plus tard avec en paramètre la date saisie par l'utilisateur:
                $createdAt = new DateTime($_POST['createdAtSelected']);
                // A la création de notre base de données nous avons indiqué que les champs "lastname" et "firstname" de la table "user" étaient une chaine de caractères de maximum 100 caractères,. Il faut donc que je vérifie que les informations saisies par l'utilisateur ne fasse pas plus de 100 caractères pour ces deux champs. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($firstnameWrittenFormated) <= 100 && strlen($lastnameWrittenFormated) <= 100) {
                    // Il faut que je fasse la même chose pour l'email qui lui ne doit pas dépasser 255 caractères:
                    if (strlen($emailWritten) <= 255) {
                        // Les saisies de notre utilisateur sont maintenant sécurisées et dans le bon format. Je vais pouvoir maintenant enregistrer celles-ci dans la base de données.  
                        // Avant d'enregistrer l'utilisateur dans la base de données, celui-ci a besoin d'un id. Dans notre base de données, ce champ doit être une chaine de caractères de 36 caractères. En effet, la fonction UUID de mysql permet de créer cette chaîne. Sauf erreur de ma part, php (sans framework ou librairie) ne possède pas de fonction permettant de créer un UUID. Je vais donc utiliser la fonction uniqid de PHP afin de parer à ce petit souci:
                        $prefix = uniqid();
                        $id = uniqid($prefix, true);
                        // Je peux instancier ma classe User afin de créer un nouvel objet:
                        $user = new User($id, $firstnameWrittenFormated, $lastnameWrittenFormated, $emailWritten, $passwordHashed, $createdAt, $_POST['roleIdSelected']);
                        // Afin d'enregistrer l'utilisateur dans la base de données je vais utiliser la classe UserRepository que j'ai créé et plus particulièrement sa fonction addThisUser():
                        $userRepository = new UserRepository($db);
                        $userRepository->addThisUser($user);
                        // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisUser). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                        header('Location: homeView.php');
                    } else {
                        throw new Exception('L\'email ne doit pas dépasser 255 caractères.');
                    }
                } else {
                    throw new Exception('Le prénom et le nom de l\'utilisateur ne doivent pas dépasser 100 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $userFormMessage = $exception->getMessage();
    }
}
