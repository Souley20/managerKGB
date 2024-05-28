<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../Model/NationalityCountryRepository.php');
require_once('../../model/MissionRepository.php');
require_once('../../model/Stash.php');
require_once('../../model/StashRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Dans le formulaire affiché par la vue de ce contrôleur, j'ai deux champs qui sont des  listes déroulantes. Ces listes déroulantes affichent respectivement la liste des pays et la liste des missions. Ces informations sont disponibles dans la base de données.
        // Pour cela je vais avoir besoin de me connecter à ma base de données avec PDO et donc dans un premier je dois créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        //Je me connecte à la base de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Je commence par instancier ma classe NationalityCountryRepository:
        $nationalityCountryRepository = new NationalityCountryRepository($db);
        // Et j'utilise la fonction getAllNationalitiesCountries() pour récupérer la liste des pays:
        $allCountriesData = $nationalityCountryRepository->getAllNationalitiesCountries();
        // Maintenant je peux instancier ma classe MissionRepository:
        $missionRepository = new MissionRepository($db);
        // Et enfin je récupère les données à l'aide de la fonction getAllTitlesMissions. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (stashFormView.php):
        $allMissionsData = $missionRepository->getAllTitlesMissions();
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['stashFormSubmit'])) {
            // Première chose que je souhaite vérifier est que tous les champs de mon formulaire soient renseignés. Si ce n'est pas le cas, le script continue, sinon une exception est lancée:
            if (!empty($_POST['addressWritten']) && !empty($_POST['typeWritten']) && !empty($_POST['missionIdSelected']) && !empty($_POST['countryIdSelected'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" les saisies de mon utilisateur en un code "sécurisé":
                $addressWritten = htmlspecialchars($_POST['addressWritten']);
                $typeWritten = htmlspecialchars($_POST['typeWritten']);
                // Afin d'être sûr d'avoir toujours nos champs de saisie écrits avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de les formater. Cependant, je décide de ne pas formater mon champ address afin de garder le 'format' de la ville etc etc...
                $typeWrittenFormated = ucfirst(strtolower($typeWritten));
                // A la création de notre base de données nous avons indiqué que les champs "address" et "type" de la table "stash" étaient une chaine de caractères de maximum 255 caractères,. Il faut donc que je vérifie que les informations saisies par l'utilisateur ne fasse pas plus de 255 caractères pour ces deux champs. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($addressWritten) <= 100 && strlen($typeWrittenFormated) <= 255) {
                    // Les saisies de notre utilisateur sont maintenant sécurisées et dans le bon format. Il me faut maintenant respecter la régle métier de l'énoncé du devoir qui dit que la planque doit être située dans le pays de la mission. Pour cela je vais utiliser la fonction getMissionCountryIdWithThisMissionId de ma classe MissionRepository.
                    $countryId = $missionRepository->getMissionCountryIdWithThisMissionId($_POST['missionIdSelected']);
                    // Cette fonction va nous retourner (dans le cas où il n'y a d'erreur) l'id du pays de la mission. Si celui-ci est égal avec l'id de la nationalité du contact alors le script continue, sinon une erreur est levée:
                    if ($countryId != $_POST['countryIdSelected']) {
                        throw new Exception('La planque et la mission doivent être dans le même pays.');
                    }
                    // Je vais pouvoir maintenant enregistrer les données de ma planque dans la base de données. 
                    // Avant d'enregistrer la planque dans la base de données, celle-ci a besoin d'un code. Dans notre base de données, ce champ doit être un nombre entier de maximum 11 caractères. Il y a pleins de façon de faire pour générer ce code. Je choisi d'utiliser la fonction rand() de php:
                    $code = rand(1, 2147483647);
                    // J'ai maintenant toutes les informations nécessaires pour pouvoir créer une planque dans ma base de données. Je vais pour cela utiliser ma classe "Stash" afin de créer une instance de cette classe:
                    $stash = new Stash($code, $addressWritten, $typeWrittenFormated, $_POST['missionIdSelected'], $_POST['countryIdSelected']);
                    // Je peux maintenant utiliser la fonction addThisStash de ma classe StashRepository afin d'ajouter les données dans ma base de données:
                    $stashRepository = new StashRepository($db);
                    $stashRepository->addThisStash($stash);
                    // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisStash). Au contraire si l'ajout se fait bien, je redirige l'administrateur sur la page d'accueil de l'espace administration:
                    header('Location: homeView.php');
                } else {
                    throw new Exception('L\'adresse de votre planque et son type ne doivent pas dépasser 255 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $stashFormMessage = $exception->getMessage();
    }
}
