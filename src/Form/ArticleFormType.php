<?php

namespace App\Form;

use App\Entity\Article;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EmilePerron\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('title',TextType::class,['attr'=>['class'=>'w-full px-3 py-3 mb-3 text-xl rounded-lg shadow-md shadow-black'],
            'label'=>"Titre",
            'label_attr'=> ['class' => 'block text-lg font-medium text-cyan-800 mb-1'],
            'constraints'=>[
                new NotBlank(message: 'Titre obligatoire !')
            ]
                    ]
            )
            ->add('introduction',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray text-lg mb-3',
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_introduction',
                        'height' => 225
                    ],
                    'label' => 'Introduction :',
                    'label_attr' => ['class' => 'block text-lg font-medium text-cyan-800 mb-1']]
            )
            ->add('developpement',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray text-lg mb-3',
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_developpement',
                        'height' => 300
                    ],
                    'label' => 'Développement:',
                    'label_attr' => ['class' => 'block text-lg font-medium text-cyan-800 mb-1'],
                      'constraints'=>[
                      new NotBlank(message: 'Développement obligatoire ')
                    ]
                ]
            )
            ->add('conclusion',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray text-lg mb-3',
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_conclusion',
                        'height' => 225
                    ],
                    'label' => 'Conclusion :',
                    'label_attr' => ['class' => 'block text-lg font-medium text-cyan-800 mb-1']

                ])
            ->add('photos',FileType::class, options: [
                'multiple'=>true,
                'mapped'=>false,
                'attr'=>['class'=>'w-full bg-white py-3 px-3 text-xl mb-3 rounded-lg shadow-md shadow-black'],
                'label'=>'Télécharger 3 photos',
                'label_attr' => ['class' => 'block text-lg font-medium text-cyan-800 mb-1'],
                'constraints'=>[
                    new Sequentially([
                        new NotBlank(message: 'obligatoire'),
                        new Count(
                            min: 3,
                            max: 3,
                            exactMessage: '3 photos !',
                            minMessage: '3 photos SVP',
                            maxMessage: '3 photos SVP'
                        )
                    ])
                ]
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->addDate(...))
        ;
    }

    public function addDate(PostSubmitEvent $event): void
    {
        $data = $event->getData();
        if(!$data instanceof Article) {
            return;
        }
        $data->setCreatedAt(new \DateTimeImmutable());

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
