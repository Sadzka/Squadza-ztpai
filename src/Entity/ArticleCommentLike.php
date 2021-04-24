<?php

namespace App\Entity;

use App\Repository\ArticleCommentLikeRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ArticleCommentLikeRepository::class)
 * @UniqueEntity(fields={"article_comment_id", "user_id"}, message="?error?")
 */
class ArticleCommentLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ArticleComment::class, inversedBy="articleCommentLikes")
     */
    private $articleComment;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articleCommentLikes")
     */
    private $User;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleComment(): ?ArticleComment
    {
        return $this->ArticleComment;
    }

    public function setArticleComment(?ArticleComment $articleComment): self
    {
        $this->articleComment = $articleComment;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }
}
