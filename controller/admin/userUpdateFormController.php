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
        // Et enfin je récupère les données à l'aide de la fonction getAllRoles(). A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (userUpdateFormView.php):
        $allRolesData = $roleRepository->getAllRoles();
        // Afin d'afficher les données de l'utilisateur que l'administrateur souhaite modifier dans les différents champs du formulaire, il faut que j'aille récupérer l'ensemble des données d'un utilisateur dans la base de données. Pour cela je crée un nouvel objet de ma classe UserRepository:
        $userRepository = new UserRepository($db);
        // Et maintenant  je récupére les données de l'utilisateur grâce à son id (présent dans l'url de la requête) à l'aide de la fonction getUserDatasWithThisId(). Cette fonction retourne un tableau. Celui-ci peut être vide ou avec des données. Je décide de gérer ces deux états dans la vue de mon controller:
        $userDatasRetrieved = $userRepository->getUserDatasWithThisId($_GET['id']);
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['userUpdateFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exception est lancée:
            if (!empty($_POST['firstnameWritten']) && !empty($_POST['lastnameWritten']) && !empty($_POST['emailWritten']) && !empty($_POST['createdAtSelected']) && !empty($_POST['roleIdSelected'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" les saisies de mon utilisateur en un code "sécurisé":
                $firstnameWritten = htmlspecialchars($_POST['firstnameWritten']);
                $lastnameWritten = htmlspecialchars($_POST['lastnameWritten']);
                $emailWritten = htmlspecialchars($_POST['emailWritten']);
                // Afin d'être sûr d'avoir toujours le prénom de notre utilisateur avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de le formater:
                $firstnameWrittenFormated = ucfirst(strtolower($firstnameWritten));
                // Afin d'être sûr d'avoir toujours le nom de notre utilisateur avec le même format (Lettre capitale), je décide de le formater:
                $lastnameWrittenFormated = strtoupper($lastnameWritten);
                // Maintenant il faut que je créé un nouvel objet Datetime dont je vais avoir besoin plus tard avec en paramètre la date saisie par l'utilisateur:
                $createdAt = new DateTime($_POST['createdAtSelected']);
                // A la création de notre base de données nous avons indiqué que les champs "lastname" et "firstname" de la table "user" étaient une chaine de caractères de maximum 100 caractères,. Il faut donc que je vérifie que les informations saisies par l'utilisateur ne fasse pas plus de 100 caractères pour ces deux champs. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($firstnameWrittenFormated) <= 100 && strlen($lastnameWrittenFormated) <= 100) {
                    // Il faut que je fasse la même chose pour l'email qui lui ne doit pas dépasser 255 caractères:
                    if (strlen($emailWritten) <= 255) {
                        // Les saisies de l'administrateur sont maintenant sécurisées et dans le bon format. Je vais pouvoir maintenant enregistrer celles-ci dans la base de données. Pour ce faire je vais dans un premier temps créer un nouvel objet de ma classe User:
                        $user = new User($_GET['id'], $firstnameWrittenFormated, $lastnameWrittenFormated, $emailWritten, $userDatasRetrieved['password'], $createdAt, $_POST['roleIdSelected']);
                        // Et enfin grâce à la fonction updateThisUser() de ma classe TargetRepository je met à jour la cible:
                        $userRepository->updateThisUser($user);
                        // Si une erreur se déroule dans la mise à jour de l'utilisateur une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les utilisateurs et où il verra que la modification s'est bien faite:
                        header('Location: userListView.php');
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
        $userUpdateFormMessage = $exception->getMessage();
    }
}
