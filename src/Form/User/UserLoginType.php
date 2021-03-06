<?php


namespace App\Form\User;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserLoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Email.']
            ])
            ->add('password', PasswordType::class, [
                'label' => false,
                'attr'  => ['placeholder' => 'Mot de passe.']
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Connexion'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => null,
                'csrf_field_name' => '_login_csrf',
                'csrf_token_id'   => 'authenticate',
                'remember_me' => false,
                'translation_domain' => false,
            ]);
    }
    public function getBlockPrefix()
    {
        return 'security_login';
    }
}