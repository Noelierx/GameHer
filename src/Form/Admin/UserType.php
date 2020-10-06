<?php

namespace App\Form\Admin;

use App\Entity\Team\Role;
use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserType extends AbstractType
{
	/**
	 * @var TranslatorInterface
	 */
	private $translator;

	public function __construct(TranslatorInterface $translator)
	{
		$this->translator = $translator;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class, ['required' => true])
			->add('displayName', TextType::class, ['required' => true])
			->add('firstname', TextType::class, ['required' => false])
			->add('lastname', TextType::class, ['required' => false])
			->add('picture', FileType::class, [
				'mapped' => false,
				'required' => false,
				'constraints' => [
					new Image(['maxSize' => '2048k']),
				],
				'attr' => [
					'accept' => 'image/*',
				],
			])
			->add('roles', ChoiceType::class, [
				'choices' => User::getAvailableRoles(),
				'choice_label' => function ($choice, $key, $value) {
					return $value;
				},
				'multiple' => true,
				'required' => true,
                'label_attr' => ['class' => 'active'],
			])
			->add('twitter', TextType::class, ['required' => false])
			->add('facebook', TextType::class, ['required' => false])
			->add('youtube', TextType::class, ['required' => false])
			->add('twitch', TextType::class, ['required' => false])
			->add('discord', TextType::class, ['required' => false])
			->add('instagram', TextType::class, ['required' => false])
			->add('save', SubmitType::class, [
				'label' => $this->translator->trans('default.action.save', [], 'admin'),
				'attr' => ['class' => 'btn right'],
			]);
	}
}
