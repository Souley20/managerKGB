<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/AgentRepository.php');
require_once('../../model/SpecialityRepository.php');
require_once('../../model/AgentSpeciality.php');
require_once('../../model/AgentSpecialityRepository.php');
require_once('../../Model/MissionRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Dans le formulaire affiché par la vue de ce contrôleur, j'ai deux champs qui sont des listes déroulantes. Ces listes déroulantes affichent en matière de choix respectivement les agents et les spécialités. Ces informations sont disponibles dans la base de données. Je vais donc aller chercher ces informations à l'aide des classes qui gérent chacune de ces informations. 
        // Pour cela je vais avoir besoin de me connecter à ma base de données avec PDO et donc dans un premier je dois créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        //Je me connecte à la base de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Maintenant je peux instancier ma classe AgentRepository:
        $agentRepository = new AgentRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllAgents. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (agentSpecialityFormView.php):
        $allAgentsData = $agentRepository->getAllAgents();
        // Maintenant je peux instancier ma classe SpecialityRepository:
        $specialityRepository = new SpecialityRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllSpecialities. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (agentSpecialityFormView.php):
        $allSpecialitiesData = $specialityRepository->getAllSpecialities();
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['agentSpecialityFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exeption est lancée:
            if (!empty($_POST['agentIdSelected']) && !empty($_POST['specialityIdSelected'])) {
                // J'ai maintenant toutes les informations nécessaires pour insérer les données dans la base de données. Avant cela, il faut que je respecte la règle métier de mon devoir qui dit que pour une mission au moins 1 agent doit avoir la spécialité de cette mission. Pour faire cela, je vais avoir besoin de récupérer l'id de la mission sur laquelle mon agent est affecté. Pour cela j'utilise la fonction getMissionIdOfThisAgent de la classe AgentRepository:
                $missionId = $agentRepository->getMissionIdOfThisAgent($_POST['agentIdSelected']);
                // Je vais avoir besoin ensuite de l'id de la spécialité requise pour cette mission ainsi que du titre de la spécialité. J'utilise pour cela la fonction getSpecialityDatasOfThisMissionWithThisId de la classe MissionRepositiory:
                $missionRepository = new MissionRepository($db);
                $specialityDatas = $missionRepository->getSpecialityDatasOfThisMissionWithThisId($missionId);
                // J'instancie maintemant ma classe AgentSpecialityRepository dont je vais avoir besoin:
                $agentSpecialityRepository = new AgentSpecialityRepository($db);
                // Si avec l'agent sélectionné par l'administrateur, la spécialité requise pour ma mission est égale à la spécialité saisie par l'administrateur alors, de fait, ma mission aura bien au moins 1 agent avec la spécialité requise. Il faut donc que je gère le cas contraire:
                if ($specialityDatas['id'] != $_POST['specialityIdSelected']) {
                    // Je commence par lister tous les agents affectés sur ma mission:
                    $agentIds = $agentRepository->getAgentIdsOfThisMission($missionId);
                    // Je crée une variable qui va compter les agents avec la spécialité requise de ma fonction:
                    $count = 0;
                    // Pour chaque agent afféctés sur ma mission:
                    foreach ($agentIds as $key => $agentId) {
                        // Si il possède la spécialité requise, j'incrémente mon compteur:
                        if ($agentSpecialityRepository->countAgentWithThisAgentIdAndThisSpecialityId($agentId, $specialityDatas['id']) == true) {
                            $count++;
                        }
                    }
                    // Si il n'y a pas d'agents avec la bonne spécialité alors je lance une exception:
                    if ($count == 0) {
                        throw new Exception('Votre agent doit avoir la spécialité de la mission pour lequel il est affecté: ' . $specialityDatas['name']);
                    }
                }
                // A ce stade je peux instancier ma classe AgentSpeciality:
                $agentSpeciality = new AgentSpeciality($_POST['agentIdSelected'], $_POST['specialityIdSelected']);
                // Afin d'enregistrer la spécialité d'un agent dans la base de données je vais utiliser la classe AgentSpecialityRepository que j'ai créé et plus particulièrement sa fonction addThisAgentSpeciality():
                $agentSpecialityRepository->addThisAgentSpeciality($agentSpeciality);
                // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisAgentSpeciality). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                header('Location: homeView.php');
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $agentSpecialityFormMessage = $exception->getMessage();
    }
}
