<?php

namespace App\Form\Blog;

use App\Entity\Blog\Tag;
use App\Form\DateTimeType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostType extends AbstractType
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
			->add('title', TextType::class, ['required' => true])
			->add('content', CKEditorType::class, [
				'config'     => ['height' => '500px'],
				'required'   => true,
				'label_attr' => ['style' => 'transform: translateY(-14px) scale(0.8);transform-origin: 0 0;'],
			])
			->add('picture', FileType::class, [
				'mapped'      => false,
				'required'    => false,
				'constraints' => [new Image(['maxSize' => '2048k'])],
				'attr'        => ['accept' => 'image/*'],
			])
			->add('tags', EntityType::class, [
				'class'        => Tag::class,
				'choice_label' => 'name',
				'multiple'     => true,
				'required'     => false,
			])
			->add('publishedAt', DateTimeType::class, [
				'required' => false,
			])
			->add('published')
			->add('save', SubmitType::class, [
				'label' => $this->translator->trans('default.action.save', [], 'admin'),
				'attr'  => ['class' => 'btn right'],
			]);
	}
}
