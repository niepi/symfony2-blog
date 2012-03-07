<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminController extends Controller
{
    /**
     * @Route("/", name="_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('_admin_dashboard'));
    }

    /**
     * @Route("/dashboard", name="_admin_dashboard")
     * @Template()
     */
    public function dashboardAction()
    {
        return array();
    }

}
