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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Sequentially;


class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('title',TextType::class,['attr'=>['class'=>'w-full mt-1 px-2 py-2 text-xl border-2 border-neutral-200 rounded-lg shadow-sm shadow-black'],
            'label'=>"Titre",
            'label_attr'=> ['class' => 'block text-lg font-medium text-cyan-800 mb-1 ml-2'],
            'constraints'=>[
                new NotBlank(message: 'Titre obligatoire !')
            ]
                    ]
            )
            ->add('contenu',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray text-lg px-3 py-3 mb-4',
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_introduction',
                        'height' => 500
                    ],
                    'label' => 'Texte',
                    'label_attr' => ['class' => 'block text-lg font-medium text-cyan-800 mb-1 ml-2']]
            )
            ->add('photos',FileType::class, options: [
                'multiple'=>true,
                'mapped'=>false,
                'attr'=>['class'=>'w-full bg-white px-3 py-3.5 mt-3 mb-4 text-xl rounded-lg shadow-md shadow-black'],
                'label'=>'Télécharger 3 photos',
                'label_attr' => ['class' => 'block text-lg font-medium text-cyan-800 mb-1 ml-2'],
                'constraints'=>[
                    new Sequentially([
                        new NotBlank(message: '3 Photos '),
                        new Count(
                            min: 1,
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
