<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('Mission.php');

class MissionRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter une mission dans la base de données:
    public function addThisMission(Mission $mission): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO mission (id, title, description, code_name, mission_start, mission_end, nationality_country_id, speciality_id, mission_type_id, mission_status_id) VALUES (:id, :title, :description, :codeName, :missionStart, :missionEnd, :nationalityCountryId, :specialityId, :missionTypeId, :missionStatusId)');
        // Je récupére les informations dont je vais avoir besoin:
        $id = $mission->getId();
        $title = $mission->getTite();
        $description = $mission->getDescription();
        $codeName = $mission->getCodeName();
        // mysql a besoin de recevoir une string pour les deux champs que j'ai paramétré en DATETIME. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $missionStart = $mission->getMissionStart()->format('Y-m-d H:i:s');
        $missionEnd = $mission->getMissionEnd()->format('Y-m-d H:i:s');
        $nationalityCountryId = $mission->getNationalityCountryId();
        $specialityId = $mission->getSpecialityId();
        $missionTypeId = $mission->getMissionTypeId();
        $missionStatusId = $mission->getMissionStatusId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':codeName', $codeName);
        $stmt->bindValue(':missionStart', $missionStart);
        $stmt->bindValue(':missionEnd', $missionEnd);
        $stmt->bindValue(':nationalityCountryId', $nationalityCountryId);
        $stmt->bindValue(':specialityId', $specialityId);
        $stmt->bindValue(':missionTypeId', $missionTypeId);
        $stmt->bindValue(':missionStatusId', $missionStatusId);
        // J'execute ma requête:
        $stmt->execute();
        // Je gére les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fontion qui va me permettre de récupérer tous les titres des missions:
    public function getAllTitlesMissions(): array
    {
        // Je créé une variable $allMissionsTitles qui sera un tableau vide pour le moment et qui sera mis à jour si des données sont retournées:
        $missionsTitles = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, title FROM mission');
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
                $missionsTitles[$row['id']] = $row['title'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $missionsTitles;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'une mission:
    public function getAllMissionDatasWithThisId(string $id): array
    {
        // Je créé une variable $missionDatas qui sera un tableau vide pour le moment et qui sera mis à jour si des données sont retournées:
        $missionDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT title, description, code_name, mission_start, mission_end, nationality_country.country AS countryName, speciality.name AS specialityName, mission_type.name AS missionTypeName, mission_status.name AS missionStatusName FROM mission INNER JOIN nationality_country ON mission.nationality_country_id = nationality_country.id INNER JOIN speciality ON mission.speciality_id = speciality.id  INNER JOIN mission_type ON mission.mission_type_id = mission_type.id INNER JOIN mission_status ON mission.mission_status_id = mission_status.id WHERE mission.id = :id');
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $missionDatas['title'] = $row['title'];
                $missionDatas['description'] = $row['description'];
                $missionDatas['codeName'] = $row['code_name'];
                $missionDatas['missionStart'] = $row['mission_start'];
                $missionDatas['missionEnd'] = $row['mission_end'];
                $missionDatas['countryName'] = $row['countryName'];
                $missionDatas['specialityName'] = $row['specialityName'];
                $missionDatas['missionTypeName'] = $row['missionTypeName'];
                $missionDatas['missionStatusName'] = $row['missionStatusName'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $missionDatas;
        }
    }

    // Fonction qui va nous permettre de mettre les données d'une mission à jour:
    public function updateThisMission(Mission $mission): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE mission SET title = :title, description = :description, code_name = :codeName, mission_start = :missionStart, mission_end = :missionEnd, nationality_country_id = :nationalityCountryId, speciality_id = :specialityId, mission_type_id = :missionTypeId, mission_status_id = :missionStatusId WHERE id = :id');
        // Je récupère les données dont j'ai besoin:
        $id = $mission->getId();
        $title = $mission->getTite();
        $description = $mission->getDescription();
        $codeName = $mission->getCodeName();
        $missionStart = $mission->getMissionStart()->format('Y-m-d H:i:s');
        $missionEnd = $mission->getMissionEnd()->format('Y-m-d H:i:s');
        $nationalityCountryId = $mission->getNationalityCountryId();
        $specialityId = $mission->getSpecialityId();
        $missionTypeId = $mission->getMissionTypeId();
        $missionStatusId = $mission->getMissionStatusId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':codeName', $codeName);
        $stmt->bindValue(':missionStart', $missionStart);
        $stmt->bindValue(':missionEnd', $missionEnd);
        $stmt->bindValue(':nationalityCountryId', $nationalityCountryId);
        $stmt->bindValue(':specialityId', $specialityId);
        $stmt->bindValue(':missionTypeId', $missionTypeId);
        $stmt->bindValue(':missionStatusId', $missionStatusId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de supprimer une mission grâce à son id:
    public function deleteThisMissionWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM mission WHERE id = :id');
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

    // Fonction qui va me permettre de récupérer l'id d'un pays suivant une mission donnée:
    public function getMissionCountryIdWithThisMissionId(string $missionId): string
    {
        // Je prépara ma requête:
        $stmt = $this->db->prepare('SELECT nationality_country_id from mission WHERE id = :missionId');
        // Je lie mes données:
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row['nationality_country_id'])) {
                throw new Exception('Une erreur dans la récupération de votre donnée est survenue.');
            } else {
                return $row['nationality_country_id'];
            }
        }
    }

    // Fonction qui va me permettre de récupérer le nom de la spécialité ainsi que son id d'une mission grâce à l'id de la mission:
    public function getSpecialityDatasOfThisMissionWithThisId(string $missionId): array
    {
        // Je crée une variable qui est un tableau qui contiendra ou non les donnés de la spécialité d'une mission:
        $specialityDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT mission.speciality_id AS specialityId, speciality.name AS specialityName from mission INNER JOIN speciality ON mission.speciality_id = speciality.id WHERE mission.id = :missionId');
        // Je lis ma donnée:
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $specialityDatas['id'] = $row['specialityId'];
                $specialityDatas['name'] = $row['specialityName'];
            }
            return $specialityDatas;
        }
    }

    // Fonction qui va me permettre de récupérer les données de toutes les missions:
    public function getAllMissionsDatas(): array
    {
        // Je crée une variable qui est un tableau qui contiendra ou non l'ensemble des données de toutes les missions:
        $allMissionsDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT mission.id AS missionId, title, description, code_name, mission_start, mission_end, nationality_country.country AS country, speciality.name AS specialityName, mission_type.name AS missionType, mission_status.name AS missionStatus from mission INNER JOIN nationality_country ON mission.nationality_country_id = nationality_country.id INNER JOIN speciality ON mission.speciality_id = speciality.id INNER JOIN mission_type ON mission.mission_type_id = mission_type.id INNER JOIN mission_status ON mission.mission_status_id = mission_status.id');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $allMissionsDatas[$row['missionId']]['title'] = $row['title'];
                $allMissionsDatas[$row['missionId']]['description'] = $row['description'];
                $allMissionsDatas[$row['missionId']]['code_name'] = $row['code_name'];
                $allMissionsDatas[$row['missionId']]['mission_start'] = $row['mission_start'];
                $allMissionsDatas[$row['missionId']]['mission_end'] = $row['mission_end'];
                $allMissionsDatas[$row['missionId']]['country'] = $row['country'];
                $allMissionsDatas[$row['missionId']]['specialityName'] = $row['specialityName'];
                $allMissionsDatas[$row['missionId']]['missionType'] = $row['missionType'];
                $allMissionsDatas[$row['missionId']]['missionStatus'] = $row['missionStatus'];
            }
            // Je retourne le tableau qu'il soit vide ou avec des données:
            return $allMissionsDatas;
        }
    }
}
