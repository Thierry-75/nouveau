<?php

namespace App\Form;

use App\Entity\Category;
use App\Model\SearchData;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q',TextType::class,['attr'=>['class'=>'input-gray','placeholder'=>'Recherche'
            ],
                'empty_data'=>'',
                'required'=>false
                ])
            ->add('categories',EntityType::class,['attr'=>['class'=>''],
                'class'=>Category::class,
                'expanded'=>true,
                'multiple'=>true,
            ],
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'=>SearchData::class,
            'method'=>'GET',
            'csrf_protection'=>false
        ]);
    }
}
