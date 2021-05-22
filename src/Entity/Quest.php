<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestRepository::class)
 */
class Quest
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
     * @ORM\ManyToOne(targetEntity=Npc::class, inversedBy="quests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $startNpc;

    /**
     * @ORM\ManyToOne(targetEntity=Npc::class, inversedBy="quests")
     */
    private $endNpc;

    /**
     * @ORM\Column(type="bigint")
     */
    private $gold_reward;

    /**
     * @ORM\Column(type="integer")
     */
    private $required_level;

    /**
     * @ORM\OneToMany(targetEntity=QuestComment::class, mappedBy="quest")
     */
    private $questComments;

    public function toJson()
    {
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'reqlv' => $this->required_level,
            'start_npc_id' => $this->getStartNpc()->getId(),
            'start_npc_name' => $this->getStartNpc()->getName(),
            'end_npc_id' => $this->getEndNpc()->getId(),
            'end_npc_name' => $this->getEndNpc()->getName(),
            'rewards' => $this->gold_reward
        ];
        return json_encode($array);
    }

    public function __construct()
    {
        $this->questComments = new ArrayCollection();
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

    public function getStartNpc(): ?Npc
    {
        return $this->startNpc;
    }

    public function setStartNpc(?Npc $startNpc): self
    {
        $this->startNpc = $startNpc;

        return $this;
    }

    public function getEndNpc(): ?Npc
    {
        return $this->endNpc;
    }

    public function setEndNpc(?Npc $endNpc): self
    {
        $this->endNpc = $endNpc;

        return $this;
    }

    public function getGoldReward(): ?string
    {
        return $this->gold_reward;
    }

    public function setGoldReward(string $gold_reward): self
    {
        $this->gold_reward = $gold_reward;

        return $this;
    }

    public function getRequiredLevel(): ?int
    {
        return $this->required_level;
    }

    public function setRequiredLevel(int $required_level): self
    {
        $this->required_level = $required_level;

        return $this;
    }

    /**
     * @return Collection|QuestComment[]
     */
    public function getQuestComments(): Collection
    {
        return $this->questComments;
    }

    public function addQuestComment(QuestComment $questComment): self
    {
        if (!$this->questComments->contains($questComment)) {
            $this->questComments[] = $questComment;
            $questComment->setQuest($this);
        }

        return $this;
    }

    public function removeQuestComment(QuestComment $questComment): self
    {
        if ($this->questComments->removeElement($questComment)) {
            // set the owning side to null (unless already changed)
            if ($questComment->getQuest() === $this) {
                $questComment->setQuest(null);
            }
        }

        return $this;
    }
}
