<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/SpecialityRepository.php');
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
                // Afin de supprimer ma spécialité je vais avoir besoin de me connecter à la base de données:
                $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
                //Je me connecte à la base de données:
                $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
                // J'instancie un nouvel objet de ma classe SpecialityRepository:
                $specialityRepository = new SpecialityRepository($db);
                // Et j'utilise la fonction deleteThisSpecialityWithThisId() afin de supprimer ma spécialité:
                $specialityRepository->deleteThisSpecialityWithThisId($_GET['id']);
                // Si une erreur se déroule dans la suppression de la spécialité une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les spécialités et où il verra que la modification s'est bien faite:
                header('Location: specialityListView.php');
            } else {
                // Si l'administrateur clique sur "non" alors je le redirige vers la page qui liste les spécialtés:
                header('Location: specialityListView.php');
            }
        }
    } catch (Exception $exception) {
        $specialityDeleteViewMessage = $exception->getMessage();
    }
}
