<?php


namespace App\Form\Answer;


use App\Answer\AnswerRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('summary', TextareaType::class, [
                'label' => 'Réponse courte.',
                'required' => false
            ])

            ->add('content', TextareaType::class, [
                'label' => 'Réponse complète.',
                'required' => false
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn-dark btn-block'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           'data_class' => AnswerRequest::class
        ]);
    }

    public function getBlockPrefix()
    {
        return 'rsv_answer';
    }

}