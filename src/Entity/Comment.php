<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=1023)
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $last_edit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLastEdit(): ?\DateTimeInterface
    {
        return $this->last_edit;
    }

    public function setLastEdit(?\DateTimeInterface $last_edit): self
    {
        $this->last_edit = $last_edit;

        return $this;
    }

    public function dropForeignKeys($doctrine)
    {
        $commentLikeRepository = $doctrine->getRepository(CommentLike::class);
        $articleCommentRepository = $doctrine->getRepository(ArticleComment::class);

        // drop foreign keys first
        $commentLikes = $commentLikeRepository->findByComment($this);
        foreach ($commentLikes as $commentLike) {
            $doctrine->getManager()->remove($commentLike);
        }

        $articleComment = $articleCommentRepository->findOneByComment($this);
        if ($articleComment)
            $doctrine->getManager()->remove($articleComment);
        }
    }

