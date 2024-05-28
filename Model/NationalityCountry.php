<?php

class NationalityCountry
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private string $id, private string $name, private string $country)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setCountry($country);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setName(string $name): string
    {
        return $this->name = $name;
    }

    public function setCountry(string $country): string
    {
        return $this->country = $country;
    }
}
