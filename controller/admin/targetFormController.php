<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/NationalityCountryRepository.php');
require_once('../../model/MissionRepository.php');
require_once('../../model/AgentRepository.php');
require_once('../../model/Target.php');
require_once('../../model/TargetRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Dans le formulaire affiché par la vue de ce contrôleur, j'ai deux champs qui sont des listes déroulantes. Ces listes déroulantes affichent en matière de choix respectivement les nationalités et les missions. Ces informations sont disponibles dans la base de données. Je vais donc aller chercher ces informations à l'aide des classes qui gérent chacune de ces informations. 
        // Pour cela je vais avoir besoin de me connecter à ma base de données avec PDO et donc dans un premier je dois créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        //Je me connecte à la base de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Maintenant je peux instancier ma classe NationalityCountryRepository:
        $nationalityCountryRepository = new NationalityCountryRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllNationality. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (targetFormView.php):
        $allNationalitiesData = $nationalityCountryRepository->getAllNationalitiesCountries();
        // A ce stade, j'ai obtenu les données dont j'ai besoin pour alimenter mon champ de saisie de la nationalité. Il me faut maintenant faire la même chose pour la mission. J'utilise donc la classe MissionRepository:
        $missionRepository = new MissionRepository($db);
        // Comme pour les nationalités, cette fonction retourne un tableau. Celui-ci peut être vide ou avec des données. Je décide de gérer ces deux états dans la vue de mon controller:
        $allMissionsData = $missionRepository->getAllTitlesMissions();
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['targetFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exception est lancée:
            if (!empty($_POST['firstnameWritten']) && !empty($_POST['lastnameWritten']) && !empty($_POST['dateOfBirthSelected']) && !empty($_POST['nationalityIdSelected']) && !empty($_POST['missionIdSelected'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" les saisies de mon utilisateur en un code "sécurisé":
                $firstnameWritten = htmlspecialchars($_POST['firstnameWritten']);
                $lastnameWritten = htmlspecialchars($_POST['lastnameWritten']);
                // Afin d'être sûr d'avoir toujours la prénom de notre cible avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de le formater:
                $firstnameWrittenFormated = ucfirst(strtolower($firstnameWritten));
                // Afin d'être sûr d'avoir toujours le nom de notre cible avec le même format (Lettre capitale), je décide de le formater:
                $lastnameWrittenFormated = strtoupper($lastnameWritten);
                // Il faut donc que j'instancie 1 objet Datetime avec en paramètre la date saisie par l'utilisateur:
                $dateOfBirth = new \DateTime($_POST['dateOfBirthSelected']);
                // A la création de notre base de données nous avons indiqué que les champs "lastname" et "firstname" de la table "target" étaient une chaine de caractères de maximum 100 caractères,. Il faut donc que je vérifie que les informations saisies par l'utilisateur ne fasse pas plus de 100 caractères pour ces deux champs. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($firstnameWrittenFormated) <= 100 && strlen($lastnameWrittenFormated) <= 100) {
                    // Les saisies de notre utilisateur sont maintenant sécurisées et dans le bon format. Dans l'énoncé du devoir il m'est demandé que ma cible ne peut pas avoir la même nationalité que le ou les agents affectés sur la mission. Il faut que je vérifie maintenant que la saisie de mon administrateur respecte bien cette règle métier. Je vais faire cela en instanciant ma classe AgentRepository et en utilisant sa fonction countAgentWithThisNationalityAndThisNationalityAndThisMission():
                    $agentRepository = new AgentRepository($db);
                    if ($agentRepository->countAgentWithThisNationalityAndThisMission($_POST['nationalityIdSelected'], $_POST['missionIdSelected']) == false) {
                        throw new Exception('Impossible d\'affecter cette cible sur cette mission car un ou des agents présents sur cette mission possèdent la même nationalité.');
                    }
                    // Ceci fait et avant d'enregistrer la cible dans la base de données, celle-ci a besoin d'un id. Dans notre base de données, ce champ doit être une chaine de caractères de 36 caractères. En effet, la fonction UUID de mysql permet de créer cette chaîne. Sauf erreur de ma part, php (sans framework ou librairie) ne possède pas de fonction permettant de créer un UUID. Je vais donc utiliser la fonction uniqid de PHP afin de parer à ce petit souci:
                    $prefix = uniqid();
                    $id = uniqid($prefix, true);
                    // La cible que je suis en train de créé doit avoir un code identité (identity_code dans la table). J'ai décidé de ne pas faire saisir ce code à travers le formulaire mais plutôt de l'automatiser à travers de ce script. Ce code aura un format chaine de caractère + un nombre. Pour la chaine de caractère, étant donné que nous allons rentrer une cible je décide de l'appeller target:
                    $identityCodePrefix = 'Target ';
                    // Pour le nombre, je décide d'utiliser la fonction rand() avec en paramètre un nombre entre 1 et 10000:
                    $identityCodeSuffix = rand(1, 10000);
                    // Je construis maintenant mon code d'identité:
                    $identityCode = $identityCodePrefix . $identityCodeSuffix;
                    // Je peux instancier ma classe Target afin de créer un nouvel objet:
                    $target = new Target($id, $firstnameWrittenFormated, $lastnameWrittenFormated, $dateOfBirth, $identityCode, $_POST['nationalityIdSelected'], $_POST['missionIdSelected']);
                    // Afin d'enregistrer la cible dans la base de données je vais utiliser la classe TargetRepository que j'ai créé et plus particulièrement sa fonction addThisTarget():
                    $targetRepository = new TargetRepository($db);
                    $targetRepository->addThisTarget($target);
                    // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisTarget). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                    header('Location: homeView.php');
                } else {
                    throw new Exception('Le prénom et le nom de la cible ne doivent pas dépasser 100 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $targetFormMessage = $exception->getMessage();
    }
}
