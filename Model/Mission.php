<?php

class Mission
{
    // Fonction constructeur de notre objet avec PHP 8 (propriété déclarée dans les arguments de notre fonction):
    public function __construct(private string $id, private string $title, private string $description, private string $codeName, private DateTime $missionStart, private DateTime $missionEnd, private string $nationalityCountryId, private string $specialityId, private string $missionTypeId, private string $missionStatusId)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setCodeName($codeName);
        $this->setMissionStart($missionStart);
        $this->setMissionEnd($missionEnd);
        $this->setNationalityCountryId($nationalityCountryId);
        $this->setspecialityId($specialityId);
        $this->setMissionTypeId($missionTypeId);
        $this->setMissionStatusId($missionStatusId);
    }

    // Etant donné que j'ai choisi de mettre en privé les propriétés de ma classe, je dois faire les getters et les setters afin d'accéder et d'enregistrer les données:
    public function getId(): string
    {
        return $this->id;
    }

    public function getTite(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCodeName(): string
    {
        return $this->codeName;
    }

    public function getMissionStart(): Datetime
    {
        return $this->missionStart;
    }

    public function getMissionEnd(): DateTime
    {
        return $this->missionEnd;
    }

    public function getNationalityCountryId(): string
    {
        return $this->nationalityCountryId;
    }

    public function getSpecialityId(): string
    {
        return $this->specialityId;
    }

    public function getMissionTypeId(): string
    {
        return $this->missionTypeId;
    }

    public function getMissionStatusId(): string
    {
        return $this->missionStatusId;
    }

    public function setId(string $id): string
    {
        return $this->id = $id;
    }

    public function setTitle(string $title): string
    {
        return $this->title = $title;
    }

    public function setDescription(string $description): string
    {
        return $this->description = $description;
    }

    public function setCodeName(string $codeName): string
    {
        return $this->codeName = $codeName;
    }

    public function setMissionStart(DateTime $missionStart): Datetime
    {
        return $this->missionStart = $missionStart;
    }

    public function setMissionEnd(DateTime $missionEnd): Datetime
    {
        return $this->missionEnd = $missionEnd;
    }

    public function setNationalityCountryId(string $nationalityCountryId): string
    {
        return $this->nationalityCountryId = $nationalityCountryId;
    }

    public function setSpecialityId(string $specialityId): string
    {
        return $this->specialityId = $specialityId;
    }

    public function setMissionTypeId(string $missionTypeId): string
    {
        return $this->missionTypeId = $missionTypeId;
    }

    public function setMissionStatusId(string $missionStatusid): string
    {
        return $this->missionStatusId = $missionStatusid;
    }
}
