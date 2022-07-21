<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $answer;

    #[ORM\OneToOne(inversedBy: 'reponse', targetEntity: Comment::class, cascade: ['persist', 'remove'])]
    private $fk_comment_id;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getFkCommentId(): ?Comment
    {
        return $this->fk_comment_id;
    }

    public function setFkCommentId(?Comment $fk_comment_id): self
    {
        $this->fk_comment_id = $fk_comment_id;

        return $this;
    }
}
