<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('Stash.php');

class StashRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter une planque dans ma base de données:
    public function addThisStash(Stash $stash): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO stash (code, address, type, mission_id, nationality_country_id) VALUES (:code, :address, :type, :missionId, :nationalityCountryId)');
        // Je récupére les données dont j'ai besoin:
        $code = $stash->getCode();
        $address = $stash->getAddress();
        $type = $stash->getType();
        $missionId = $stash->getMissionId();
        $nationalityCountryId = $stash->getNationalityCountryId();
        // Je peux maintenant lier mes données:
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':missionId', $missionId);
        $stmt->bindValue(':nationalityCountryId', $nationalityCountryId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction que va nous permettre de récupérer tous les codes des planques:
    public function getAllStashesCodes(): array
    {
        // Je créé une variable $allStashesCodes qui sera un tableau vide pour le moment et qui sera mis à jour si des données sont retournées:
        $allStashesCodes = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT code FROM stash');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si il n'y a pas d'erreur, je récupére les données:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Si des données sont retournées alors je met à jour mon tableau:
                $allStashesCodes[] = $row['code'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $allStashesCodes;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'une planque grâce à son id:
    public function getAllStashDatasWithThisId(int $code): array
    {
        // Je créé une variable $stashDatas qui sera un tableau vide pour le moment et qui sera mis à jour si des données sont retournées:
        $stashDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT address, type, mission.title AS missionTitle, nationality_country.country AS countryName FROM stash INNER JOIN mission ON stash.mission_id = mission.id INNER JOIN nationality_country ON stash.nationality_country_id = nationality_country.id WHERE code = :code');
        // Je lie mes données:
        $stmt->bindValue(':code', $code);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $stashDatas['address'] = $row['address'];
                $stashDatas['type'] = $row['type'];
                $stashDatas['missionTitle'] = $row['missionTitle'];
                $stashDatas['countryName'] = $row['countryName'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $stashDatas;
        }
    }

    // Fonction qui va nous permettre de mettre à jour les données d'une planque:
    public function updateThisStash(Stash $stash): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE stash SET address = :address, type = :type, mission_id = :missionId, nationality_country_id = :nationalityCountryId WHERE code = :code');
        // Je récupère les données dont j'ai besoin:
        $code = $stash->getCode();
        $address = $stash->getAddress();
        $type = $stash->getType();
        $missionId = $stash->getMissionId();
        $nationalityCountryId = $stash->getNationalityCountryId();
        // Je lie mes données:
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':address', $address);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':missionId', $missionId);
        $stmt->bindValue(':nationalityCountryId', $nationalityCountryId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de supprimer une planque grâce à son id:
    public function deleteThisStashWithThisCode(string $code): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM stash WHERE code = :code');
        // Je lie mes données:
        $stmt->bindValue(':code', $code);
        // J'exécute la requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue dans la suppression. ' . $errorInRequest[2]);
        }
    }

    // Fonction que va me permettre de récupérer tous les types de planques d'une mission donnée:
    public function getAllStashesTypesOfThisMission(string $missionId): array
    {
        // Je créé une variable $allStashesCodes qui sera un tableau vide pour le moment et qui sera mis à jour si des données sont retournées:
        $allStashesTypes = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT type FROM stash WHERE mission_id = :missionId');
        // Je lie ma donnée:
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si il n'y a pas d'erreur, je récupére les données:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Si des données sont retournées alors je met à jour mon tableau:
                $allStashesTypes[] = $row['type'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $allStashesTypes;
        }
    }
}
