<?php


namespace App\Entity\Blog;

use App\Entity\StringUuidTrait;
use App\Entity\User\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity)
 */
class Comment
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
	 * @ORM\Column(type="text", nullable=false)
	 */
	protected $content;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="comments")
	 */
	protected $author;

	/**
	 * @var Post
	 * @ORM\ManyToOne(targetEntity="App\Entity\Blog\Post", inversedBy="comments")
	 */
	protected $post;

	public function __construct()
	{
		$this->uuid = Uuid::uuid4();
	}
}
