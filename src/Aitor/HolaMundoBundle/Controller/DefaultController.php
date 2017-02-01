<?php

namespace Aitor\HolaMundoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AitorHolaMundoBundle:Default:index.html.twig');
    }
}
