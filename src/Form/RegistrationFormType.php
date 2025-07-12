<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
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
                    'class' => 'input-gray',
                    'placeholder' => 'Email',
                    'autofocus' => true,
                    'required' => true,
                ],
                'label'=>false,
                'constraints' => [
                    new Sequentially([
                        new NotBlank(),
                        new Email(message: 'L\'adresse courriel {{ value }} est incorrecte.')
                    ])
                ]
            ])
            ->add('login',TextType::class,['attr'=>[
                'class'=>'input-gray',
                'placeholder'=>'Pseudo',
                'required'=>true],
                'label'=>false,
                'constraints'=>[
                    new Sequentially([
                        new NotBlank(),
                        new Regex(
                            pattern:"/^[a-zA-Z '-éàèêçïù]{10,30}$/i",
                            htmlPattern:"^[a-zA-Z '-éàèêçïù]{10,30}$")
                    ])
                ]
                
                ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'input-gray',
                    'placeholder' => 'Mot de passe',
                    'required' => true
                ],
                'label'=>false,
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
                'class'=>'input-gray',
                'required'=>false,
                'placeholder'=>'Téléphone   facultatif *'],
                'label'=>false,
                'constraints'=>[
                    new Regex(
                        pattern:'/^[(]?[0-9]{10,10}$/i',
                        htmlPattern:'^[(]?[0-9]{10,10}$'
                    )
                ]
            ])
            ->add('portrait',FileType::class,['attr'=>[
                'class'=>'input-gray',
                'required'=>true,
                'mapped'=>false,
                'multiple'=>false,
            ],
            'constraints'=>[
                new Sequentially([
                    new NotBlank(),
                    new Image(
                        minWidth:'500',
                        maxWidth:'800',
                        minHeight:'500',
                        maxHeight:'800'
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
                    'class' => '',
                    'required' => true
                ],
                'label' => ' Accepter les conditions générales',
                'label_attr' => ['class' => 'font-light text-gray-500 ml-4 dark:text-gray-300 text-xs', 'id' => 'agree_state'],
                'mapped' => false,
                'constraints' => [
                    new IsTrue()
                ],
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->addData(...))
        ;
    }

        public function addData(PostSubmitEvent $event)
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
