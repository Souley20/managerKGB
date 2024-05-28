<?php

class Role
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):private 
    public function __construct(private string $id, private string $name)
    {
        $this->setId($id);
        $this->setName($name);
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

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setName(string $name): string
    {
        return $this->name = $name;
    }
}
