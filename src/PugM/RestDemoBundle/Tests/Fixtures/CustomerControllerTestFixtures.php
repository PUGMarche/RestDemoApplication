<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ftassi
 * Date: 22/05/13
 * Time: 20:13
 * To change this template use File | Settings | File Templates.
 */

namespace PugM\RestDemoBundle\Tests\Fixtures;


use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PugM\RestDemoBundle\Entity\Customer;
use PugM\RestDemoBundle\Entity\Invoice;

class CustomerControllerTestFixtures implements FixtureInterface{

    /**
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setName('foo customer name');
        $customer->setAddress('foo customer address');
        $customer->setLogo('logo.jpg');
        $customer->setEmail('foocustomer@example.org');

        $invoice1 = new Invoice();
        $invoice1->setDate(new \DateTime());

        $invoice2 = new Invoice();
        $invoice2->setDate(new \DateTime());

        $manager->persist($customer);
        $manager->persist($invoice1);
        $manager->persist($invoice2);

        $manager->flush();
    }
}