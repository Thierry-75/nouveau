<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Sequentially;

class RequestPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('courriel', EmailType::class, [
                'attr' => [
                    'class' => 'input-gray',
                    'placeholder' => 'Adresse Email',
                    'autofocus' => true,
                    'required' => true,
                    'mapped'=>false
                ],
                'constraints' => [
                    new Sequentially([
                        new NotBlank(message: ""),
                        new Email(message: 'L\'adresse courriel {{ value }} est incorrecte.',)
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
