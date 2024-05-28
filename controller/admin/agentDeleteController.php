<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/AgentRepository.php');
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
                // Avant de supprimer mon agent, il est stipulé dans l'énoncé du devoir qu'une mission doit avoir 1ou plusieurs agents. Mon agent n'ayant pas de référence dans la table mission, il faut que j'empêche "manuellement" la suppression de mon agent si celui ci est le dernier affecté à la mission. Je vais pour cela dans un premier temps avoir besoin de me connecter à la base de données:
                $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
                //Je me connecte à la base de données:
                $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
                // J'instancie un nouvel objet de ma classe AgentRepository:
                $agentRepository = new AgentRepository($db);
                // J'utilise la fonction getMissionIdOfThisAgent de ma classe afin de récupérer l'id de la mission sur lequel mon agent est affecté:
                $missionId = $agentRepository->getMissionIdOfThisAgent($_GET['id']);
                // Maintenant je compte les agents affectés sur cette mission à l'aide de la fonction countAgentIOfThisMission de ma classe AgentRepository. Si je n'ai qu'un seul agent affecté sur cette mission alors je lance une exception sinon je supprime l'agent:
                if ($agentRepository->countAgentIOfThisMission($missionId) == false) {
                    throw new Exception('Suppression impossible. Cet agent est le dernier agent affecté à la mission concernée.');
                } else {
                    // J'utilise la fonction deleteThisAgentWithThisId() afin de supprimer mon agent:
                    $agentRepository->deleteThisAgentWithThisId($_GET['id']);
                    // Si une erreur se déroule dans la suppression de l'agent une erreur est levée. Si au contraire cette suppression se passe bien je dirige l'administrateur vers la page qui liste les agents et où il verra que la suppression s'est bien faite:
                    header('Location: agentListView.php');
                }
            } else {
                // Si l'administrateur clique sur "non" alors je le redirige vers la page qui liste les agents:
                header('Location: agentListView.php');
            }
        }
    } catch (Exception $exception) {
        $agentDeleteViewMessage = $exception->getMessage();
    }
}
