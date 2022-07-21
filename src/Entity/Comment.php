<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'comment')]
    #[ORM\JoinColumn(nullable: false)]
    private $articles_id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'user_id')]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    #[ORM\Column(type: 'boolean')]
    private $comment_status;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToOne(mappedBy: 'fk_comment_id', targetEntity: Reponse::class, cascade: ['persist', 'remove'])]
    private $reponse;



    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getArticlesId(): ?Article
    {
        return $this->articles_id;
    }

    public function setArticlesId(?Article $articles_id): self
    {
        $this->articles_id = $articles_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCommentStatus(): ?Bool
    {
        return $this->comment_status;
    }

    public function setCommentStatus(Bool $comment_status): self
    {
        $this->comment_status = $comment_status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getReponse(): ?Reponse
    {
        return $this->reponse;
    }

    public function setReponse(?Reponse $reponse): self
    {
        // unset the owning side of the relation if necessary
        if ($reponse === null && $this->reponse !== null) {
            $this->reponse->setFkCommentId(null);
        }

        // set the owning side of the relation if necessary
        if ($reponse !== null && $reponse->getFkCommentId() !== $this) {
            $reponse->setFkCommentId($this);
        }

        $this->reponse = $reponse;

        return $this;
    }
}
