<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('Agent.php');

class AgentRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter un agent dans la base de données:
    public function addThisAgent(Agent $agent): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO agent (id, firstname, lastname, date_of_birth, identity_code, nationality_country_id, mission_id) VALUES (:id, :firstname, :lastname, :dateOfBirth, :identityCode, :nationalityCountryId, :missionId)');
        // Je récupére les données dont j'ai besoin:
        $id = $agent->getId();
        $firstname = $agent->getFirstname();
        $lastname = $agent->getLastname();
        // mysql a besoin de recevoir une string pour le champ que j'ai paramétré en DATE. J'utilise donc la fonction "format" de la classe Datetime afin de parser mon objet Datetime en string:
        $dateOfBirth = $agent->getDateOfBirth()->format('Y-m-d');
        $identityCode = $agent->getIdentityCode();
        $nationalityCountryId = $agent->getNationalityCountryId();
        $missionId = $agent->getMissionId();
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

    // Fonction qui va me permettre de récupérer tous les agents:
    public function getAllAgents(): array
    {
        // Je créé un tableau vide qui recevra ou non des données:
        $agents = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, firstname, lastname FROM agent');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je met à jour mon tableau:
                $agents[$row['id']] =  $row['firstname'] . ' ' . $row['lastname'];
            }
            // Je retourne mon tableau vide si des données n'ont pas été retournées et dans le cas contraire mon tableau mis à jour:
            return $agents;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'un agent grâce à son id:
    public function getAllAgentDatasWithThisId(string $id): array
    {
        // Je crée un tableau vide qui contiendra ou pas les données d'une cible:
        $allAgentDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname, date_of_birth, identity_code, nationality_country.name AS nationality, mission.title AS missionTitle FROM agent INNER JOIN nationality_country ON agent.nationality_country_id = nationality_country.id INNER JOIN mission ON agent.mission_id = mission.id WHERE agent.id = :id');
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
                $allAgentDatas['firstname'] = $row['firstname'];
                $allAgentDatas['lastname'] = $row['lastname'];
                $allAgentDatas['dateOfBirth'] = $row['date_of_birth'];
                $allAgentDatas['identityCode'] = $row['identity_code'];
                $allAgentDatas['nationality'] = $row['nationality'];
                $allAgentDatas['missionTitle'] = $row['missionTitle'];
            }
            return $allAgentDatas;
        }
    }

    // Fonction qui va nous permettre de mettre à jour les données d'un agent:
    public function updateThisAgent(Agent $agent): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE agent SET firstname = :firstname, lastname = :lastname, date_of_birth = :dateOfBirth, nationality_country_id = :nationalityCountryId, mission_id = :missionId WHERE id = :id');
        // Je récupère les données dont j'ai besoin:
        $id = $agent->getId();
        $firstname = $agent->getFirstname();
        $lastname = $agent->getLastname();
        $dateOfBirth = $agent->getDateOfBirth()->format('Y-m-d');
        $nationalityCountryId = $agent->getNationalityCountryId();
        $missionId = $agent->getMissionId();
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

    // Fonction qui va me permettre de supprimer un agent grâce à son id:
    public function deleteThisAgentWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM agent WHERE id = :id');
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

    // Fonction qui va me permettre de compter les agents ayant une nationalité et une mission donnée:
    public function countAgentWithThisNationalityAndThisMission(string $nationalityId, string $missionId): bool
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT count(id) AS numberOfAgents FROM agent where nationality_country_id = :nationalityId AND mission_id = :missionId');
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
            if ($row['numberOfAgents'] == 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    // Fonction qui va nous permettre de récupérer l\'id de la mision d\'un agent grâce à son id:
    public function getMissionIdOfThisAgent(string $agentId): string
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT mission_id from agent WHERE id = :agentId');
        // Je lie ma donnée:
        $stmt->bindValue(':agentId', $agentId);
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

    // Fonction qui va me permettre de récupérer l'identifiant des agents affectés à une mission:
    public function getAgentIdsOfThisMission(string $missionId): array
    {
        // Je crée une variable qui contiendra le ou les identifiants du ou des agents affectés à cette mission:
        $agentIds = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id from agent WHERE mission_id = :missionId');
        // je lie ma donnée:
        $stmt->bindValue('missionId', $missionId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gére les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $agentIds[] = $row['id'];
            }
            return $agentIds;
        }
    }

    // Fonction qui va me permettre de compter les agents affectés à une mission:
    public function countAgentIOfThisMission(string $missionId): bool
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT count(id) AS numberOfAgents from agent WHERE mission_id = :missionId');
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
            if ($row['numberOfAgents'] == 1) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Fonction qui va me permettre de récupérer le ou les identités du ou des agents affectés à une mission:
    public function getAllAgentsIdentitiesOfThisMission(string $missionId): array
    {
        // Je crée une variable qui est un tabelau vide et qui contiendra la ou les identités des agents sur une mission:
        $allAgentsIdentities = [];
        // Je prépére ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname from agent WHERE mission_id = :missionId');
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
                $allAgentsIdentities[] = $row['firstname'] . ' ' . $row['lastname'];
            }
            return $allAgentsIdentities;
        }
    }
}
