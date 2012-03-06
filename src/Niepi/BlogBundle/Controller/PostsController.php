<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Niepi\BlogBundle\Entity\Post;
use Niepi\BlogBundle\Form\PostCreateForm;

class PostsController extends Controller
{
    /**
     * @Route("/", name="_posts_index")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('_posts_list'));
    }

    /**
     * @Route("/list", name="_posts_list")
     * @Template()
     */
    public function listAction()
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
     * @Route("/create", name="_posts_create")
     * @Template()
     */
    public function createAction(Request $request = null)
    {

		$post = new Post();

        $form = $this->createForm(new PostCreateForm(), $post);
	
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

	            return $this->redirect($this->generateUrl('_posts_list'));
	        }

	    } elseif ($request->getMethod() == 'GET'){

            $id = $request->query->get('id');

            if(!empty($id)){
                $em = $this->getDoctrine()->getEntityManager();
                $post = $em->getRepository('BlogBundle:Post')->find($id);

                $form = $this->createForm(new PostCreateForm(), $post);
                            
            }

        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/delete", name="_posts_delete")
     * @Template()
     */
    public function deleteAction(Request $request)
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
        
        return $this->redirect($this->generateUrl('_posts_list'));

    }
}
