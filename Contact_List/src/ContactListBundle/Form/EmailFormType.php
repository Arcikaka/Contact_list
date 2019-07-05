<?php

namespace ContactListBundle\Form;


use ContactListBundle\Entity\EmailPerson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('emailAddress', TextType::class, ['label' => 'email address', 'trim' => true])
            ->add('type', ChoiceType::class, ['label' => 'type', 'choices' => ['Home' => 'Home', 'Office' => 'Office']])
            ->add('save', SubmitType::class, ['label' => 'Save Email']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => EmailPerson::class]
        );
    }


}