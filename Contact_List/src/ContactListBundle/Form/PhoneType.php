<?php

namespace ContactListBundle\Form;


use ContactListBundle\Entity\Phone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('number', IntegerType::class, ['label' => 'number', 'trim' => true])
            ->add('type', ChoiceType::class, ['label' => 'type', 'choices' => ['Home' => 'Home', 'Office' => 'Office']])
            ->add('save', SubmitType::class, ['label' => 'Save Phone']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Phone::class]
        );
    }

}