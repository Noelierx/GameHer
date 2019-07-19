<?php


namespace App\Form\Team;


use App\Entity\Team\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RoleType extends AbstractType
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
			->add('name', TextType::class)
			->add('category', ChoiceType::class, [
				'choices' => Role::getAvailableCategories(),
				'choice_label' => function ($choice, $key, $value) { return ucfirst($value); },
				'required' => true,
			])
			->add('save', SubmitType::class, [
				'label' => $this->translator->trans('default.action.save', [], 'admin'),
			]);
	}
}
