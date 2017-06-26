<?php
/**
 * Created by PhpStorm.
 * User: Lew
 * Date: 16/06/2017
 * Time: 17:48
 */

namespace BM\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', TextType::class)
            ->add('username', TextType::class)
            ->add('plainPassword', PasswordType::class, array(
                'label' => 'pass',
            ))
            ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'bm_user_registration';
    }
}