<?php
// J'appelle la classe NationalityCountry dont je vais avoir besoin:
require_once('NationalityCountry.php');

class NationalityCountryRepository
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre d'ajouter une nationalité avec le pays correspondant dans la base de données:
    public function addThisNationalityCountry(NationalityCountry $nationalityCountry): void
    {
        $stmt = $this->db->prepare('INSERT INTO nationality_country (id, name, country) VALUES (:id, :name, :country)');
        $stmt->bindValue(':id', $nationalityCountry->getId());
        $stmt->bindValue(':name', $nationalityCountry->getName());
        $stmt->bindValue(':country', $nationalityCountry->getCountry());
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va nous permettre de récupérer toutes les nationalités avec les pays correspondants:
    public function getAllNationalitiesCountries(): array
    {
        // Je crée une variable qui est un tableau vide:
        $allNationalitiesCountries = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, name, country FROM nationality_country');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je mets à jour mon tableau:
                $allNationalitiesCountries[$row['id']]['name'] = $row['name'];
                $allNationalitiesCountries[$row['id']]['country'] = $row['country'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $allNationalitiesCountries;
        }
    }

    // Fonction qui va nous permettre de récupérer une nationalité avec son id:
    public function getThisNationalityCountryWithThisId(string $id): array
    {
        // Je crée une variable qui est un tableau vide:
        $nationalityCountry = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT name, country FROM nationality_country WHERE id = :id');
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
                // Je mets à jour mon tableau:
                $nationalityCountry['name'] = $row['name'];
                $nationalityCountry['country'] = $row['country'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $nationalityCountry;
        }
    }

    // Fonction qui va nous permettre de mettre à jour une nationalité avec son pays correspondant:
    public function updateThisNationalityCountry(NationalityCountry $nationalityCountry): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE nationality_country SET name = :name, country = :country WHERE id = :id');
        // Je récupère les données dont je vais avoir besoin:
        $id = $nationalityCountry->getId();
        $name = $nationalityCountry->getName();
        $country = $nationalityCountry->getCountry();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':country', $country);
        // J'excécute ma requête:
        $stmt->execute();
        // Je gère les erreurs éventuelles:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de supprimer une nationalité et son pays correspondant grâce à son id:
    public function deleteThisNationalityCountryWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM nationality_country WHERE id = :id');
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
