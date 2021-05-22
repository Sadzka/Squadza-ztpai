<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemRepository::class)
 */
class Item
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quality;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=127)
     */
    private $icon;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $item_level;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bind_on_pick_up;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $is_unique;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $equip_type;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $slot;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $damage_min;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $damage_max;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $speed;

    /**
     * @ORM\Column(type="integer")
     */
    private $required_level;

    /**
     * @ORM\Column(type="bigint")
     */
    private $sell_price;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $stat_type1;

    /**
     * @ORM\Column(type="integer")
     */
    private $stat_value1;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $stat_type2;

    /**
     * @ORM\Column(type="integer")
     */
    private $stat_value2;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $stat_type3;

    /**
     * @ORM\Column(type="integer")
     */
    private $stat_value3;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $stat_type4;

    /**
     * @ORM\Column(type="integer")
     */
    private $stat_value4;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $socket1;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $socket2;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $socket3;

    /**
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $socket_bonus_type;

    /**
     * @ORM\Column(type="integer")
     */
    private $socket_bonus_value;

    /**
     * @ORM\OneToMany(targetEntity=ItemComment::class, mappedBy="item")
     */
    private $itemComments;

    public function toJson()
    {
        return json_encode(get_object_vars($this));
    }

    public function __construct()
    {
        $this->itemComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuality(): ?int
    {
        return $this->quality;
    }

    public function setQuality(int $quality): self
    {
        $this->quality = $quality;

        return $this;
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

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function getItemLevel(): ?int
    {
        return $this->item_level;
    }

    public function setItemLevel(?int $item_level): self
    {
        $this->item_level = $item_level;

        return $this;
    }

    public function getBindOnPickUp(): ?bool
    {
        return $this->bind_on_pick_up;
    }

    public function setBindOnPickUp(?bool $bind_on_pick_up): self
    {
        $this->bind_on_pick_up = $bind_on_pick_up;

        return $this;
    }

    public function getIsUnique(): ?int
    {
        return $this->is_unique;
    }

    public function setIsUnique(?int $is_unique): self
    {
        $this->is_unique = $is_unique;

        return $this;
    }

    public function getEquipType(): ?string
    {
        return $this->equip_type;
    }

    public function setEquipType(?string $equip_type): self
    {
        $this->equip_type = $equip_type;

        return $this;
    }

    public function getSlot(): ?string
    {
        return $this->slot;
    }

    public function setSlot(?string $slot): self
    {
        $this->slot = $slot;

        return $this;
    }

    public function getDamageMin(): ?int
    {
        return $this->damage_min;
    }

    public function setDamageMin(?int $damage_min): self
    {
        $this->damage_min = $damage_min;

        return $this;
    }

    public function getDamageMax(): ?int
    {
        return $this->damage_max;
    }

    public function setDamageMax(?int $damage_max): self
    {
        $this->damage_max = $damage_max;

        return $this;
    }

    public function getDps()
    {
        if (!$this->damage_min || !$this->damage_max || !$this->speed)
            return null;
        return ($this->damage_min + $this->damage_max)/$this->speed;
    }

    public function getSpeed(): ?float
    {
        return $this->speed;
    }

    public function setSpeed(?float $speed): self
    {
        $this->speed = $speed;

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

    public function getSellPrice(): ?string
    {
        return $this->sell_price;
    }

    public function setSellPrice(string $sell_price): self
    {
        $this->sell_price = $sell_price;

        return $this;
    }

    public function getStats()
    {
        return [
            ['stat' => $this->stat_type1, 'value' => $this->stat_value1],
            ['stat' => $this->stat_type2, 'value' => $this->stat_value2],
            ['stat' => $this->stat_type3, 'value' => $this->stat_value3],
            ['stat' => $this->stat_type4, 'value' => $this->stat_value4]
        ];
    }

    public function getStatType1(): ?string
    {
        return $this->stat_type1;
    }

    public function setStatType1(?string $stat_type1): self
    {
        $this->stat_type1 = $stat_type1;

        return $this;
    }

    public function getStatValue1(): ?int
    {
        return $this->stat_value1;
    }

    public function setStatValue1(int $stat_value1): self
    {
        $this->stat_value1 = $stat_value1;

        return $this;
    }

    public function getStatType2(): ?string
    {
        return $this->stat_type2;
    }

    public function setStatType2(?string $stat_type2): self
    {
        $this->stat_type2 = $stat_type2;

        return $this;
    }

    public function getStatValue2(): ?int
    {
        return $this->stat_value2;
    }

    public function setStatValue2(int $stat_value2): self
    {
        $this->stat_value2 = $stat_value2;

        return $this;
    }

    public function getStatType3(): ?string
    {
        return $this->stat_type3;
    }

    public function setStatType3(?string $stat_type3): self
    {
        $this->stat_type3 = $stat_type3;

        return $this;
    }

    public function getStatValue3(): ?int
    {
        return $this->stat_value3;
    }

    public function setStatValue3(int $stat_value3): self
    {
        $this->stat_value3 = $stat_value3;

        return $this;
    }

    public function getStatType4(): ?string
    {
        return $this->stat_type4;
    }

    public function setStatType4(?string $stat_type4): self
    {
        $this->stat_type4 = $stat_type4;

        return $this;
    }

    public function getStatValue4(): ?int
    {
        return $this->stat_value4;
    }

    public function setStatValue4(int $stat_value4): self
    {
        $this->stat_value4 = $stat_value4;

        return $this;
    }

    public function getSockets()
    {
        return [
            $this->socket1,
            $this->socket1,
            $this->socket1
        ];
    }

    public function getSocket1(): ?string
    {
        return $this->socket1;
    }

    public function setSocket1(string $socket1): self
    {
        $this->socket1 = $socket1;

        return $this;
    }

    public function getSocket2(): ?string
    {
        return $this->socket2;
    }

    public function setSocket2(string $socket2): self
    {
        $this->socket2 = $socket2;

        return $this;
    }

    public function getSocket3(): ?string
    {
        return $this->socket3;
    }

    public function setSocket3(?string $socket3): self
    {
        $this->socket3 = $socket3;

        return $this;
    }

    public function getSocketBonus()
    {
        return [
            "value" => $this->socket_bonus_value,
            "stat" => $this->socket_bonus_type,
        ];
    }
    public function getSocketBonusType(): ?string
    {
        return $this->socket_bonus_type;
    }

    public function setSocketBonusType(?string $socket_bonus_type): self
    {
        $this->socket_bonus_type = $socket_bonus_type;

        return $this;
    }

    public function getSocketBonusValue(): ?int
    {
        return $this->socket_bonus_value;
    }

    public function setSocketBonusValue(int $socket_bonus_value): self
    {
        $this->socket_bonus_value = $socket_bonus_value;

        return $this;
    }

    /**
     * @return Collection|ItemComment[]
     */
    public function getItemComments(): Collection
    {
        return $this->itemComments;
    }

    public function addItemComment(ItemComment $itemComment): self
    {
        if (!$this->itemComments->contains($itemComment)) {
            $this->itemComments[] = $itemComment;
            $itemComment->setItem($this);
        }

        return $this;
    }

    public function removeItemComment(ItemComment $itemComment): self
    {
        if ($this->itemComments->removeElement($itemComment)) {
            // set the owning side to null (unless already changed)
            if ($itemComment->getItem() === $this) {
                $itemComment->setItem(null);
            }
        }

        return $this;
    }
}
