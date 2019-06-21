<?php

namespace ContactListBundle\Form;


use ContactListBundle\Entity\Phone;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
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
            ->add('type', TextType::class, ['label' => 'type', 'trim' => true])
            ->add('save', SubmitType::class, ['label' => 'Create Phone']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Phone::class]
        );
    }

}