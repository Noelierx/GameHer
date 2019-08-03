<?php

namespace App\Form\Team;

use App\Entity\Team\EsportMember;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Contracts\Translation\TranslatorInterface;

class EsportMemberType extends AbstractType
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
            ->add('nickname', TextType::class, ['required' => true ])
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
            ->add('team', ChoiceType::class, [
                'choices' => EsportMember::getAvailableTeams(),
                'choice_label' => function ($choice, $key, $value) {
                    return $this->translator->trans('members.esport.team.'.$value, [], 'admin');
                },
                'required' => true,
                'label_attr' => ['class' => 'active'],
            ])
            ->add('role', ChoiceType::class, [
                'choices' => EsportMember::getAvailableRoles(),
                'choice_label' => function ($choice, $key, $value) {
                    return $this->translator->trans('members.esport.role.'.$value, [], 'admin');
                },
                'required' => true,
                'label_attr' => ['class' => 'active'],
            ])
            ->add('twitch', TextType::class, ['required' => false])
            ->add('twitter', TextType::class, ['required' => false])
            ->add('facebook', TextType::class, ['required' => false])
            ->add('instagram', TextType::class, ['required' => false])
            ->add('save', SubmitType::class, [
                'label' => $this->translator->trans('default.action.save', [], 'admin'),
                'attr' => ['class' => 'btn right'],
            ]);
    }
}
