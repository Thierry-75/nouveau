<?php

namespace App\Form;

use App\Entity\Article;
use Eckinox\TinymceBundle\Form\Type\TinymceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('title',TextType::class)
            ->add('introduction',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray',
                        'required' => true,
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_content',
                        'height' => 390
                    ],
                    'label' => 'Corps de l\'article :',
                    'label_attr' => ['class' => 'block text-lg font-medium text-gray-800 mb-1']]
            )
            ->add('developpement',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray',
                        'required' => true,
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_content',
                        'height' => 390
                    ],
                    'label' => 'Corps de l\'article :',
                    'label_attr' => ['class' => 'block text-lg font-medium text-gray-800 mb-1']]
            )
            ->add('conclusion',TinymceType::class, [
                    'attr' => [
                        'class' => 'input-gray',
                        'required' => true,
                        'toolbar' => 'undo redo | bold italic | forecolor backcolor | template | alignleft aligncenter alignright alignjustify | bullist numlist | link | spellchecker',
                        'id' => 'article_form_content',
                        'height' => 390
                    ],
                    'label' => 'Corps de l\'article :',
                    'label_attr' => ['class' => 'block text-lg font-medium text-gray-800 mb-1']]
            )
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
        $data->setSlug(strtolower($data->getTitle()));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
