<?php

namespace App\Entity\Blog;

use App\Entity\StringUuidTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 */
class Tag
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
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    protected $name;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", nullable=false)
     */
    protected $slug;

    /**
     * @var Collection|Post[]
     * @ORM\ManyToMany(targetEntity="App\Entity\Blog\Post", mappedBy="tags")
     */
    protected $posts;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
        $this->posts = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function setPosts($posts): self
    {
        $this->posts = $posts;

        return $this;
    }

    public function addPost(Post $post): self
    {
        $this->posts->add($post);

        return $this;
    }

    public function removePost(Post $post): self
    {
        $this->posts->$this->remove($post);

        return $this;
    }
}
