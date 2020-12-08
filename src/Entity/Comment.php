<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
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
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Issue", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $issue;

    /**
     * @ORM\Column(type="datetime")
     */
    private $published;

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

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIssue()
    {
        return $this->issue;
    }

    public function setIssue(Issue $issue): self
    {
        $this->issue = $issue;

        return $this;
    }
}
