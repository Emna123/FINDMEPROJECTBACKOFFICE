<?php

namespace App\Form;

use App\Entity\Administration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyaccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder

            ->add('username',null, ['label'=>'* Username : '])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Confirmation de Mot de Passe incorrect.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'first_options'  => ['label' => '* Password :'],
                'second_options' => ['label' => '* Confirm password :'],
            ])
            ->add('nom',null, ['label'=>'* Last name : '])
            ->add('prenom',null, ['label'=>'* First name : '])
            ->add('tel',TelType::class,['label'=>'* Phone : '])
            ->add('adresse',TextareaType::class, ['label'=>'* Address : '])
            ->add('mail',EmailType::class,['label'=>'* E-mail : '])
            ->add('imageFile',FileType::class,['label'=>'* Picture : ','required'=>true])

        ;
    }




    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Administration::class,
        ]);
    }
}
