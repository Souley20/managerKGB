<?php
// J'appelle les classes dont je vais avoir besoin:
require_once('../../Model/MissionTypeRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Afin d'afficher le type de mission que l'administrateur souhaite modifier dans le champ du formulaire, il faut que j'aille le récupérer grâce à son id (id présent dans l'url de la requête). Pour cela je vais devoir me connecter à la base de données et donc commencer par créer mon Data Source Name;
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        // Ceci fait je peux maintenant me connecter à ma base de données avec PDO:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Je suis maintenant connecté à ma base de données. Je passe mainteant à la récupération de ma donnée. Pour cela je vais instancier ma classe MissionTypeRepository et plus particulieremnt sa fonction getMissionTypeWithThisId() avec en paramètre de ma fonction l'id que je récupère dans l'url de ma requête. Cette fonction nous retournera le type de mission récupérée que nous pourrons utilisée dans la vue de ce contrôleur:
        $missionTypeRepository = new MissionTypeRepository($db);
        $missionTypeRetrieved = $missionTypeRepository->getMissionTypeWithThisId($_GET['id']);
        // A la validation du formulaire:
        if (isset($_POST['missionTypeUpdateFormSubmit'])) {
            // Etant donné que le champ de saisie à l'affichage de notre page sera pré-rempli par la valeur récupérée, normalement il y a peu de risque qu'à la validation ce dernier soit vide. Cependant l'administrateur peut par erreur supprimer la donnée du champ. Je décide donc dans un premier temps de vérifier que ce champ ne soit pas vide. Si c'est le cas une exception est levée:
            if (!empty($_POST['missionTypeWritten'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans le champ de saisie, je "transforme" la saisie de mon utilisateur en un code "sécurisé":
                $missionTypeWritten = htmlspecialchars($_POST['missionTypeWritten']);
                // Afin d'être sûr d'avoir toujours notre type de mission écrit avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de formater la saisie de mon utilisateur:
                $missionTypeWrittenFormated = ucfirst(strtolower($missionTypeWritten));
                // A la création de notre base de données nous avons indiqué que le champ "name" de la table "mission_type" était une chaine de caractères de maximum 50 caractères. Il faut donc que je vérifie que le type de statut saisi par l'utilisateur ne fasse pas plus de 50 caractères. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($missionTypeWrittenFormated) <= 50) {
                    // La saisie de notre utilisateur est maintenant sécurisée et dans le bon format. Je vais pouvoir maintenant enregistrer celle-ci dans la base de données. Pour ce faire je vais dans un premier temps créer un nouvel objet de ma classe MissionType:
                    $missionType = new MissionType($_GET['id'], $missionTypeWrittenFormated);
                    // Et enfin grâce à la fonction updateThisMissionType() de ma classe MissionTypeRepository je mets à jour le type de mission:
                    $missionTypeRepository->updateThisMissionType($missionType);
                    // Si une erreur se déroule dans la mise à jour du type de mission une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les types de mission et où il verra que la modification s'est bien faite:
                    header('Location: missionTypeListView.php');
                } else {
                    throw new Exception('Le type de mission saisi ne doit pas dépasser 50 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir le champ.');
            }
        }
    } catch (Exception $exception) {
        $missionTypeUpdateFormMessage = $exception->getMessage();
    }
}
