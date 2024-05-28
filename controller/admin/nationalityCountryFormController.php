<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../Model/NationalityCountryRepository.php');
require_once('../../Model/NationalityCountry.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // A la validation du formulaire:
        if (isset($_POST['nationalityCountryFormSubmit'])) {
            // Première chose que je souhaite vérifier est que les champs de saisie ne soientt pas vides. Si ce n'est pas le cas, le script continue, sinon une exeption est lancée:
            if (!empty($_POST['nationalityWritten']) && !empty($_POST['countryWritten'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" la saisie de mon utilisateur en un code "sécurisé":
                $nationalityWritten = htmlspecialchars($_POST['nationalityWritten']);
                $countryWritten = htmlspecialchars($_POST['countryWritten']);
                // Afin d'être sûr d'avoir toujours notre nationalité et notre pays écrits avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de formater la saisie de mon utilisateur:
                $nationalityWrittenFormated = ucfirst(strtolower($nationalityWritten));
                $countryWrittenFormated = ucfirst(strtolower($countryWritten));
                // A la création de notre base de données nous avons indiqué que les champs "name" et country de la table "nationality_country" étaient des chaines de caractères de maximum 50 caractères. Il faut donc que je vérifie que la nationalité et le pays saisis par l'utilisateur ne fasse pas plus de 50 caractères. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($nationalityWrittenFormated) <= 50 && strlen($countryWrittenFormated) <= 50) {
                    // La saisie de notre utilisateur est maintenant sécurisée et dans le bon format. Je vais pouvoir maintenant enregistrer celle-ci dans la base de données. 
                    // Avant d'enregistrer la nationalité et son pays dans la base de données, j'ai besoin d'un id. Dans notre base de données, ce champ doit être une chaine de caractères de 36 caractères. En effet, la fonction UUID de mysql permet de créer cette chaîne. Sauf erreur de ma part, php (sans framework ou librairie) ne possède pas de fonction permettant de créer un UUID. Je vais donc utiliser la fonction uniqid de PHP afin de parer à ce petit souci:
                    $prefix = uniqid();
                    $id = uniqid($prefix, true);
                    // Je peux instancier ma classe NationalityCountry afin de créer un nouvel objet:
                    $nationalityCountry = new NationalityCountry($id, $nationalityWrittenFormated, $countryWrittenFormated);
                    // Ceci fait, je vais maintenant pouvoir enregistrer cette nationalité et son pays (avec son id) dans la base de données. Pour ce faire, il faut tout d'abord que je me connecte à la base de données. Pour cela je vais utiliser l'objet PDO. Il me faut donc tout d'abord créer mon Data Source Name:
                    $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
                    // Je me connecte à la base de données:
                    $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
                    // Afin d'enregistrer la nationalité et son pays dans la base de données je vais utiliser la classe NationalityCountryRepository que j'ai créé et plus particulièrement sa fonction addThisNationalityCountry:
                    $nationalityCountryRepository = new NationalityCountryRepository($db);
                    $nationalityCountryRepository->addThisNationalityCountry($nationalityCountry);
                    // Si l'ajout dans la base de données, ne se fait pas, une erreur est levée (voir fonction addThisNationalityCountry). Au contraire si l'ajout se fait bien, je redirige l'utilisateur sur la page d'accueil de l'espace administration:
                    header('Location: homeView.php');
                } else {
                    throw new Exception('La nationalité et le pays saisis ne doivent pas dépasser 50 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir tous les champs.');
            }
        }
    } catch (Exception $exception) {
        $nationalityCountryFormMessage = $exception->getMessage();
    }
}
