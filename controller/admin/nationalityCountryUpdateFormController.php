<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/NationalityCountryRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Afin d'afficher la nationalité et le pays correspondant que l'administrateur souhaite modifier dans le champ du formulaire, il faut que j'aille la récupérer grâce à son id (id présent dans l'url de la requête). Pour cela je vais devoir me connecter à la base de données et donc commencer par créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        // Ceci fait je peux me conecter à la bese de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Je suis maintenant connecté à la base de données. Je passe maintenant à la récupération de me donnée. Pour cela je vais instancier ma classe NationalityCountryRepository et plus particulièrement sa fonction getThisNationalityCountryWithThisId() avec en paramètre de ma fonction l'id que je récupére dans l'url de ma requête.
        $nationalityCountryRepository = new NationalityCountryRepository($db);
        // Cette fonction retourne toujours un tableau. Celui-ci peut être vide ou pas. Je décide de gérer ces deux états dans la vue de mon contrôleur:
        $nationalityCountryRetrieved = $nationalityCountryRepository->getThisNationalityCountryWithThisId($_GET['id']);
        // A la validation du formulaire:
        if (isset($_POST['nationalityCountryUpdateFormSubmit'])) {
            // Etant donné que les champs de saisie à l'affichage de notre page seront pré-remplis par la valeur récupérée, normalement il y a peu de risque qu'à la validation ce dernier soit vide. Cependant l'administrateur peut par erreur supprimer les données des champs. Je décide donc dans un premier temps de vérifier que ces champs ne soientt pas vides. Si c'est le cas une exception est levée:
            if (!empty($_POST['nationalityWritten']) && !empty($_POST['countryWritten'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans les champs de saisie, je "transforme" la saisie de mon utilisateur en un code "sécurisé":
                $nationalityWritten = htmlspecialchars($_POST['nationalityWritten']);
                $countryWritten = htmlspecialchars($_POST['countryWritten']);
                // Afin d'être sûr d'avoir toujours notre nationalité et notre pays écrits avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de formater la saisie de mon utilisateur:
                $nationalityWrittenFormated = ucfirst(strtolower($nationalityWritten));
                $countryWrittenFormated = ucfirst(strtolower($countryWritten));
                // A la création de notre base de données nous avons indiqué que les champs "name" et country de la table "nationality_country" étaient des chaines de caractères de maximum 50 caractères. Il faut donc que je vérifie que la nationalité et le pays saisis par l'utilisateur ne fasse pas plus de 50 caractères. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($nationalityWrittenFormated) <= 50 && strlen($countryWrittenFormated) <= 50) {
                    // La saisie de notre utilisateur est maintenant sécurisée et dans le bon format. Je vais pouvoir maintenant enregistrer celle-ci dans la base de données. Pour ce faire je vais dans un premier temps créer un nouvel objet de ma classe NationalityCountry:
                    $nationalityCountry = new NationalityCountry($_GET['id'], $nationalityWrittenFormated, $countryWrittenFormated);
                    // Et enfin grâce à la fonction updateThisNationalityCountry() de ma classe NationalityCountryRepository je met à jour la nationalité et son pays correspondant:
                    $nationalityCountryRepository->updateThisNationalityCountry($nationalityCountry);
                    // Si une erreur se déroule dans la mise à jour de la nationalité et de son pays une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les nationalités et où il verra que la modification s'est bien faite:
                    header('Location: nationalityCountryListView.php');
                } else {
                    throw new Exception('La nationalité et le pays saisis ne doivent pas dépasser 50 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir le champ.');
            }
        }
    } catch (Exception $exception) {
        $nationalityCountryUpdateFormMessage = $exception->getMessage();
    }
}
