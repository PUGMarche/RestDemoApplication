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
}