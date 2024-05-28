<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../Model/MissionRepository.php');
require_once('../Model/AgentRepository.php');
require_once('../Model/ContactRepository.php');
require_once('../Model/TargetRepository.php');
require_once('../Model/StashRepository.php');
// Afin de gérer les eventuelles erreurs de mon script je décide de placer ce dernier dans un bloc try..catch:
try {
    // La première chose que je vais devoir fire c'est créer mon DSN afin de pouvoir par la suite me connecter à la base de donnée:
    $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
    // Je peux créer mintenant mon objet PDO:
    $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
    // Je vais maintenant avoir besoin de récupérer l'ensemble des données d'une mission. Pour cela je vais créer un nouvel objet de ma classe MissionRepository:
    $missionRepository = new MissionRepository($db);
    // J'utilse ensuite la fonction getAllMissionDatasWithThisId de cette classe pour lister l'ensemble des données d'une mission grâce à l'id présent dans mon url. Si ce tableau est vide, je décide de gérer cet état dans ma view avec un message (voir missionDetailView.php):
    $allMissionDatas = $missionRepository->getAllMissionDatasWithThisId($_GET['id']);
    // J'ai à ce stade toutes les données de ma mission. Je souhaite néanmoins afficher les agents, contacts, cibles et planques affectés à cette mission. Je vais commencer par les agents. Pour cela, je vais créer un noivel oblet de ma classe AgentRepository:
    $agentRepository = new AgentRepository($db);
    // J'utilise ensuite la fonction getAllAgentsIdentitiesOfThisMission afin de récupérer l'ensemble des agents affectés à cette mission.
    $allAgentsIdentities = $agentRepository->getAllAgentsIdentitiesOfThisMission($_GET['id']);
    // Je passe maintenant à la récupération des contacts. Je vais donc instancier un nouvel objet de ma classe ContactRepository:
    $contactRepository = new ContactRepository($db);
    // J'utilise ensuite la fonction getAllContactsIdentitiesOfThisMission afin de récupérer l'ensemble des contacts affféctés à cette mission:
    $allContactsIdentities = $contactRepository->getAllContactsIdentitiesOfThisMission($_GET['id']);
    // Je continue avec la récupération des cibles. Je vais donc cette fois-ci instancier un nouvel objet de ma classe TargetRepository:
    $targetRepository = new TargetRepository($db);
    // J'utllise ensuite la fonction getAllTargetIdentitiesOfThisMission afin de récupérer l'ensemble des cibles affectés à cette mission:
    $allTargetsIdentities = $targetRepository->getAllTargetIdentitiesOfThisMission($_GET['id']);
    // Il me reste maintenant à récupérer les planques. J'instancie donc un nouvel objet de ma classe StashRepository:
    $stashRepository = new StashRepository($db);
    // J'utilise maintenant la fonction getAllStashesTypesOfThisMission afin de récuéprer les planques affectées à cette mission:
    $allStashesTypes = $stashRepository->getAllStashesTypesOfThisMission($_GET['id']);
    // Afin de ne pas avoir à gérer 5 tableaux dans ma vue je décide de regrouper ces 5 tableaux dans un seul:
    $allDatas['missionData'] = $allMissionDatas;
    $allDatas['targets'] = $allTargetsIdentities;
    $allDatas['agents'] = $allAgentsIdentities;
    $allDatas['contacts'] = $allContactsIdentities;
    $allDatas['stashes'] = $allStashesTypes;
} catch (Exception $exception) {
    $missionDetailViewMessage = $exception->getMessage();
}
