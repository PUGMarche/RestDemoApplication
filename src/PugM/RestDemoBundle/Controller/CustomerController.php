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

class CustomerController extends Controller
{
    /**
     * @param $id
     * @return array
     */
    public function getCustomerAction($id)
    {
        $json = '{"id": 1, "name": "foo customer name", "address": "foo customer address", "email": "foocustomer@example.org", "logo": "logo.jpg"}';
        return new Response($json);
    }
}