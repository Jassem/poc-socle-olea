<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use MongoDB\BSON\Timestamp;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\Document(collection="rooms", repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    const STATUS = [
        'Draft' => 'Draft',
        'In review' => 'In review',
        'Approved' => 'Approved',
        'Suspended' => 'Suspended'
    ];

    /**
     * @var string $id
     * @ODM\Id()
     */
    protected $id;

    /**
     * @var string $name
     * @ODM\Field(type="string")
     */
    protected $name;

    /**
     * @var string $style
     * @ODM\Field(type="string", nullable=true)
     */
    protected $style;

    /**
     * @var string $client
     * @ODM\Field(type="string", nullable=true)
     */
    protected $client;

    /**
     * @var string $numeroCommande
     * @ODM\Field(type="string", nullable=true)
     */
    protected $numeroCommande;


    /**
     * @var string $description
     * @ODM\Field(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ODM\Field(type="string")
     * @Assert\Choice({"Draft","In review", "Approved", "Suspended", "Closed", "Archived", "Deleted", "Rejected"})
     */
    private $status;

    /**
     * @var bool $published
     * @ODM\Field(type="bool", nullable=true)
     */
    private $published=false;


    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return bool
     */
    public function isPublished(): ?bool
    {
        return $this->published;
    }

    /**
     * @param bool $published
     */
    public function setPublished(bool $published): void
    {
        $this->published = $published;
    }

    /**
     * @return string
     */
    public function getStyle(): ?string
    {
        return $this->style;
    }

    /**
     * @param string $style
     */
    public function setStyle(string $style): void
    {
        $this->style = $style;
    }

    /**
     * @return string
     */
    public function getClient(): ?string
    {
        return $this->client;
    }

    /**
     * @param string $client
     */
    public function setClient(string $client): void
    {
        $this->client = $client;
    }

    /**
     * @return string
     */
    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    /**
     * @param string $numeroCommande
     */
    public function setNumeroCommande(string $numeroCommande): void
    {
        $this->numeroCommande = $numeroCommande;
    }


}
