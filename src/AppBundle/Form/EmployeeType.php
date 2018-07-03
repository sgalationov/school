<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, ['label' => 'Имя: '])
            ->add('surname', null, ['label' => 'Фамилия: '])
            ->add('position', null, ['label' => 'Должность: '])
            ->add('email', null, ['label' => 'Email: '])
            ->add('password', null, ['label' => 'Пароль: '])
            ->add('subjects', null, ['label' => 'Дисциплина: '])
            ->add('university', null, ['label' => 'Университет: '])
            ->add('role')
            ->add('salt');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Employee'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_employee';
    }


}
