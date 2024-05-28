<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../Model/MissionRepository.php');
// Afin de gérer les eventuelles erreurs de mon script je décide de placer ce dernier dans un bloc try..catch:
try {
    // La première chose que je vais devoir fire c'est créer mon DSN afin de pouvoir par la suite me connecter à la base de donnée:
    $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
    // Je peux créer mintenant mon objet PDO:
    $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
    // Je vais maintenant avoir besoin de récupérer l'ensemble des données de toutes les missions. Pour cela je vais créer un nouvel objet de ma classe MissionRepository:
    $missionRepository = new MissionRepository($db);
    // J'utilse ensuite la fonction getAllMissionsDatas de cette classe pour lister l'ensemble des données de toutes les missions. Si ce tableau esr vide, je décide de gérer cet état dans ma view avec un message (voir missionFrontListView.php):
    $allMissionsDatas = $missionRepository->getAllMissionsDatas();
} catch (Exception $exception) {
    $missionListViewMessage = $exception->getMessage();
}
