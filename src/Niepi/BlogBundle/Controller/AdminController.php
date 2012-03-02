<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Niepi\BlogBundle\Entity\Post;

class AdminController extends Controller
{
    /**
     * @Route("/", name="_admin_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/post-list", name="_admin_postlist")
     * @Template()
     */
    public function postlistAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('BlogBundle:Post');


        $query = $repository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $posts = $query->getResult();
    
        return array('posts' => $posts);
    }

    /**
     * @Route("/post-create", name="_admin_postcreate")
     * @Template()
     */
    public function postcreateAction(Request $request)
    {

		$post = new Post();
        $form = $this->createFormBuilder($post)
            ->add('title', 'text')
            ->add('content', 'textarea')
            ->getForm();
	
	    if ($request->getMethod() == 'POST') {
	        $form->bindRequest($request);

	        if ($form->isValid()) {				

				$post = $form->getData();
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist($post);
				$em->flush();

	            return $this->redirect($this->generateUrl('_admin_postlist'));
	        }
	    }

        return array(
            'form' => $form->createView()
        );
    }

}
