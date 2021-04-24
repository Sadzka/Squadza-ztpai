<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=127, options={"default" : "default.png"})
     */
    private $avatar;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=ArticleComment::class, mappedBy="user")
     */
    private $articlecomments;

    /**
     * @ORM\OneToMany(targetEntity=ArticleCommentLike::class, mappedBy="User")
     */
    private $articleCommentLikes;

    public function __construct() 
    {
        $this->avatar = 'default.png';
        $this->roles = ['{"role" : "ROLE_USER"}'];
        $this->articleComments = new ArrayCollection();
        $this->articlecomments = new ArrayCollection();
        $this->articleCommentLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    /**
     * @return Collection|ArticleComment[]
     */
    public function getArticleComments(): Collection
    {
        return $this->articleComments;
    }

    public function addArticleComment(ArticleComment $articleComment): self
    {
        if (!$this->articleComments->contains($articleComment)) {
            $this->articleComments[] = $articleComment;
            $articleComment->setArticleIdUserId($this);
        }

        return $this;
    }

    public function removeArticleComment(ArticleComment $articleComment): self
    {
        if ($this->articleComments->removeElement($articleComment)) {
            // set the owning side to null (unless already changed)
            if ($articleComment->getArticleIdUserId() === $this) {
                $articleComment->setArticleIdUserId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleCommentLike[]
     */
    public function getArticleCommentLikes(): Collection
    {
        return $this->articleCommentLikes;
    }

    public function addArticleCommentLike(ArticleCommentLike $articleCommentLike): self
    {
        if (!$this->articleCommentLikes->contains($articleCommentLike)) {
            $this->articleCommentLikes[] = $articleCommentLike;
            $articleCommentLike->addUser($this);
        }

        return $this;
    }

    public function removeArticleCommentLike(ArticleCommentLike $articleCommentLike): self
    {
        if ($this->articleCommentLikes->removeElement($articleCommentLike)) {
            $articleCommentLike->removeUser($this);
        }

        return $this;
    }
}
