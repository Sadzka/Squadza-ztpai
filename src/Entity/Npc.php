<?php

namespace App\Entity;

use App\Repository\NpcRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NpcRepository::class)
 */
class Npc
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $level;

    /**
     * @ORM\Column(type="integer")
     */
    private $health;

    /**
     * @ORM\Column(type="boolean")
     */
    private $friendly;

    /**
     * @ORM\Column(type="float")
     */
    private $x;

    /**
     * @ORM\Column(type="float")
     */
    private $y;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="e")
     */
    private $location;

    public function toJson()
    {
        return json_encode([
            'id' => $this->getId(),
            'name' => $this->getName(),
            'friendly' => $this->getFriendly(),
            'health' => $this->getHealth(),
            'level' => $this->getLevel(),
            'x' => $this->getX(),
            'y' => $this->getY(),
            'location' => [
                'name' => $this->location->getName(),
                'id' => $this->location->getId()
            ],
        ]);
    }

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocation()
    {
        return $this->location;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getHealth(): ?int
    {
        return $this->health;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getFriendly(): ?bool
    {
        return $this->friendly;
    }

    public function setFriendly(bool $friendly): self
    {
        $this->friendly = $friendly;

        return $this;
    }

    public function getX(): ?float
    {
        return $this->x;
    }

    public function setX(float $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?float
    {
        return $this->y;
    }

    public function setY(float $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

}
