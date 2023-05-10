<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Nom est obligatoire.']),
                ],
            ])
            ->add('Prenom', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Prénom est obligatoire.']),
                ],
            ])
            ->add('Date_Naissance', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Date de naissance est obligatoire.']),
                ],
            ])
            ->add('login', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ login est obligatoire.']),
                    new Email(['message' => 'Le champ login doit être au format d\'une adresse e-mail.']),
                ],
            ])
            ->add('Numero_Telephone', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Numéro de téléphone est obligatoire.']),
                    new Regex(['pattern' => '/^\d{8}$/', 'message' => 'Le champ Numéro de téléphone doit être composé de 8 chiffres.']),
                ],
            ])

            ->add('Solde', NumberType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ olde est obligatoire.']),
                    new GreaterThan(['value' => 0, 'message' => 'Le champ olde doit être supérieur à zéro.']),
                ],
            ])
            ->add('Username', null, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ Nom d\'utilisateur est obligatoire.']),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save Changes',
            ])
            ->add('annuler', ResetType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
