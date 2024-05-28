<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../Model/MissionTypeRepository.php');
require_once('../../Model/MissionType.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // A la validation du formulaire:
        if (isset($_POST['missionTypeFormSubmit'])) {
            // Première chose que je souhaite vérifier est que le champ de saisie ne soit pas vide. Si ce n'est pas le cas, le script continue, sinon une exeption est lancée:
            if (!empty($_POST['missionTypeWritten'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans le champ de saisie, je "transforme" la saisie de mon utilisateur en un code "sécurisé":
                $missionTypeWritten = htmlspecialchars($_POST['missionTypeWritten']);
                // Afin d'être sûr d'avoir toujours notre type de mission écrit avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de formater la saisie de mon utilisateur:
                $missionTypeWrittenFormated = ucfirst(strtolower($missionTypeWritten));
                // A la création de notre base de données nous avons indiqué que le champ "name" de la table "mission_type" était une chaine de caractères de maximum 50 caractères. Il faut donc que je vérifie que le type de statut saisi par l'utilisateur ne fasse pas plus de 50 caractères. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($missionTypeWrittenFormated) <= 50) {
                    // La saisie de notre utilisateur est maintenant sécurisée et dans le bon format. Je vais pouvoir maintenant enregistrer celle-ci dans la base de données. 
                    // Avant d'enregistrer le type de mission dans la base de données, celui-ci a besoin d'un id. Dans notre base de données, ce champ doit être une chaine de caractères de 36 caractères. En effet, la fonction UUID de mysql permet de créer cette chaîne. Sauf erreur de ma part, php (sans framework ou librairie) ne possède pas de fonction permettant de créer un UUID. Je vais donc utiliser la fonction uniqid de PHP afin de parer à ce petit souci:
                    $prefix = uniqid();
                    $id = uniqid($prefix, true);
                    // Je peux instancier ma classe MissionType afin de créer un nouvel objet:
                    $missionType = new MissionType($id, $missionTypeWrittenFormated);
                    // Ceci fait, je vais maintenant pouvoir enregistrer ce type de mission (avec son id) dans la base de données. Pour ce faire, il faut tout d'abord que je me connecte à la base de données. Pour cela je vais utiliser l'objet PDO. Il me faut donc tout d'abord créer mon Data Source Name:
                    $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
                    // Je me connecte à la base de données:
                    $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
                    // Afin d'enregistrer le type de mission  dans la base de données je vais utiliser la classe MissionTypeRepository que j'ai créé et plus particulièrement sa fonction addThisMissionType:
                    $missionTypeRepository = new MissionTypeRepository($db);
                    $missionTypeRepository->addThisMissionType($missionType);
                    // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisMissionType). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                    header('Location: homeView.php');
                } else {
                    throw new Exception('Le type de mission saisi ne doit pas dépasser 50 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir le champ.');
            }
        }
    } catch (Exception $exception) {
        $missionTypeFormMessage = $exception->getMessage();
    }
}
