<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "attr" => [
                    "placeholder" => "Saisir un email.",
                    "class" => "flex-1 flex"
                ],
            ])
            ->add('full_name', TextType::class, [
                "label" => "Indiquez votre nom complet",
                "attr" => [
                    "placeholder" => "Votre nom complet.",
                    "class" => "flex-1 flex"
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,

                'constraints' => [
                    new IsTrue([
                        'message' => 'Veuillez accepter nos conditions.',
                    ]),
                ],
                "row_attr" => [
                    "class" => "form-group flex"
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux champs mot de passe doivent être identiques',
                'mapped' => false,
                'required' => false,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        "placeholder" => "Entrez un mot de passe."
                    ]
                ],
                'second_options' => [
                    'label' => 'Répéter vôtre mot de passe',
                    'attr' => [
                        "placeholder" => "Veuillez saisir le même mot de passe."
                    ]
                ],
                'attr' => [
                    'autocomplete' => 'new-password',
                    "class" => "flex-1 flex"
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veullez saisir un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} charactères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                "row_attr" => [
                    "class" => "form-group flex"
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
