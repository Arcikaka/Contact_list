<?php

namespace ContactListBundle\Form;


use ContactListBundle\Entity\Address;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('city', TextType::class, ['label' => 'city', 'trim' => true])
            ->add('zipCode', TextType::class, ['label' => 'zip code', 'trim' => true])
            ->add('street', TextType::class, ['label' => 'street','trim' => true])
            ->add('houseNumber', IntegerType::class, ['label' => 'house number'])
            ->add('flat', TextType::class, ['label' => 'flat', 'trim' => true])
            ->add('save', SubmitType::class, ['label' => 'Create Address']);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            ['data_class' => Address::class]
        );
    }

}