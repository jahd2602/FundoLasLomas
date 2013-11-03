<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('UpaoFundoBundle:Default:index.html.twig', array('name' => $name));
    }
}
