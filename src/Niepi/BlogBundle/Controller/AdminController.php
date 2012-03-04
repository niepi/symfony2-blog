<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Niepi\BlogBundle\Entity\Post;
use Niepi\BlogBundle\Form\Post\CreateForm;

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
    public function postcreateAction(Request $request = null)
    {

		$post = new Post();

        $form = $this->createForm(new CreateForm(), $post);
	
	    if ($request->getMethod() == 'POST') {
	        $form->bindRequest($request);

	        if ($form->isValid()) {				

                $formData = $request->request->all();
                $id = $formData['post']['id'];

				if(empty($id)){

                    $post = $form->getData();
                    $post->setDateCreated(new \DateTime('now'));
                    $em = $this->getDoctrine()->getEntityManager();
                    $em->persist($post);
                    $em->flush();

                } else {

                    $em = $this->getDoctrine()->getEntityManager();
                    $post = $em->getRepository('BlogBundle:Post')->find($id);                    
                    $post->setTitle($formData['post']['title']);
                    $post->setContent($formData['post']['content']);
                    $em->flush();                    

                }

	            return $this->redirect($this->generateUrl('_admin_postlist'));
	        }

	    } elseif ($request->getMethod() == 'GET'){

            $id = $request->query->get('id');

            if(!empty($id)){
                $em = $this->getDoctrine()->getEntityManager();
                $post = $em->getRepository('BlogBundle:Post')->find($id);

                $form = $this->createForm(new CreateForm(), $post);
                            
            }

        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/post-delete", name="_admin_postdelete")
     * @Template()
     */
    public function postdeleteAction(Request $request = null)
    {
        if ($request->getMethod() == 'GET') {

            $id = $request->query->get('id');

            if(!empty($id)){
                $em = $this->getDoctrine()->getEntityManager();
                $post = $em->getRepository('BlogBundle:Post')->find($id);
                $em->remove($post);
                $em->flush();
                
            }
        
        }
        
        return $this->redirect($this->generateUrl('_admin_postlist'));

    }
}
