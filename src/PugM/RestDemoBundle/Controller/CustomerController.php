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
        return new Response();
    }
}