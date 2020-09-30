<?php

namespace App\DataFixtures;

use App\Entity\Blog\Comment;
use App\Entity\Blog\Post;
use App\Entity\Blog\Tag;
use App\Entity\Partner;
use App\Entity\Streamer;
use App\Entity\Team\EsportMember;
use App\Entity\Team\Member;
use App\Entity\Team\Role;
use App\Entity\User\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\User\UserInterface;

class DatabaseSeederFixture extends BaseFixture
{
	protected function loadData(ObjectManager $manager)
	{
		$admin = $this->createUser([User::ROLE_ADMIN]);
		$poster = $this->createUser([User::ROLE_DEFAULT, User::ROLE_REDACTEUR]);
		$commentator = $this->createUser([User::ROLE_DEFAULT]);

		$tag1 = $this->createTag();
		$tag2 = $this->createTag();

		$post = $this->createPost($poster, true);
		$post->setTags([$tag1]);

		$post2 = $this->createPost($poster, true);
		$post2->setTags([$tag1, $tag2]);

		$comment = $this->createComment();
		$comment->setAuthor($commentator);
		$comment->setPost($post);

		$direction = $this->createRole(Role::CATEGORY_DIRECTION);
		$administration = $this->createRole(Role::CATEGORY_ADMINISTRATION);
		$members = $this->createRole(Role::CATEGORY_MEMBERS);

		$directionMember = $this->createMember($direction);
		$administrationMember = $this->createMember($administration);
		$membersMember = $this->createMember($members);

		$esportMember = $this->createEsportMember();

		$partner = $this->createPartner();

		$streamer = $this->createStreamer();

		$manager->persist($admin);
		$manager->persist($poster);
		$manager->persist($commentator);
		$manager->persist($tag1);
		$manager->persist($tag2);
		$manager->persist($post);
		$manager->persist($post2);
		$manager->persist($comment);
		$manager->persist($direction);
		$manager->persist($administration);
		$manager->persist($members);
		$manager->persist($directionMember);
		$manager->persist($administrationMember);
		$manager->persist($membersMember);
		$manager->persist($esportMember);
		$manager->persist($partner);
		$manager->persist($streamer);

		$manager->flush();
	}

	private function createUser(array $roles)
	{
		$user = new User();
		$user->setEmail($this->faker->email);
		$user->setDisplayName($this->faker->name);
		$user->setRoles($roles);
		$user->setDiscordId($this->faker->randomNumber(8));
		$user->setFirstName($this->faker->firstName);
		$user->setLastName($this->faker->lastName);
		$user->setDescription($this->faker->text());

		return $user;
	}

	private function createTag()
	{
		$tag = new Tag();
		$tag->setName($this->faker->name);
		$tag->setSlug($this->faker->slug);

		return $tag;
	}

	private function createPost(UserInterface $author, bool $published)
	{
		$post = new Post();
		$post->setTitle($this->faker->sentence);
		$post->setSlug($this->faker->slug);
		$post->setContent($this->faker->text());
		$post->setPublished($published);
		if ($published) {
			$post->setPublishedAt($this->faker->dateTime);
		}
		$post->setAuthor($author);

		return $post;
	}

	private function createComment()
	{
		$comment = new Comment();
		$comment->setContent($this->faker->text);

		return $comment;
	}

	private function createRole(string $category)
	{
		$role = new Role();
		$role->setCategory($category);
		$role->setName($category);

		return $role;
	}

	private function createMember(Role $role)
	{
		$member = new Member();
		$member->setRole($role);
		$member->setNickname($this->faker->name);
		$member->setFirstname($this->faker->firstName);
		$member->setLastname($this->faker->lastName);

		return $member;
	}

	private function createEsportMember()
	{
		$availableGames = EsportMember::getAvailableGames();
		$availableTeams = EsportMember::getAvailableTeams();
		$availableRoles = EsportMember::getAvailableRoles();

		$member = new EsportMember();
		$member->setNickname($this->faker->name);
		$member->setFirstname($this->faker->firstName);
		$member->setLastname($this->faker->lastName);
		$member->setGame($availableGames[array_rand($availableGames)]);
		$member->setTeam($availableTeams[array_rand($availableTeams)]);
		$member->setRole($availableRoles[array_rand($availableRoles)]);

		return $member;
	}

	private function createPartner()
	{
		$partner = new Partner();
		$partner->setName($this->faker->name);
		$partner->setDescription($this->faker->text);
		$partner->setWebsite($this->faker->domainName);
		$partner->setLogo($this->faker->imageUrl());

		return $partner;
	}

	private function createStreamer()
	{
		$streamer = new Streamer();
		$streamer->setName($this->faker->name);
		$streamer->setChannel('Twitch');

		return $streamer;
	}
}
