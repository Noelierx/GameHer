<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactForm extends AbstractType
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
            ->add('subject', TextType::class, [
                'label' => $this->translator->trans('contact.form.subject'),
            ])
            ->add('nickname', TextType::class, [
                'label' => $this->translator->trans('contact.form.nickname'),
            ])
            ->add('email', EmailType::class, [
                'label' => $this->translator->trans('contact.form.email'),
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'style' => 'height:10rem',
                    'class' => 'materialize-textarea',
                ],
                'label' => $this->translator->trans('contact.form.message'),
            ])
            ->add('data_usage', CheckboxType::class, [
                'attr' => ['class' => 'filled-in'],
            ])
            ->add('send', SubmitType::class, [
                'label' => $this->translator->trans('contact.form.send'),
                'attr' => ['class' => 'btn'],
            ]);
    }
}
