<?php

class Person
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private string $id, private string $firstname,  private string $lastname,  private DateTime $dateOfBirth,  private string $identityCode,  private string $nationalityCountryId,  private string $missionId)
    {
        $this->setId($id);
        $this->setFirstname($firstname);
        $this->setLastname($lastname);
        $this->setDateOfBirth($dateOfBirth);
        $this->setIdentityCode($identityCode);
        $this->setNationalityCountryId($nationalityCountryId);
        $this->setMissionId($missionId);
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

    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }

    public function getIdentityCode(): string
    {
        return $this->identityCode;
    }

    public function getNationalityCountryId(): string
    {
        return $this->nationalityCountryId;
    }

    public function getMissionId(): string
    {
        return $this->missionId;
    }

    public function setId(string $id): string
    {
        return $this->id = ($id);
    }

    public function setFirstname(string $firstname): string
    {
        return $this->firstname = ($firstname);
    }

    public function setLastname(string $lastname): string
    {
        return $this->lastname = ($lastname);
    }

    public function setDateOfBirth(DateTime $dateOfBirth): DateTime
    {
        return $this->dateOfBirth = ($dateOfBirth);
    }

    public function setIdentityCode(string $identityCode): string
    {
        return $this->identityCode = ($identityCode);
    }

    public function setNationalityCountryId(string $nationalityCountryId): string
    {
        return $this->nationalityCountryId = ($nationalityCountryId);
    }

    public function setMissionId(string $missionId): string
    {
        return $this->missionId = ($missionId);
    }
}
