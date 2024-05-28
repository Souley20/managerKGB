<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('../../Model/MissionStatusRepository.php');
// Pour des raisons de sécurité je souhaite vérifier si l'utilisateur qui souhaite afficher cette page est bien connecté. Pour cela je vais avoir besoin d'utiliser le système de session donc je commence par le démarrer:
session_start();
// Je vais maintenant vérifier que l'utilisateur souhaitant afficher cette page est bien autorisé à le faire. Si ce n'est pas le cas, je redirige ce dernier vers la page de connexion, sinon le script continue:
if (!isset($_SESSION['userEmail']) || $_SESSION['userRole'] != 'ROLE_ADMIN') {
    header('Location: loginView.php');
} else {
    // Afin de gérer les erreurs de éventuelles de mon script, je décide de mettre ce dernier dans un bloc try...catch:
    try {
        // Afin d'afficher le statut de mission que l'administrateur souhaite modifier dans le champ du formulaire, il faut que j'aille le récupérer grâce à son id (id présent dans l'url de la requête). Pour cela je vais devoir me connecter à la base de données et donc commencer par créer mon DSN:
        $dsn = 'mysql:host=sql108.infinityfree.com;dbname=if0_36619586_managerKGB';
        // Ceci fait je peux me conecter à la bese de données:
        $db = new PDO($dsn, 'if0_36619586', 'ts2ITt5C5TR');
        // Je suis maintenant connecté à la base de données. Je passe maintenant à la récupération de me donnée. Pour cela je vais instancier ma classe MissionStatusRepository et plus particulièrement sa fonction getThisMissionStatusWithThisId() avec en paramètre de ma fonction l'id que je récupére dans l'url de ma requête. Cette fonction retournera le statut de la mission que nous pourrons utiliser dans la vue du contrôleur:
        $missionStatusRepository = new MissionStatusRepository($db);
        $missionStatusRetrieved = $missionStatusRepository->getThisStatusMissionWithThisId($_GET['id']);
        // A la validation du formulaire:
        if (isset($_POST['missionStatusUpdateFormSubmit'])) {
            // Etant donné que le champ de saisie à l'affichage de notre page sera pré-rempli par la valeur récupérée, normalement il y a peu de risque qu'à la validation ce dernier soit vide. Cependant l'administrateur peut par erreur supprimer la donnée du champ. Je décide donc dans un premier temps de vérifier que ce champ ne soit pas vide. Si c'est le cas une exception est levée:
            if (!empty($_POST['missionStatusWritten'])) {
                // Afin que des utilisateurs malveillants n'introduisent pas du code dans le champ de saisie, je "transforme" la saisie de mon utilisateur en un code "sécurisé":
                $missionStatusWritten = htmlspecialchars($_POST['missionStatusWritten']);
                // Afin d'être sûr d'avoir toujours notre statut de mission écrit avec le même format (Lettre capitale en début et le reste des caractères en minuscules), je décide de formater la saisie de mon utilisateur:
                $missionStatusWrittenFormated = ucfirst(strtolower($missionStatusWritten));
                // A la création de notre base de données nous avons indiqué que le champ "name" de la table "mission_status" était une chaine de caractères de maximum 30 caractères. Il faut donc que je vérifie que le statut de mission saisi par l'utilisateur ne fasse pas plus de 30 caractères. Si c'est le cas le script continue, sinon une exception est levée:
                if (strlen($missionStatusWrittenFormated) <= 30) {
                    // La saisie de notre utilisateur est maintenant sécurisée et dans le bon format. Je vais pouvoir maintenant enregistrer celle-ci dans la base de données. Pour ce faire je vais dans un premier temps créer un nouvel objet de ma classe MissionStatus:
                    $missionStatus = new MissionStatus($_GET['id'], $missionStatusWrittenFormated);
                    // Et enfin grâce à la fonction updateThisStatusMission() de ma classe MissionStatusRepository je mets à jour le statut de la mission:
                    $missionStatusRepository->updateThisStatusMission($missionStatus);
                    // Si une erreur se déroule dans la mise à jour du statut de mission une erreur est levée. Si au contraire cette mise à jour se passe bien je dirige l'administrateur vers la page qui liste les statuts de mission et où il verra que la modification s'est bien faite:
                    header('Location: missionStatusListView.php');
                } else {
                    throw new Exception('Le statut de mission saisi ne doit pas dépasser 30 caractères.');
                }
            } else {
                throw new Exception('Veuillez remplir le champ.');
            }
        }
    } catch (Exception $exception) {
        $missionStatusUpdateFormMessage = $exception->getMessage();
    }
}
