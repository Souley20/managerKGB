<?php

class User
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private string $id, private string $firstname, private string $lastname, private string $email, private string $password, private DateTime $createdAt, private string $roleId)
    {
        $this->setId($id);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setCreatedAt($createdAt);
        $this->setRoleId($roleId);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getId(): string
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getRoleId(): string
    {
        return $this->roleId;
    }

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setFirstname(string $firstname): string
    {
        return $this->firstname = $firstname;
    }

    public function setLastname(string $lastname): string
    {
        return $this->lastname = $lastname;
    }

    public function setEmail(string $email): string
    {
        return $this->email = $email;
    }

    public function setPassword(string $password): string
    {
        return $this->password = $password;
    }

    public function setCreatedAt(DateTime $createdAt): DateTime
    {
        return $this->createdAt = $createdAt;
    }

    public function setRoleId(string $roleId): string
    {
        return $this->roleId = $roleId;
    }
}
