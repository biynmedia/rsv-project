<?php


namespace App\Form\Topic;


use App\Entity\Category;
use App\Topic\PublicTopicRequest;
use App\Topic\TopicRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicPublicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('name', TextType::class, [
                'label' => 'Posez votre question ( 180 Caractères ) :',
                'attr' => [
                    'placeholder' => 'Question.'
                ]
            ])
            ->add('userFirstName', TextType::class, [
                'label' => 'Quel est votre prénom ? ( facultatif ) :',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre prénom.'
                ]
            ])
            ->add('userNotificationEmail', TextType::class, [
                'required' => false,
                'label' => 'Quel est votre email ? ( Servira uniquement pour vous prévenir ) :',
                'attr' => [
                    'placeholder' => 'Votre email.'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre ma question',
                'attr' => [
                    'class' => 'btn-dark btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicTopicRequest::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'rsv_public_topic';
    }

}