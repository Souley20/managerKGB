<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/ContactRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le systeme de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Je vérifie que l'administrateur est bien cliqué sur l'un des boutons:
        if (isset($_GET['confirm'])) {
            // Si l'administrateur clique sur le bouton "oui":
            if ($_GET['confirm'] == 'yes') {
                // Avant de supprimer mon contact, il est stipulé dans l'énoncé du devoir qu'une mission doit avoir 1ou plusieurs contacts. Mon contact n'ayant pas de référence dans la table mission, il faut que j'empêche "manuellement" la suppression de mon contact si celui ci est le dernier affecté à la mission. Je vais pour cela dans un premier temps avoir besoin de me connecter à la base de données:
                $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
                //Je me connecte à la base de données:
                $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
                // J'instancie un nouvel objet de ma classe ContactRepository:
                $contactRepository = new ContactRepository($db);
                // J'utilise la fonction getMissionIdOfThisContact de ma classe afin de récupérer l'id de la mission sur lequel mon contact est affecté:
                $missionId = $contactRepository->getMissionIdOfThisContact($_GET['id']);
                // Maintenant je compte les contacts affectés sur cette mission à l'aide de la fonction countContactOfThisMission de ma classe ContactRepository. Si je n'ai qu'un seul contact affecté sur cette mission alors je lance une exception sinon je supprime le contact:
                if ($contactRepository->countContactOfThisMission($missionId) == false) {
                    throw new Exception('Suppression impossible. Ce contact est le dernier contact affecté à la mission concernée.');
                } else {
                    // J'utilise la fonction deleteThisContactWithThisId() afin de supprimer mon contact:
                    $contactRepository->deleteThisContactWithThisId($_GET['id']);
                    // Si une erreur se déroule dans la suppression du contact une erreur est levée. Si au contraire cette suppression se passe bien je dirige l'administrateur vers la page qui liste les contacts et où il verra que la suppression s'est bien faite:
                    header('Location: contactListView.php');
                }
            } else {
                // Si l'administrateur clique sur "non" alors je le redirige vers la page qui liste les contacts:
                header('Location: contactListView.php');
            }
        }
    } catch (Exception $exception) {
        $contactDeleteViewMessage = $exception->getMessage();
    }
}
