<?php


namespace App\Form\Topic;


use App\Entity\Category;
use App\Topic\TopicRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, [
                'label' => 'Titre du Sujet ( 180 Caractères ) :',
                'attr' => [
                    'placeholder' => 'Titre.'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Choisissez une Catégorie :'
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Accroche ( 255 Caractères ) :',
                'required' => false
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Description :',
                'required' => false
            ])
            ->add('image', FileType::class, [
                'label' => 'Image d\'illustration :',
                'required' => false,
                'attr' => [
                    'class' => 'dropify',
                    'data-default-file' => $options['image_url']
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer le sujet',
                'attr' => [
                    'class' => 'btn-dark btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TopicRequest::class,
            'image_url' => null,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'rsv_topic';
    }

}