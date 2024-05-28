<?php
// La première chose que je souhaite faire c'est me connecter à la base de données. Je vais utiliser pour cela l'objet PDO. Je vais avoir besoin d'un Data Source Name:
$dsn = 'mysql:host=localhost';
// A ce stade, je peux maintenant créé mon instance PDO. Afin de gérer les erreurs de mon script (connexion à la base etc etc...), je décide de l'inscrire dans un bloc try...catch:
try {
    // J'instancie maintenant un nouvel objet PDO avec mon dsn:
    $pdo = new PDO($dsn, 'root', 'root');
    // Le nom de ma base de donnée sera 'managerKGB'. Afin de repartir d'une page blanche à chaque éxécution de ce script, je décide de supprimer la base de données portant ce nom. Je vérifie cette opération dans un bloc if..else afin de pouvoir lancer une erreur en cas de souci:
    if ($pdo->exec('DROP DATABASE IF EXISTS managerKGB') !== false) {
        // Maintenant que je suis sûr que ma base de donnée avec le nom managerKGB est supprimée je vais pouvoir la recréer:
        if ($pdo->exec('CREATE DATABASE managerKGB') !== false) {
            // Ma base de données est recréée. Afin d'y insérer des données je vais devoir instancier un nouvel objet PDO. Il me faut pour cela modifier mon dsn:
            $dsn = 'mysql:host=localhost;dbname=managerKGB';
            // J'instancie maintenant mon nouvel objet PDO:
            $db = new PDO($dsn, 'root', '');
            // Créons maintenant notre première table. A l'aide de mon schéma MCD et en reagrdant les relations de chaque tables entre elles, je décide de commencer par la table speciality:
            if ($db->exec('CREATE TABLE IF NOT EXISTS speciality (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(50) NOT NULL)') !== false) {
                // Maintenant je crée ma table mission_type:
                if ($db->exec('CREATE TABLE IF NOT EXISTS mission_type (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(50) NOT NULL)') !== false) {
                    // Je continue avec la table mission_type:
                    if ($db->exec('CREATE TABLE IF NOT EXISTS mission_status (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(50) NOT NULL)') !== false) {
                        // Au tour de la table nationality_country. Pour parler un peu de cette table, c'est une table de "fusion". En effet elle est la fusion d'une table qui ce serait appellée nationality et d'une autre table qui ce serait appellée country. Ces deux tables auraient eu une relation one to one et j'ai donc décidé d'utiliser la méthode de fusion pour mon modèle MCD:
                        if ($db->exec('CREATE TABLE IF NOT EXISTS nationality_country (id CHAR (36) NOT NULL PRIMARY KEY, name VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL)') !== false) {
                            // Je poursuis avec la table mission:
                            if ($db->exec('CREATE TABLE IF NOT EXISTS mission (id CHAR(36) NOT NULL PRIMARY KEY, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, code_name VARCHAR(100) NOT NULL, mission_start DATETIME NOT NULL, mission_end DATETIME NOT NULL, nationality_country_id CHAR(36) NOT NULL, speciality_id CHAR(36) NOT NULL, mission_type_id CHAR(36) NOT NULL, mission_status_id CHAR(36) NOT NULL, FOREIGN KEY (nationality_country_id) REFERENCES nationality_country(id) ON DELETE CASCADE, FOREIGN KEY (speciality_id) REFERENCES speciality(id) ON DELETE CASCADE, FOREIGN KEY (mission_type_id) REFERENCES mission_type(id) ON DELETE CASCADE, FOREIGN KEY (mission_status_id) REFERENCES mission_status(id) ON DELETE CASCADE)') !== false) {
                                // Je construis maintenant ma table stash:
                                if ($db->exec('CREATE TABLE IF NOT EXISTS stash (code INTEGER(11) NOT NULL PRIMARY KEY, address VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, mission_id CHAR(36), nationality_country_id CHAR(36) NOT NULL, FOREIGN KEY (mission_id) REFERENCES mission(id) ON DELETE CASCADE, FOREIGN KEY (nationality_country_id) REFERENCES nationality_country(id) ON DELETE CASCADE)') !== false) {
                                    // Au tour de la table agent:
                                    if ($db->exec('CREATE TABLE IF NOT EXISTS agent (id CHAR(36) NOT NULL PRIMARY KEY, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, identity_code VARCHAR(50) NOT NULL, nationality_country_id CHAR(36) NOT NULL, mission_id CHAR(36) NOT NULL, FOREIGN KEY (nationality_country_id) REFERENCES nationality_country(id) ON DELETE CASCADE, FOREIGN KEY (mission_id) REFERENCES mission(id) ON DELETE CASCADE)') !== false) {
                                        // La table speciality étant créé, la table agent étant crée, je peux faire la table associative agent_speciality:
                                        if ($db->exec('CREATE TABLE IF NOT EXISTS agent_speciality (agent_id CHAR(36) NOT NULL, speciality_id CHAR(36) NOT NULL, PRIMARY KEY(agent_id, speciality_id), FOREIGN KEY (agent_id) REFERENCES agent(id) ON DELETE CASCADE, FOREIGN KEY (speciality_id) REFERENCES speciality(id) ON DELETE CASCADE)') !== false) {
                                            // Table contact:
                                            if ($db->exec('CREATE TABLE IF NOT EXISTS contact (id CHAR(36) NOT NULL PRIMARY KEY, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, identity_code VARCHAR(50), nationality_country_id CHAR(36) NOT NULL, mission_id CHAR(36) NOT NULL, FOREIGN KEY (nationality_country_id) REFERENCES nationality_country(id) ON DELETE CASCADE, FOREIGN KEY (mission_id) REFERENCES mission(id) ON DELETE CASCADE)') !== false) {
                                                // Dernière table de la partie Front-End la table target:
                                                if ($db->exec('CREATE TABLE IF NOT EXISTS target (id CHAR(36) NOT NULL PRIMARY KEY, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, date_of_birth DATE NOT NULL, identity_code VARCHAR(50), nationality_country_id CHAR(36) NOT NULL, mission_id CHAR(36) NOT NULL, FOREIGN KEY (nationality_country_id) REFERENCES nationality_country(id) ON DELETE CASCADE, FOREIGN KEY (mission_id) REFERENCES mission(id) ON DELETE CASCADE)') !== false) {
                                                    // Première table de la partie Back-End, la table role. Je commence par celle-ci car sur mon schéma MCD on voit que la table user possède une clé étrangère de la table role:
                                                    if ($db->exec('CREATE TABLE IF NOT EXISTS role (id CHAR(36) NOT NULL PRIMARY KEY, name VARCHAR(50) NOT NULL)') !== false) {
                                                        // Je peux créer maintenant la dernière table, la table user. L'utilisateur aura un mot de passe. Ce dernier sera hashé en BCRYPT qui génére une chaine de caractères de 60 caractères. Je choisi donc de typer mon champ password en conséquence:
                                                        if ($db->exec('CREATE TABLE IF NOT EXISTS user (id CHAR(36) NOT NULL PRIMARY KEY, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, password CHAR(60) NOT NULL, created_at DATE NOT NULL, role_id CHAR(36) NOT NULL, FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE CASCADE)') !== false) {
                                                            // Afin de pouvoir entrer des données dans nos tables, l'énoncé stipule qu'il faudra se connecter mais je ne suis pas autorisé à créer une page d'inscription. Il faut donc que j'insère un utilisateur dans ma base de donnée à l'aide d'une fonction SQL. Avant d'insérer un utilisateur, je dois insérer des données dans la table role. Pour l'évaluation, je décide de n'insérer qu'une seule lign avec en nom de role ROLE_ADMIN:
                                                            if ($db->exec("INSERT INTO role (id, name) VALUES ('eab32bfe-d0e4-11ee-93a2-d63dafb57e58', 'ROLE_ADMIN')") !== false) {
                                                                // Ma table role ayant maintenant une ligne de donnée, je peux créer une ligne dans ma table user:
                                                                if ($db->exec('INSERT INTO user (id, firstname, lastname, email, password, created_at, role_id) VALUES (UUID(), "Laurent", "CAILLAUD", "admin@example.com", "$2y$10$v.pqiP.Zz.Sqh8jdXpcI6uGc0XKQUmNkE6EzGvtFdrPhHgROivypG", NOW(), "eab32bfe-d0e4-11ee-93a2-d63dafb57e58")') !== false) {
                                                                    // A ce stade mon script est terminé et j'ai les données suffisantes pour pour poursuivre l'évaluation. Je choisi de mettre un message afin de stipuler que tout est ok:
                                                                    echo '<p>La base de donnée est maintenant opérationnelle.</p>';
                                                                } else {
                                                                    throw new PDOException('<p>Une erreur est survenue pendant l\'insertion de vos données.</p>');
                                                                }
                                                            } else {
                                                                throw new PDOException('<p>Une erreur est survenue pendant l\'insertion de vos données.</p>');
                                                            }
                                                        } else {
                                                            throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                                        }
                                                    } else {
                                                        throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                                    }
                                                } else {
                                                    throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                                }
                                            } else {
                                                throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                            }
                                        } else {
                                            throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                        }
                                    } else {
                                        throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                    }
                                } else {
                                    throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                                }
                            } else {
                                throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                            }
                        } else {
                            throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                        }
                    } else {
                        throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                    }
                } else {
                    throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
                }
            } else {
                throw new PDOException('<p>Une erreur est survenue dans la création de votre table.</p>');
            }
        } else {
            throw new PDOException('<p>Une erreur est survenue dans la création de votre base de données.</p>');
        }
    } else {
        throw new PDOException('<p>Une erreur est survenue dans la suppression de votre base de données.</p>');
    }
} catch (PDOException $error) {
    echo $error->getMessage();
}
