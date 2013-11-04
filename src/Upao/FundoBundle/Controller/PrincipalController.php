<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PrincipalController extends Controller
{
    public function indexAction()
    {


        return $this->render('UpaoFundoBundle:Principal:index.html.twig');
    }
}
