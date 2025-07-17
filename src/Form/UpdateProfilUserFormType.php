<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Sequentially;
use Symfony\Component\Validator\Constraints\File;

class UpdateProfilUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('login',TextType::class,['attr'=>['class'=>'input-gray mt-1 mb-1','autofocus'=>true],'label'=>'Identifiant',
                'required'=>false,
                'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
                'constraints'=>[
                    new Sequentially([
                            new Regex(
                                pattern:"/^.{3,27}#[0-9]{2}$/i",
                                htmlPattern:"^.{3,27}#[0-9]{2}$")
                    ])
                ]
                ])
            ->add('phone',TextType::class,['attr'=>['class'=>'input-gray mt-1 mb-1'],'label'=>'Téléphone',
                'required'=>false,
                'label_attr'=>['class'=>'text-cyan-800 text-xs mb-0'],
                'constraints'=>[
                    new Sequentially([
                        new Regex(
                            pattern: "/^0[1-9]([-. ]?[0-9]{2}){4}$/",
                            htmlPattern: "^0[1-9]([-. ]?[0-9]{2}){4}$"
                        )
                    ])
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
                            minWidth: '660',
                            maxWidth: '1380',
                            maxHeight: '2050',
                            minHeight: '999'
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
            ->addEventListener(FormEvents::POST_SUBMIT, $this->addData(...))
        ;
    }

    public function addData(PostSubmitEvent $event): void
    {
        $data = $event->getData();
        if (!($data instanceof User)) {
            return;
        }
        $data->setUpdatedAt(new \DateTimeImmutable());
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
