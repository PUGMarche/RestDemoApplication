<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ftassi
 * Date: 22/05/13
 * Time: 19:09
 * To change this template use File | Settings | File Templates.
 */

namespace PugM\RestDemoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\View;

class CustomerController extends Controller
{
    /**
     * @View()
     * @param $id
     * @return object ()
     */
    public function getCustomerAction($id)
    {
        $customer = $this->getDoctrine()->getRepository('PugMRestDemoBundle:Customer')->find($id);
        return $customer;
    }

    /**
     * @return mixed
     */
    public function postCustomerAction()
    {
        $customerData = $this->getRequest()->getContent();
        $customer = $this->get('serializer')->deserialize($customerData, 'PugM\RestDemoBundle\Entity\Customer', 'json');

        $this->getDoctrine()->getManager()->persist($customer);
        $this->getDoctrine()->getManager()->flush();

        $view = \FOS\RestBundle\View\View::create(
            $customer,
            201,
            array('location' => $this->generateUrl('get_customer', array('id' => $customer->getId())))
        );

        return $view;
    }

    /**
     * @param $id
     * @return array
     * @View(statusCode=204)
     */
    public function deleteCustomerAction($id)
    {
        $customer = $this->getDoctrine()->getRepository('PugMRestDemoBundle:Customer')->find($id);
        $this->getDoctrine()->getManager()->remove($customer);
        $this->getDoctrine()->getManager()->flush();


        return array();
    }
}