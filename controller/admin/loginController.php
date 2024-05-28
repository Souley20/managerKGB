<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/UserRepository.php');
require_once('../../model/RoleRepository.php');

// A la fin de mon script, je vais utiliser la fonction session de php. Je déclare donc ici le démarrage de cette fonction:
session_start();
// Afin de gérer les erreurs sur notre formulaire de connexion, j'inscris mon script dans un bloc try...catch:
try {
    if (isset($_POST['loginFormSubmit'])) {
        // La première chose que je décide de vérifier est de m'assurer que tous les champs de mon formulaire soit remplis. Si ce n'est pas le cas alors je lance une exception:
        if (!empty($_POST['emailWritten'] && !empty($_POST['passwordWritten']))) {
            // Les champs ne sont pas vides. Il va falloir maintenant que je me connecte à la base de donnée afin de pouvoir savoir si l'utilisateur qui souhaite se connecter est connu dans la base. Pour cela je vais utiliser l'objet PDO. Il me faut donc un Data Source Name:
            $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
            // Je peux créé mon objet PDO:
            $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
            // A l'aide de cet objet je vais pouvoir vérifier si l'email saisi est connu dans la base de donnée. Pour cela j'utilise la classe UserRepository que j'ai crée et sa fonction countUserWithThisEmail. Cette fonction nous retourne un booléen. Si l'utilisateur est connu (vrai) le script continue sinon une exception est levée:
            $userRepository = new UserRepository($db);
            if ($userRepository->countUserWithThisEmail($_POST['emailWritten'])) {
                // L'utilisateur est donc connu. Je dois maintenant vérifier que le mot de passe saisi corresponde bien à celui enregistré dans la base de données. Pour cela toujours à l'aide de ma variable $userRepository contenant une instance de ma classe UserRepository, j'utilise la fonction getPasswordWithThisEmail. Cette fonction nous retournera le mot de passe de l'utilisateur:
                $passwordRetrieved = $userRepository->getPasswordWithThisEmail($_POST['emailWritten']);
                // A l'aide de la fonction PHP password_verify nous allons maintenant comparer le mot de passe récupérer et le mot de passe saisi. Si ils sont égaux alors le script continue sinon une exception est lancée:
                if (password_verify($_POST['passwordWritten'], $passwordRetrieved)) {
                    // Il me faut maintenant récupérer le role de l'utilisateur. En effet, la page d'administrtaion de cette application ne doit être accessible qu'aux utilisateurs de role 'ROLE_ADMIN'. A l'aide de ma variable $userRepository et de sa fonction getUserRoleIdWithThisEmail je récupère tout d'abord l'id de mon rôle:
                    $roleIdRetrieved = $userRepository->getUserRoleIdWithThisEmail($_POST['emailWritten']);
                    // L'étape suivante consiste à récupérer le nom du rôle grâce à son id. Pour cela je vais créé une nouvelle instance de la classe RoleRepository que j'ai créé. A l'aide de la fonction getUserRoleWithThisRoleId je vais récupérer le nom du rôle de mon utilisateur. Si le nom du rôle récupéré est égal à ROLE_ADMIN alors le script continue sinon une exception est levée:
                    $roleRepository = new RoleRepository($db);
                    $roleRetrieved = $roleRepository->getUserRoleWithThisRoleId($roleIdRetrieved);
                    if ($roleRetrieved == 'ROLE_ADMIN') {
                        // A ce stade, je suis sûr que l'utilisateur connecté est connu dans ma base de données, que son mot de passe est le bon et qu'il a le bon rôle. Je décide de stocker dans la superglobale S_SESSION des informations qui me serviront dans mes différents scripts d'administration:
                        $_SESSION['userEmail'] = $_POST['emailWritten'];
                        $_SESSION['userRole'] = 'ROLE_ADMIN';
                        // Maintenant je peux diriger l'utilisateur vers la page d'accueil de l'espace administration:
                        header('Location: homeView.php');
                    } else {
                        throw new Exception('Vous n\'avez pas les droits d\'accès à l\'espace d\'administration.');
                    }
                } else {
                    throw new Exception('Le mot de passe saisi est incorrect. Connexion impossible.');
                }
            } else {
                throw new Exception('L\'email saisi n\'est pas connu. Connexion impossible.');
            }
        } else {
            throw new Exception('Veuillez saisir tous les champs du formulaire.');
        }
    }
} catch (Exception $exeption) {
    $formMessage = $exeption->getMessage();
}
