<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvents;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                        ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [ 'class'=>'input-gray block w-full p-2.5','required'=>true,'autocomplete' => 'new-password',
                    ],'label_attr'=>['class'=>'text-xs text-cyan-600']
                ],
                'first_options' => [
                    'constraints' => [
                        new Sequentially([
                        new Regex(
                            pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{10}$/i',
                            htmlPattern: '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{10}$'
                        )
                        ])
                    ],
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confimation',
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->addData(...))
        ;

    }

    public function addData(PostSubmitEvent $event): void
    {
        $data = $event->getData();
        if(!$data instanceof User) {
            return;
        }
        $data->setUpdatedAt(new  \DateTimeImmutable());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
