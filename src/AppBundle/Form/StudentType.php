<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Имя: '])
            ->add('surname', null, ['label' => 'Фамилия: '])
            ->add('age', null, ['label' => 'Возраст: '])
            ->add('email', null, ['label' => 'Email: '])
            ->add('password', null, ['label' => 'Пароль: '])
            ->add('role')
            ->add('salt')
            ->add('university', null, ['label' => 'Университет: ']);
        $builder->setRequired(false);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Student',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_student';
    }


}
