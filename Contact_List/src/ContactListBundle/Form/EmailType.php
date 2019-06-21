<?php

namespace ContactListBundle\Form;


use ContactListBundle\Entity\Email;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('emailAddress', TextType::class, ['label' => 'email address', 'trim' => true])
            ->add('type', TextType::class, ['label' => 'type', 'trim' => true])
            ->add('save', SubmitType::class, ['label' => 'Create Email']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Email::class]
        );
    }


}