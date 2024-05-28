<?php
// J'appelle la classe MissionStatus dont je vais avoir besoin:
require_once('MissionStatus.php');

class MissionStatusRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter un statut de mission dans la base de données:
    public function addThisMissionStatus(MissionStatus $missionStatus): void
    {
        $stmt = $this->db->prepare('INSERT INTO mission_status (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $missionStatus->getId());
        $stmt->bindValue(':name', $missionStatus->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer tous les statuts de mission de la base de données:
    public function getAllStatusMission(): array
    {
        // Je créé un tableau qui n'a aucune données pour le moment:
        $missionStatus = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM mission_status');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si il n'y a pas d'erreur mes données sont retournées et je met à jour mon tableau:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $missionStatus[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau. Si des données sont trouvées elles seront dans ce tableau sinon mon tableau sera vide:
            return $missionStatus;
        }
    }

    // Fonction qui va nous permettre de récupérer un statut de mission avec son id:
    public function getThisStatusMissionWithThisId(string $id): string
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT name FROM mission_status WHERE id = :id');
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Si ma variable $row est vide, cela signifie que le statut de mission n'a pas été retournée, je lance donc une exception. Sinon je retourne le statut de mission:
            if (empty($row['name'])) {
                throw new Exception('Aucun statut de mission retourné.');
            } else {
                return $row['name'];
            }
        }
    }

    // Fonction qui va nous permettre de mettre à jour un statut de mission:
    public function updateThisStatusMission(MissionStatus $missionStatus): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE mission_status SET name = :name WHERE id = :id');
        // Je récupére les données dont j'ai besoin:
        $id = $missionStatus->getId();
        $name = $missionStatus->getName();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de supprimer un statut de mission grâce à son id:
    public function deleteThisMissionStatusWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM mission_status WHERE id = :id');
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        // J'exécute la requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue dans la suppression. ' . $errorInRequest[2]);
        }
    }
}
