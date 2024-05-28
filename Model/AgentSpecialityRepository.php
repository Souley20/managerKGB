<?php
// J'appelle la classe dont je vais avoir bessoin:
require_once('AgentSpeciality.php');

class AgentSpecialityRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va me permettre d'ajouter un agent avec sa spécialité dans la base de données:
    public function addThisAgentSpeciality(AgentSpeciality $agentSpeciality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO agent_speciality (agent_id, speciality_id) VALUES (:agentId, :specialityId)');
        // Je récupére les données dont j'ai besoin:
        $agentId = $agentSpeciality->getAgentId();
        $specialityId = $agentSpeciality->getSpecialityId();
        // Je lie mes données:
        $stmt->bindValue(':agentId', $agentId);
        $stmt->bindValue(':specialityId', $specialityId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer l'identité de tous les agents avec la/leurs spécialitée/spécialitées:
    public function getAllAgentIdentitiesWithSpecialities(): array
    {
        // Je crée une variable qui est un tableau vide pour le moment:
        $allAgentIdentitiesWithSpecialities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT agent_speciality.agent_id AS agentId, agent_speciality.speciality_id AS specialityId, agent.firstname AS agentFirstname, agent.lastname AS agentLastname, speciality.name as specialityName FROM agent_speciality INNER JOIN agent ON agent.id = agent_speciality.agent_id INNER JOIN speciality ON speciality.id = agent_speciality.speciality_id');
        // J'éxécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $allAgentIdentitiesWithSpecialities[$row['agentId']][$row['agentFirstname'] . ' ' . $row['agentLastname']][$row["specialityId"]] = $row['specialityName'];
            }
            return $allAgentIdentitiesWithSpecialities;
        }
    }

    // Fonction qui va nous permettre de récupérer les données d'un agent avec sa spécialité grâce aux ids demandés:
    public function getAgentSpecialityDatasWithThisIds(string $agentId, string $specialityId): array
    {
        // Je crée une variable qui est un tableau vide pour le moment:
        $agentSpecialityData = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT agent.id, firstname, lastname, name FROM agent INNER JOIN agent_speciality ON agent_speciality.agent_id = agent.id INNER JOIN speciality ON agent_speciality.speciality_id = speciality.id WHERE agent_id = :agentId AND speciality_id = :specialityId');
        // Je lie mes données:
        $stmt->bindParam(':agentId', $agentId);
        $stmt->bindParam(':specialityId', $specialityId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $agentSpecialityData['id'] = $row['id'];
                $agentSpecialityData['identity'] = $row['firstname'] . ' ' . $row['lastname'];
                $agentSpecialityData['speciality'] = $row['name'];
            }
            return $agentSpecialityData;
        }
    }

    // Fonction qui va nous permettre de modifier la spécialité d'un agent grâce à l'id de l'agent et l'id de la spécialité:
    public function updateThisAgentSpecialityWithThisAgentIdAndThisSpecialityId(AgentSpeciality $newAgentSpeciality, AgentSpeciality $oldAgentSpeciality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE agent_speciality SET agent_id = :agentId, speciality_id = :specialityId WHERE agent_id = :oldAgentId AND speciality_id = :oldSpecialityId');
        // Je récupére les donnéées dont j'ai besoin:
        $agentId = $newAgentSpeciality->getAgentId();
        $specialityId = $newAgentSpeciality->getSpecialityId();
        $oldAgentId = $oldAgentSpeciality->getAgentId();
        $oldSpecialityId = $oldAgentSpeciality->getSpecialityId();
        // Je lie les données:
        $stmt->bindParam(':agentId', $agentId);
        $stmt->bindParam(':specialityId', $specialityId);
        $stmt->bindParam(':oldAgentId', $oldAgentId);
        $stmt->bindParam(':oldSpecialityId', $oldSpecialityId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de compter les agents disposants d'une spécialité grâce à l'id de l'agent et à l'id de la spécialité:
    public function countAgentWithThisAgentIdAndThisSpecialityId(string $agentId, string $specialityId): bool
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT count(agent_id) AS numberOfAgents from agent_speciality WHERE agent_id = :agentId AND speciality_id = :specialityId');
        // Je lie mes données:
        $stmt->bindValue(':agentId', $agentId);
        $stmt->bindValue(':specialityId', $specialityId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['numberOfAgents'] == 0) {
                return false;
            } else {
                return true;
            }
        }
    }
}
