<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/TargetRepository.php');
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
                // Avant de supprimer ma cible, il est stipulé dans l'énoncé du devoir qu'une mission doit avoir 1ou plusieurs cibles. Ma cible n'ayant pas de référence dans la table mission, il faut que j'empêche "manuellement" la suppression de ma cible si celui ci est la derniére affectée à la mission. Je vais pour cela dans un premier temps avoir besoin de me connecter à la base de données:
                $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
                // Je me connecte à la base de données:
                $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
                // J'instancie un nouvel objet de ma classe TargetRepository:
                $targetRepository = new TargetRepository($db);
                // J'utilise la fonction getMissionIdOfThisTarget de ma classe afin de récupérer l'id de la mission sur lequel ma cible est affectée:
                $missionId = $targetRepository->getMissionIdOfThisTarget($_GET['id']);
                // Maintenant je compte les cibles affectées sur cette mission à l'aide de la fonction countTargetOfThisMission de ma classe TargetRepository. Si je n'ai qu'une seule cible affectée sur cette mission alors je lance une exception sinon je supprime la cible:
                if ($targetRepository->countTargetOfThisMission($missionId) == false) {
                    throw new Exception('Suppression impossible. Cette cible est la dernière cible affectée à la mission concernée.');
                } else {
                    // J'utilise la fonction deleteThisTargetWithThisId() afin de supprimer ma cible:
                    $targetRepository->deleteThisTargetWithThisId($_GET['id']);
                    // Si une erreur se déroule dans la suppression de la cible une erreur est levée. Si au contraire cette suppression se passe bien je dirige l'administrateur vers la page qui liste les cibleset où il verra que la suppression s'est bien faite:
                    header('Location: targetListView.php');
                }
            } else {
                // Si l'administrateur clique sur "non" alors je le redirige vers la page qui liste les cibles:
                header('Location: targetListView.php');
            }
        }
    } catch (Exception $exception) {
        $targetDeleteViewMessage = $exception->getMessage();
    }
}
