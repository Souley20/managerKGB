<?php
// J'appelle la classe Speciality dont je vais avoir besoin:
require_once('Speciality.php');

class SpecialityRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter une spécialité dans la base de données:
    public function addThisSpeciality(Speciality $speciality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO speciality (id, name) VALUES (:id, :name)');
        // Je lie mes données:
        $stmt->bindValue(':id', $speciality->getId());
        $stmt->bindValue(':name', $speciality->getName());
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer toutes les spécialités de la base de données:
    public function getAllSpecialities(): array
    {
        // Je créé une variable $specialities qui est un tableau vide:
        $specialities = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name FROM speciality');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            // Si pas d'erreur mes données sont retournées sous forme de tableau associatif:
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Si des données sont retournées alors mon tableau $specialities est mis à jour:
                $specialities[$row['id']] = $row['name'];
            }
            // Je retourne mon tableau. Si des données ont été retournées elles seront dans mon tableau sinon la fonction retrourne un tableau vide:
            return $specialities;
        }
    }

    // Fonction qui va nous permettre de récupérer une spécialité grâce à son id:
    public function getSpecialityWithThisId(string $id): string
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT name FROM speciality WHERE id = :id');
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
            // Si aucune donnée n'est retournée je lance une exception, sinon je retourne ma spécialité:
            if (empty($row['name'])) {
                throw new Exception('Aucune spécialité n\'a été récupérée.');
            } else {
                return $row['name'];
            }
        }
    }

    // Fonction qui va me permettre de mettre à jour une spécialité:
    public function updateThisSpeciality(Speciality $speciality): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE speciality SET name = :name WHERE id = :id');
        // Je récupére les données dont j'ai besoin:
        $name = $speciality->getName();
        $id = $speciality->getId();
        // Je lie mes données:
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':id', $id);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de supprimer une spécialité grâce à son id:
    public function deleteThisSpecialityWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM speciality WHERE id = :id');
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
