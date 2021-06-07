<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class StreamType extends AbstractType
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
			->add('streamName', TextType::class, ['required' => true])
			->add('activityName', TextType::class, ['required' => true])
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
			->add('streamedAt', DateType::class, [
				'widget' => 'single_text',
				'format' => 'yyyy-MM-dd',
				'required' => true,
				'attr' => ['class' => 'datepicker'],
				'label' => 'Date of streaming',
			])
			
			->add('save', SubmitType::class, [
				'label' => $this->translator->trans('default.action.save', [], 'admin'),
				'attr' => ['class' => 'btn right'],
			]);
	}
}
