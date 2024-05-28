<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/NationalityCountryRepository.php');
require_once('../../model/SpecialityRepository.php');
require_once('../../model/MissionTypeRepository.php');
require_once('../../model/MissionStatusRepository.php');
require_once('../../model/Mission.php');
require_once('../../model/MissionRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Dans le formulaire affiché par la vue de ce contrôleur, j'ai quatre champs qui sont des listes déroulantes. Ces listes déroulantes affichent en matière de choix respectivement les pays, les spécialités, les types de mission et les statuts de la mission. Ces informations sont disponibles dans la base de données. Je vais donc aller chercher ces informations à l'aide des classes qui gérent chacune de ces informations. 
        // Pour cela je vais avoir besoin de me connecter à ma base de données avec PDO et donc dans un premier je dois créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        //Je me connecte à la base de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Je commance par aller chercher la liste des pays ou peut se dérouler une mission. Pour cela il faut dans un premier temps que j'instancie ma classe NationalityCountryRepository:
        $nationalityCountryRepository = new NationalityCountryRepository($db);
        // Cette foncttion retourne dans tout les cas un tableau qui peut etre vide ou non. Je décide de gérer ces deux états dans la vue de mon controleur (missionFormView.php):
        $allCountriesData = $nationalityCountryRepository->getAllNationalitiesCountries();
        // Maintenant je peux instancier ma classe SpecialityRepository:
        $specialityRepository = new SpecialityRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllSpecialities. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (missionFormView.php):
        $allSpecialitiesData = $specialityRepository->getAllSpecialities();
        // A ce stade, j'ai obtenu les données dont j'ai besoin pour alimenter mon champ de saisie de la spécialité. Il me faut maintenant faire la même chose pour le type de mission. J'utilise donc la classe MissionTypeRepository:
        $missionTypeRepository = new MissionTypeRepository($db);
        // Comme pour les spécialités, cette fonction retourne un tableau. Celui-ci peut être vide ou avec des données. Je décide de gérer ces deux états dans la vue de mon controller:
        $allMissionTypeData = $missionTypeRepository->getAllMissionType();
        // Pour finir je m'attaque maintenant aux données du champ statut de mission. J'utilise donc la classe MissionStatusRepository:
        $missionStatusRepository = new MissionStatusRepository($db);
        // Et je récupère les données à l'aide de la fonction getAllStatusMission. Là aussi je gère la présence de données ou non dans la vue du controller:
        $allMissionStatusData = $missionStatusRepository->getAllStatusMission();
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['missionFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exeption est lancée:
            if (!empty($_POST['titleWritten']) && !empty($_POST['codeNameWritten']) && !empty($_POST['descriptionWritten']) && !empty($_POST['countryIdSelected']) && !empty($_POST['missionStartSelected']) && !empty($_POST['missionEndSelected']) && !empty($_POST['specialityIdSelected']) && !empty($_POST['missionTypeIdSelected']) && !empty($_POST['missionStatusIdSelected'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" les saisies de mon utilisateur en un code "sécurisé":
                $titleWritten = htmlspecialchars($_POST['titleWritten']);
                $codeNameWritten = htmlspecialchars($_POST['codeNameWritten']);
                $descriptionWritten = htmlspecialchars($_POST['descriptionWritten']);
                // Afin d'être sûr d'avoir toujours nos champs de saisie écrits avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de les formater:
                $titleWrittenFormated = ucfirst(strtolower($titleWritten));
                $codeNameWrittenFormated = ucfirst(strtolower($codeNameWritten));
                $descriptionWrittenFormated = ucfirst(strtolower($descriptionWritten));
                // Les deux champs "mission_start" et "mission_end" de ma table "mission" sont des Datetime. Il faut donc que j'instancie deux objets Datetime avec en paramètre les dates saisies par l'utilisateur:
                $missionStart = new \DateTime($_POST['missionStartSelected']);
                $missionEnd = new \DateTime($_POST['missionEndSelected']);
                // A la création de notre base de données nous avons indiqué que les champs "title" et "code_name" de la table "mission" étaient une chaine de caractères de maximum 100 caractères,. Il faut donc que je vérifie que les informations saisies par l'utilisateur ne fasse pas plus de 100 caractères pour ces deux champs. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($titleWrittenFormated) <= 100 && strlen($codeNameWrittenFormated) <= 100) {
                    // Les saisies de notre utilisateur sont maintenant sécurisées et dans le bon format. Je vais pouvoir maintenant enregistrer celles-ci dans la base de données. 
                    // Avant d'enregistrer la mission dans la base de données, celle-ci a besoin d'un id. Dans notre base de données, ce champ doit être une chaine de caractères de 36 caractères. En effet, la fonction UUID de mysql permet de créer cette chaîne. Sauf erreur de ma part, php (sans framework ou librairie) ne possède pas de fonction permettant de créer un UUID. Je vais donc utiliser la fonction uniqid de PHP afin de parer à ce petit souci:
                    $prefix = uniqid();
                    $id = uniqid($prefix, true);
                    // Je peux instancier ma classe Mission afin de créer un nouvel objet:
                    $mission = new Mission($id, $titleWrittenFormated, $descriptionWrittenFormated, $codeNameWrittenFormated, $missionStart, $missionEnd, $_POST['countryIdSelected'], $_POST['specialityIdSelected'], $_POST['missionTypeIdSelected'], $_POST['missionStatusIdSelected']);
                    // Afin d'enregistrer la mission dans la base de données je vais utiliser la classe MissionRepository que j'ai créé et plus particulièrement sa fonction addThisMission:
                    $missionRepository = new MissionRepository($db);
                    $missionRepository->addThisMission($mission);
                    // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisMission). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                    header('Location: homeView.php');
                } else {
                    throw new Exception('Le titre de votre mission et son code ne doivent pas dépasser 100 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $missionFormMessage = $exception->getMessage();
    }
}
