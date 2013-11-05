<?php

namespace Upao\FundoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FundoController extends Controller
{
    public function indexAction()
    {
        return $this->render('UpaoFundoBundle:Fundo:index.html.twig');
    }

    public function regionAction()
    {
        return $this->render('UpaoFundoBundle:Fundo:region.html.twig');
    }
}
