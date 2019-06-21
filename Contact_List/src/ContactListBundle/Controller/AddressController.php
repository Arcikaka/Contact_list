<?php

namespace ContactListBundle\Controller;

use ContactListBundle\Entity\Address;
use ContactListBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class AddressController extends Controller
{
    public function addAddressFormAction(){
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);

    }
    //TODO make new address, and action for saving new address
}
