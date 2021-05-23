<?php

namespace App\Entity;

use App\Repository\GuildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuildRepository::class)
 */
class Guild
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
     * @ORM\OneToOne(targetEntity=Character::class, inversedBy="guild", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity=GuildMember::class, mappedBy="guild")
     */
    private $guildMembers;

    public function __construct()
    {
        $this->guildMembers = new ArrayCollection();
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

    public function getOwner(): ?Character
    {
        return $this->owner;
    }

    public function setOwner(Character $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|GuildMember[]
     */
    public function getGuildMembers(): Collection
    {
        return $this->guildMembers;
    }

    public function addGuildMember(GuildMember $guildMember): self
    {
        if (!$this->guildMembers->contains($guildMember)) {
            $this->guildMembers[] = $guildMember;
            $guildMember->setGuild($this);
        }

        return $this;
    }

    public function removeGuildMember(GuildMember $guildMember): self
    {
        if ($this->guildMembers->removeElement($guildMember)) {
            // set the owning side to null (unless already changed)
            if ($guildMember->getGuild() === $this) {
                $guildMember->setGuild(null);
            }
        }

        return $this;
    }
}
