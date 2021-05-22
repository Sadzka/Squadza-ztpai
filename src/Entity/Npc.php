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
     * @ORM\OneToMany(targetEntity=Location::class, mappedBy="npc")
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $x;

    /**
     * @ORM\Column(type="integer")
     */
    private $y;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="npcs")
     */
    private $Location;

    /**
     * @ORM\OneToMany(targetEntity=Quest::class, mappedBy="start_npc")
     */
    private $quests;

    /**
     * @ORM\OneToMany(targetEntity=NpcComment::class, mappedBy="npc")
     */
    private $npcComment;

    public function __construct()
    {
        $this->location = new ArrayCollection();
        $this->quests = new ArrayCollection();
        $this->npcComment = new ArrayCollection();
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
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
            $location->setNpc($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->location->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getNpc() === $this) {
                $location->setNpc(null);
            }
        }

        return $this;
    }

    public function getX(): ?int
    {
        return $this->x;
    }

    public function setX(int $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }

    public function setLocation(?Location $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    /**
     * @return Collection|Quest[]
     */
    public function getQuests(): Collection
    {
        return $this->quests;
    }

    public function addQuest(Quest $quest): self
    {
        if (!$this->quests->contains($quest)) {
            $this->quests[] = $quest;
            $quest->setStartNpc($this);
        }

        return $this;
    }

    public function removeQuest(Quest $quest): self
    {
        if ($this->quests->removeElement($quest)) {
            // set the owning side to null (unless already changed)
            if ($quest->getStartNpc() === $this) {
                $quest->setStartNpc(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NpcComment[]
     */
    public function getNpcComment(): Collection
    {
        return $this->npcComment;
    }

    public function addComment(NpcComment $npcComment): self
    {
        if (!$this->npcComment->contains($npcComment)) {
            $this->npcComment[] = $npcComment;
            $npcComment->setNpc($this);
        }

        return $this;
    }

    public function removeComment(NpcComment $comment): self
    {
        if ($this->npcComment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getNpc() === $this) {
                $comment->setNpc(null);
            }
        }

        return $this;
    }
}
