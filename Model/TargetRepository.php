<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('Target.php');

class TargetRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter une cible dans la base de données:
    public function addThisTarget(Target $target): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO target (id, firstname, lastname, date_of_birth, identity_code, nationality_country_id, mission_id) VALUES (:id, :firstname, :lastname, :dateOfBirth, :identityCode, :nationalityCountryId, :missionId)');
        // Je récupére les données dont j'ai besoin:
        $id = $target->getId();
        $firstname = $target->getFirstname();
        $lastname = $target->getLastname();
        // mysql a besoin de recevoir une string pour le champ que j'ai paramétré en DATE. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $dateOfBirth = $target->getDateOfBirth()->format('Y-m-d');
        $identityCode = $target->getIdentityCode();
        $nationalityCountryId = $target->getNationalityCountryId();
        $missionId = $target->getMissionId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':identityCode', $identityCode);
        $stmt->bindValue(':dateOfBirth', $dateOfBirth);
        $stmt->bindValue(':nationalityCountryId', $nationalityCountryId);
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer l'identité (nom et prénom) des toutes les cibles:
    public function getAllTargetIdentities(): array
    {
        // Je créé un tableau vide qui contiendra ou pas des cibles:
        $allTargetIdentities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, firstname, lastname FROM target');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je met à jour les données de mon tableau:
                $allTargetIdentities[$row['id']] = $row['firstname'] . ' ' . $row['lastname'];
            }
            // Je retourne le tableau qu'il soit vide ou non:
            return $allTargetIdentities;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'une cible grâce à son id:
    public function getAllTargetDatasWithThisId(string $id): array
    {
        // Je crée un tableau vide qui contiendra ou pas les données d'une cible:
        $allTargetDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname, date_of_birth, identity_code, nationality_country.name AS nationality, mission.title AS missionTitle FROM target INNER JOIN nationality_country ON target.nationality_country_id = nationality_country.id INNER JOIN mission ON target.mission_id = mission.id WHERE target.id = :id');
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
                $allTargetDatas['firstname'] = $row['firstname'];
                $allTargetDatas['lastname'] = $row['lastname'];
                $allTargetDatas['dateOfBirth'] = $row['date_of_birth'];
                $allTargetDatas['identityCode'] = $row['identity_code'];
                $allTargetDatas['nationality'] = $row['nationality'];
                $allTargetDatas['missionTitle'] = $row['missionTitle'];
            }
            return $allTargetDatas;
        }
    }

    // Fonction qui va nous permettre de mettre à jour les données d'une cible:
    public function updateThisTarget(Target $target): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE target SET firstname = :firstname, lastname = :lastname, date_of_birth = :dateOfBirth, nationality_country_id = :nationalityCountryId, mission_id = :missionId WHERE id = :id');
        // Je récupère les données dont j'ai besoin:
        $id = $target->getId();
        $firstname = $target->getFirstname();
        $lastname = $target->getLastname();
        $dateOfBirth = $target->getDateOfBirth()->format('Y-m-d');
        $nationalityCountryId = $target->getNationalityCountryId();
        $missionId = $target->getMissionId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':dateOfBirth', $dateOfBirth);
        $stmt->bindValue(':nationalityCountryId', $nationalityCountryId);
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer l\'id de la mision d\'une cible grâce à son id:
    public function getMissionIdOfThisTarget(string $targetId): string
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT mission_id from target WHERE id = :targetId');
        // Je lie ma donnée:
        $stmt->bindValue(':targetId', $targetId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row['mission_id'])) {
                throw new Exception('Une erreur est survenue dans la récupération de votre donnée.');
            } else {
                return $row['mission_id'];
            }
        }
    }

    // Fonction qui va me permettre de compter les cibles affectées à une mission:
    public function countTargetOfThisMission(string $missionId): bool
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT count(id) AS numberOfTargets from target WHERE mission_id = :missionId');
        // je lie ma donnée:
        $stmt->bindValue('missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['numberOfTargets'] == 1) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Fonction qui va me permettre de supprimer une cible grâce à son id:
    public function deleteThisTargetWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM target WHERE id = :id');
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

    // Fonction qui va me permettre de compter les cibles ayant une nationalité et une mission donnée:
    public function countTargetWithThisNationalityAndThisMission(string $nationalityId, string $missionId): bool
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT count(id) AS numberOfTargets FROM target where nationality_country_id = :nationalityId AND mission_id = :missionId');
        // Je lie mes données:
        $stmt->bindValue(':nationalityId', $nationalityId);
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['numberOfTargets'] == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Fonction qui va nous permettre de récupérer l'identité (nom et prénom) des toutes les cibles affectées à une mission:
    public function getAllTargetIdentitiesOfThisMission(string $missionId): array
    {
        // Je créé un tableau vide qui contiendra ou pas des cibles:
        $allTargetsIdentities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname FROM target WHERE mission_id = :missionId');
        // Je lie ma donnée:
        $stmt->bindValue(':missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je met à jour les données de mon tableau:
                $allTargetsIdentities[] = $row['firstname'] . ' ' . $row['lastname'];
            }
            // Je retourne le tableau qu'il soit vide ou non:
            return $allTargetsIdentities;
        }
    }
}
