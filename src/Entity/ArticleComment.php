<?php

namespace App\Entity;

use App\Repository\ArticleCommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ArticleCommentRepository::class)
 */
class ArticleComment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"show_comment"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="User")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ArticleComments")
     * @Groups({"show_comment"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=1024)
     * @Groups({"show_comment"})
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"show_comment"})
     */
    private $date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"show_comment"})
     */
    private $last_edit;

    public function __construct(
        $articleId,
        $userId,
        string $comment,
        $date = null,
        $lastEdit = null)
    {
        $this->article = $articleId;
        $this->user = $userId;
        $this->comment = $comment;
        $this->date = $date;
        $this->last_edit = $lastEdit;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticle(): ?article
    {
        return $this->article;
    }

    public function setArticle(?article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
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
}
