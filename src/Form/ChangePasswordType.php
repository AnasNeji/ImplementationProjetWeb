<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ oldPassword est obligatoire',
                    ]),
                ],
                'required' => true,
            ])
            ->add('newPassword', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le champ newPassword est obligatoire',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Le champ newPassword doit avoir au moins {{ limit }} caractères',
                        // add more constraints if needed
                    ]),
                ],
                'empty_data' => '', // or null
                'required' => true,
            ])
            ->add('confirmNewPassword', PasswordType::class,[
                'empty_data' => '', // or null
                'required' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Change Password',


            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}
