<?php

use Address;

/**
 * A Person object
 *
 * NOTE: The information about the home address is stored in a database table
 * However, when that information is requested it is returned as an Address object
 */

class Person
{
    protected $firstname;
    protected $lastname;

    /** @var Address */
    $protected $homeaddress;

    /** @Column(type="string") */
    private $address1;


    public function setHomeAddress(Address $address) 
    {
        // Set all of the local properties
        $this->address1 = $address->getAddress1();

        $this->homeaddress = $address;
    }

    public function getHomeAddress()
    {
        if ($this->homeaddress == null) {
            $address = new Address();
            $address->setAddress1();
            // ...

            $this->setHomeAddress($address);
        }

        return $this->homeaddress;
    }
}
