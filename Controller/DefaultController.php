<?php

namespace HoPeter1018\DoctrineDynamicColumnBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HoPeter1018DoctrineDynamicColumnBundle:Default:index.html.twig');
    }
}
