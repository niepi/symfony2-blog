<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use FOS\UserBundle\Model\UserManagerInterface;
class UsersController extends Controller
{

    /**
     * @Route("/", name="_users_index")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('_users_list'));
    }

    /**
     * @Route("/list", name="_users_list")
     * @Template()
     */
    public function listAction()
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $users = $userManager->findUsers();

        return array('users' => $users);
    }

}