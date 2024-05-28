<?php
// J'appelle la classe dont je vais avoir besoin:
require_once('User.php');

class UserRepository
{

    public function __construct(private PDO $db)
    {
        $this->db = $db;
    }

    // Fonction qui va nous permettre de vérifier si l'email d'un utilisateur est connu dans la base de donnée:
    public function countUserWithThisEmail(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT count(id) FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row['count(id)'] == 0) {
                return false;
            } else {
                return true;
            }
        }
    }

    // Fonction qui va me permettre de récupérer le mot de passe d'un utilisateur avec son email:
    public function getPasswordWithThisEmail(string $email): string
    {
        $stmt = $this->db->prepare('SELECT password FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['password'];
        }
    }

    // Fonction qui va me permettre de récupérer l'id d'un utilisateur avec son email:
    public function getUserRoleIdWithThisEmail(string $email): string
    {
        $stmt = $this->db->prepare('SELECT role_id FROM user WHERE email = :email');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['role_id'];
        }
    }

    // Fonction qui va me permettre d'ajouter un utilisateur dans la base de données:
    public function addThisUser(User $user): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('INSERT INTO user (id, firstname, lastname, email, password, created_at, role_id) VALUES (:id, :firstname, :lastname, :email, :password, :createdAt, :roleId)');
        // Je récupére les données dont je vais avoir besoin:
        $id = $user->getId();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $createdAt = $user->getCreatedAt()->format('Y-m-d');
        $roleId = $user->getRoleId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':createdAt', $createdAt);
        $stmt->bindValue(':roleId', $roleId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorCode();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de récupérer tous les utilisateurs:
    public function getAllUsers(): array
    {
        // Je crée une variable qui est un tableau vide:
        $allUsers = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT id, firstname, lastname FROM user');
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        } else {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Je mer à jour mon tableau avec les données retournées:
                $allUsers[$row['id']] = $row['firstname'] . ' ' . $row['lastname'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $allUsers;
        }
    }

    // Fonction qui va me permettre de récupérer les données d'un utilisateur grâce à son id:
    public function getUserDatasWithThisId(string $id): array
    {
        // Je crée une variable qui est un tableau vide:
        $allUserDatas = [];
        // Je prépare ma requête:
        $stmt = $this->db->prepare('SELECT firstname, lastname, email, password, created_at, name FROM user INNER JOIN role ON user.role_id = role.id WHERE user.id = :id');
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
                // Je met à jour mon tableau avec les données retournées:
                $allUserDatas['firstname'] = $row['firstname'];
                $allUserDatas['lastname'] = $row['lastname'];
                $allUserDatas['email'] = $row['email'];
                $allUserDatas['password'] = $row['password'];
                $allUserDatas['createdAt'] = $row['created_at'];
                $allUserDatas['roleName'] = $row['name'];
            }
            // Je retourne mon tableau qu'il soit vide ou non:
            return $allUserDatas;
        }
    }

    // Fonction qui va me permettre de mettre à jour les données d'un agent:
    public function updateThisUser(User $user): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('UPDATE user SET firstname = :firstname, lastname = :lastname, email = :email, password = :password, created_at = :createdAt , role_id = :roleId WHERE id = :id');
        // Je récupére les données dont j'ai besoin:
        $id = $user->getId();
        $firstname = $user->getFirstname();
        $lastname = $user->getLastname();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $createdAt = $user->getCreatedAt()->format('Y-m-d');
        $roleId = $user->getRoleId();
        // Je lie mes données:
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $password);
        $stmt->bindValue(':createdAt', $createdAt);
        $stmt->bindValue(':roleId', $roleId);
        // J'exécute ma requête:
        $stmt->execute();
        // Je gère les éventuelles erreurs:
        $errorInRequest = $stmt->errorInfo();
        if ($errorInRequest[0] != 0) {
            throw new Exception('Une erreur est survenue: ' . $errorInRequest[2]);
        }
    }

    // Fonction qui va me permettre de supprimer un utilisateur grâce à son id:
    public function deleteThisUserWithThisId(string $id): void
    {
        // Je prépare ma requête:
        $stmt = $this->db->prepare('DELETE FROM user WHERE id = :id');
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
