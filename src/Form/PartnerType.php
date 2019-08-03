<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class PartnerType extends AbstractType
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
            ->add('name', TextType::class, ['required' => true ])
            ->add('description', TextareaType::class, [
				'required' => true,
                'attr' => ['rows' => 5, 'class' => 'materialize-textarea'],
            ])
            ->add('logo', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image(['maxSize' => '2048k']),
                ],
                'attr' => [
                    'accept' => 'image/*',
                ],
            ])
            ->add('website', TextType::class, [
                'required' => false,
                'attr' => [],
            ])
            ->add('twitter', TextType::class, [
                'required' => false,
                'attr' => [],
            ])
            ->add('facebook', TextType::class, [
                'required' => false,
                'attr' => [],
            ])
            ->add('instagram', TextType::class, [
                'required' => false,
                'attr' => [],
            ])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('default.action.save', [], 'admin'),
                'attr' => ['class' => 'btn right'],
            ]);
    }
}
