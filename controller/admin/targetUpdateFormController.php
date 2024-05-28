<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../model/NationalityCountryRepository.php');
require_once('../../model/MissionRepository.php');
require_once('../../model/Target.php');
require_once('../../model/TargetRepository.php');
require_once('../../model/AgentRepository.php');
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
        // Et enfin je récupère les données à l'aide de la fonction getAllNationality. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (targetUpdateFormView.php):
        $allNationalitiesData = $nationalityCountryRepository->getAllNationalitiesCountries();
        // A ce stade, j'ai obtenu les données dont j'ai besoin pour alimenter mon champ de saisie de la nationalité. Il me faut maintenant faire la même chose pour la mission. J'utilise donc la classe MissionRepository:
        $missionRepository = new MissionRepository($db);
        // Comme pour les nationalités, cette fonction retourne un tableau. Celui-ci peut être vide ou avec des données. Je décide de gérer ces deux états dans la vue de mon controller:
        $allMissionsData = $missionRepository->getAllTitlesMissions();
        // Afin d'afficher les données de la cible que l'administrateur souhaite modifier dans les différents champs du formulaire, il faut que j'aille récupérer l'ensemble des données d'une cible dans la base de données. Pour cela je crée un nouvel objet de ma classe TargetRepository:
        $targetRepository = new TargetRepository($db);
        // Et maintenant  je récupére les données de la cible grâce à son id (présent dans l'url de la requête) à l'aide de la fonction getAllTargetDatasWithThisId(). Cette fonction retourne un tableau. Celui-ci peut être vide ou avec des données. Je décide de gérer ces deux états dans la vue de mon controller:
        $targetDatasRetrieved = $targetRepository->getAllTargetDatasWithThisId($_GET['id']);
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['targetUpdateFormSubmit'])) {
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
                        throw new Exception('Impossible de modifier la nationalité de cette cible car un ou des agents présents sur cette mission possèdent la même nationalité.');
                    }
                    // Ceci fait je peux instancier un nouvel objet de ma classe Target:
                    $target = new Target($_GET['id'], $firstnameWrittenFormated, $lastnameWrittenFormated, $dateOfBirth, $targetDatasRetrieved['identityCode'], $_POST['nationalityIdSelected'], $_POST['missionIdSelected']);
                    // Et enfin grâce à la fonction updateThisTarget() de ma classe TargetRepository je met à jour la cible:
                    $targetRepository->updateThisTarget($target);
                    // Si une erreur se déroule dans la mise à jour de la cible une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les cibles et où il verra que la modification s'est bien faite:
                    header('Location: targetListView.php');
                } else {
                    throw new Exception('Le prénom et le nom de la cible ne doivent pas dépasser 100 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $targetUpdateFormMessage = $exception->getMessage();
    }
}
