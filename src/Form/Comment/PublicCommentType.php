<?php


namespace App\Form\Comment;


use App\Comment\CommentRequest;
use App\Entity\BibleBook;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicCommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('book', EntityType::class, [
                'class' => BibleBook::class,
                'choice_label' => 'longName',
                'label' => false,
                'placeholder' => "Choisissez un Livre"
            ])

            ->add('chapter', ChoiceType::class, [
                'label' => false,
                'placeholder' => "Choisissez un Chapitre"
            ])

            ->add('verse', ChoiceType::class, [
                'label' => false,
                'placeholder' => "Choisissez un Verset"
            ])

            ->add('content', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Donner mon point de vue'
                ]
            ])

            ->add('topicId', HiddenType::class)
            ->add('verseText', HiddenType::class)

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
        return 'rsv_public_comment';
    }

}