<?php

namespace App\Entity\Blog;

use App\Entity\StringUuidTrait;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Post
{
    use StringUuidTrait;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var UuidInterface
     * @ORM\Column(type="uuid")
     */
    protected $uuid;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected $title;

    /**
     * @var string
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", nullable=false)
     */
    protected $slug;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=false)
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected $content;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    protected $picture;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $published = false;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="posts")
     */
    protected $author;

    /**
     * @var Collection|Comment[]
     * @ORM\OneToMany(targetEntity="App\Entity\Blog\Comment", mappedBy="post")
     */
    protected $comments;

    /**
     * @var Collection|Tag[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Blog\Tag", inversedBy="posts")
     */
    protected $tags;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $publishedAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $deletedAt;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->tags = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): UserInterface
    {
        return $this->author;
    }

    public function setAuthor(UserInterface $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublishedAt(): ?DateTime
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(DateTime $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function setTags($tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function addTag(Tag $tag): self
    {
        $this->tags->add($tag);

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->$this->remove($tag);

        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function setComments($comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function addComment(Comment $comment): self
    {
        $this->comments->add($comment);

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        $this->comments->$this->remove($comment);

        return $this;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function isPublished(): bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;
        if ($published === true) {
            $this->setPublishedAt(new DateTime());
        }

        return $this;
    }
}
