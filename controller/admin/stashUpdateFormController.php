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
        // Et enfin je récupère les données à l'aide de la fonction getAllTitlesMissions. A savoir que cette fonction retourne assurément un tableau. Celui-ci peut contenir des données ou ne pas en contenir. Je décide de gérer ces deux états dans la vue de ce controller (stashUpdateFormView.php):
        $allMissionsData = $missionRepository->getAllTitlesMissions();
        // Afin d'afficher les données de la planque que l'administrateur souhaite modifier dans les différents champs du formulaire, il faut que j'aille récupérer l'ensemble des données d'une planque dans la base de données. Pour cela je crée un nouvel objet de ma classe StashRepository:
        $stashRepository = new StashRepository($db);
        // Et maintenant  je récupére les données de la planque grâce à son id (présent dans l'url de la requête) à l'aide de la fonction getAllStashDatasWithThisId(). Cette fonction retourne un tableau. Celui-ci peut être vide ou avec des données. Je décide de gérer ces deux états dans la vue de mon controller:
        $stashDatasRetrieved = $stashRepository->getAllStashDatasWithThisId($_GET['id']);
        // J'ai maintenant toutes les données pour un affichage correct de mon formulaire. Il faut maintenant que je m'occupe de la soumission du formulaire.
        // A la validation du formulaire:
        if (isset($_POST['stashUpdateFormSubmit'])) {
            // Etant donné que les champs de saisie à l'affichage de notre page seront pré-rempli par les valeurs récupérées, normalement il y a peu de risque qu'à la validation ce dernier soit vide. Cependant l'administrateur peut par erreur supprimer une des données d'un champ. Je décide donc dans un premier temps de vérifier que les champs ne sont pas vides. Si c'est le cas une exception est levée:
            if (!empty($_POST['addressWritten']) && !empty($_POST['typeWritten']) && !empty($_POST['missionIdSelected']) && !empty($_POST['countryIdSelected'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" les saisies de mon utilisateur en un code "sécurisé":
                $addressWritten = htmlspecialchars($_POST['addressWritten']);
                $typeWritten = htmlspecialchars($_POST['typeWritten']);
                // Afin d'être sûr d'avoir toujours nos champs de saisie écrits avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de les formater. Cependant, je décide de ne pas formater mon champ address afin de garder le 'format' de la ville etc etc...
                $typeWrittenFormated = ucfirst(strtolower($typeWritten));
                // A la création de notre base de données nous avons indiqué que les champs "address" et "type" de la table "stash" étaient une chaine de caractères de maximum 255 caractères,. Il faut donc que je vérifie que les informations saisies par l'utilisateur ne fasse pas plus de 255 caractères pour ces deux champs. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($addressWritten) <= 100 && strlen($typeWrittenFormated) <= 255) {
                    // Il me faut maintenant respecter la régle métier de l'énoncé du devoir qui dit que la planque doit être située dans le pays de la mission. Pour cela je vais utiliser la fonction getMissionCountryIdWithThisMissionId de ma classe MissionRepository.
                    $countryId = $missionRepository->getMissionCountryIdWithThisMissionId($_POST['missionIdSelected']);
                    // Cette fonction va nous retourner (dans le cas où il n'y a d'erreur) l'id du pays de la mission. Si celui-ci est égal avec l'id de la nationalité du contact alors le script continue, sinon une erreur est levée:
                    if ($countryId != $_POST['countryIdSelected']) {
                        throw new Exception('La planque et la mission doivent être dans le même pays.');
                    }
                    // J'ai maintenant toutes les informations nécessaires pour pouvoir mettre à jour la planque dans ma base de données. Je vais pour cela utiliser ma classe "Stash" afin de créer une instance de cette classe:
                    $stash = new Stash($_GET['id'], $addressWritten, $typeWrittenFormated, $_POST['missionIdSelected'], $_POST['countryIdSelected']);
                    // Je peux maintenant utiliser la fonction updateThisStash de ma classe StashRepository afin de mettre à jour les données dans ma base de données:
                    $stashRepository->updateThisStash($stash);
                    // Si une erreur se déroule dans la mise à jour de la planque une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les planques et où il verra que la modification s'est bien faite:
                    header('Location: stashListView.php');
                } else {
                    throw new Exception('L\'adresse de votre planque et son type ne doivent pas dépasser 255 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs du formulaire.');
            }
        }
    } catch (Exception $exception) {
        $stashUpdateFormMessage = $exception->getMessage();
    }
}
