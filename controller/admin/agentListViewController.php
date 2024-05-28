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
        // Le but de ce contrôleur est de récupérer les agents enregistrés dans la base de données. Pour cela, il va falloir que je me connecte à la base de données et il me faut donc dans un premier temps créé mon Data Source Name:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        // Celui-ci créé, je peux maintenant me connecter à la base de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Afin de récupérer les données, je vais utiliser la classe AgentRepository et plus particulièrement sa fonction getAllAgents(). Un agent possède de multiples "propriétés". Pour afficher la liste des agents, je décide de n'afficher que le prénom et le nom des ces dernières:
        $agentRepository = new AgentRepository($db);
        // Cette fonction retourne dans tous les cas un tableau. Celui-ci peut être vide ou pas. Je décide de gérer ces deux états dans la vue de ce contrôleur.
        $allAgentIdentities = $agentRepository->getAllAgents();
    } catch (Exception $exception) {
        $agentListViewMessage = $exception->getMessage();
    }
}
