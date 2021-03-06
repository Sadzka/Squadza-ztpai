<?php

namespace App\Entity;

use App\Repository\ItemCommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ItemCommentRepository::class)
 */
class ItemComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Item::class, inversedBy="itemComments")
     */
    private $item;

    /**
     * @ORM\OneToOne(targetEntity=Comment::class, cascade={"persist", "remove"})
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItem(): ?Item
    {
        return $this->item;
    }

    public function setItem(?Item $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getComment(): ?comment
    {
        return $this->comment;
    }

    public function setComment(?comment $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
