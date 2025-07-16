<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'input-gray mt-1  mb-1',
                    'placeholder' => 'Email',
                    'autofocus' => true,
                    'required' => true,
                ],
                'label'=>'Email ',
                 'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
                'constraints' => [
                    new Sequentially([
                        new NotBlank(),
                        new Email(message: 'L\'adresse courriel {{ value }} est incorrecte.')
                    ])
                ]
            ])
            ->add('login',TextType::class,['attr'=>[
                'class'=>'input-gray mt-1 mb-1',
                'placeholder'=>'Exemple: KiBender#12',
                'required'=>true],
                'label'=>'Pseudo',
                  'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
                'constraints'=>[
                    new Sequentially([
                        new NotBlank(),
                        new Regex(
                            pattern:"/^.{3,27}#[0-9]{2}$/i",
                            htmlPattern:"^.{3,27}#[0-9]{2}$")
                    ])
                ]

                ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'input-gray mt-1 mb-1',
                    'placeholder' => 'Mot de passe',
                    'required' => true
                ],
                'label'=>'Mot de passe',
                 'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
                'constraints' => [
                    new Sequentially([
                        new NotBlank(),
                        new Regex(
                            pattern: '/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{10}$/i',
                            htmlPattern: '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{10}$'
                        )
                    ])
                ],
            ])
            ->add('phone',TextType::class,['attr'=>[
                'class'=>'input-gray mt-1 mb-1',
                'required'=>false,
                'placeholder'=>'Téléphone   facultatif *'],
                'label'=>'Téléphone',
                   'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
                'constraints'=>[
                    new Regex(
                        pattern:'/^[(]?[0-9]{10,10}$/i',
                        htmlPattern:'^[(]?[0-9]{10,10}$'
                    )
                ]
            ])
            ->add('portrait',FileType::class,['attr'=>[
                'class'=>'input-gray mt-1 mb-1',
                'required'=>true,
                'mapped'=>false,
                'multiple'=>false,
            ],
            'label'=>'Photo',
            'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
            'constraints'=>[
                new Sequentially([
                    new NotBlank(),
                    new Image(
                        minWidth: '800',
                        maxWidth: '1024',
                        maxHeight: '768',
                        minHeight: '600'
                    ),
                    new File(
                        maxSize:'2M',
                        maxSizeMessage: 'Max 2Mo',
                        extensions: ['jpeg','jpg'],
                        extensionsMessage:'Image type jpeg/jpg'
                )

                ])
            ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => [
                    'class' => 'mb-1 mt-1',
                    'required' => true
                ],
                'label' => ' Accepter les conditions générales',
                'label_attr' => ['class' => 'font-light text-cyan-800 ml-4 dark:text-gray-300 text-xs', 'id' => 'agree_state'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue()
                ],
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->addData(...))
        ;
    }

        public function addData(PostSubmitEvent $event): void
        {
        $data = $event->getData();
        if (!($data instanceof User)) return;
        $data->setCreatedAt(new \DateTimeImmutable());
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
