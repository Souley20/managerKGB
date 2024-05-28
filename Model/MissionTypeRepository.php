<?php
// J'appelle la classe MissionType dont je vais avoir besoin:
require_once('MissionType.php');

class MissionTypeRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter un type de mission dans la base de données:
    public function addThisMissionType(MissionType $missionType): void
    {
        $stmt = $this->db->prepare('INSERT INTO mission_type (id, name) VALUES (:id, :name)');
        $stmt->bindValue(':id', $missionType->getId());
        $stmt->bindValue(':name', $missionType->getName());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer tous les types de mission de la base de données:
    public function getAllMissionType(): array
    {
        // Je créé un tableau qui n'a aucune données pour le moment.
        $missionType = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM mission_type');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si il n'y a pas d'erreur mes données sont retournées et je met à jour mon tableau:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $missionType[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau. Si des données sont trouvées elles seront dans ce tableau sinon mon tableau sera vide:
            return $missionType;
        }
    }

    // Fonction qui va nous permettre de récupérer un type de mission avec son id:
    public function getMissionTypeWithThisId(string $id): string
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT name FROM mission_type WHERE id = :id');
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        // J'execute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row['name'])) {
                throw new Exception('Aucun type de mission retourné.');
            } else {
                return $row['name'];
            }
        }
    }

    // Fonction qui va nous permettre de mettre à jour un type de mission:
    public function updateThisMissionType(MissionType $missionType): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE mission_type SET name = :name WHERE id = :id');
        // Je récupére les données dont j'ai besion:
        $id = $missionType->getId();
        $name = $missionType->getName();
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

    // Fonction qui va me permettre de supprimer un type de mission grâce à son id:
    public function deleteThisMissionTypeWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM mission_type WHERE id = :id');
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
