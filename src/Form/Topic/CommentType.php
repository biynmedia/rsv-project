<?php


namespace App\Form\Topic;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => 'Contribution',
                'attr' => [
                    'placeholder' => 'Rédiger une contribution...'
                ]
            ])

            ->add('topicId', HiddenType::class)

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn-dark btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'rsv_comment';
    }

}