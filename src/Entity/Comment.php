<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(type: 'integer')]
    private $comment_id;

    #[ORM\Column(type: 'string', length: 100)]
    private $comment_author;

    #[ORM\Column(type: 'string', length: 255)]
    private $comment_email;

    #[ORM\Column(type: 'string', length: 100)]
    private $comment_status;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

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

    public function getCommentId(): ?int
    {
        return $this->comment_id;
    }

    public function setCommentId(int $comment_id): self
    {
        $this->comment_id = $comment_id;

        return $this;
    }

    public function getCommentAuthor(): ?string
    {
        return $this->comment_author;
    }

    public function setCommentAuthor(string $comment_author): self
    {
        $this->comment_author = $comment_author;

        return $this;
    }

    public function getCommentEmail(): ?string
    {
        return $this->comment_email;
    }

    public function setCommentEmail(string $comment_email): self
    {
        $this->comment_email = $comment_email;

        return $this;
    }

    public function getCommentStatus(): ?string
    {
        return $this->comment_status;
    }

    public function setCommentStatus(string $comment_status): self
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
}
