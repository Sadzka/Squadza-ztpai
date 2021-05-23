<?php

namespace App\Entity;

use App\Repository\GuildMemberRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GuildMemberRepository::class)
 */
class GuildMember
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Character::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity=Guild::class, inversedBy="guildMembers")
     */
    private $guild;

    /**
     * @ORM\Column(type="smallint")
     */
    private $rank;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): ?Character
    {
        return $this->member;
    }

    public function setMember(Character $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getGuild(): ?Guild
    {
        return $this->guild;
    }

    public function setGuild(?Guild $guild): self
    {
        $this->guild = $guild;

        return $this;
    }

    public function getRank(): ?int
    {
        return $this->rank;
    }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;

        return $this;
    }
}
