<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Niepi\BlogBundle\Entity\Post;
use Niepi\BlogBundle\Entity\Comment;
use Niepi\BlogBundle\Form\CommentCreateForm;

class CommentsController extends Controller
{
    
    /**
     * @Route("/", name="_comments_index")
     * @Template()
     */
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('_posts_list'));
    }

    /**
     * @Route("/list", name="_comments_list")
     * @Template()
     */
    public function listAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('BlogBundle:Comment');


        $query = $repository->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery();

        $comments = $query->getResult();
    
        return array('comments' => $comments);
    }

    /**
     * @Route("/create", name="_comments_create")
     * @Template()
     */
    public function createAction(Request $request)
    {

        $form = $this->createForm(new CommentCreateForm());
    
        if ($request->getMethod() == 'POST') {

            $form->bindRequest($request);

            // if ($form->isValid()) {             

                $comment = new Comment();
                $comment = $form->getData();
                $comment->setDateCreated(new \DateTime('now'));

                $formData = $request->request->all();
                $id = $formData['commentCreateForm']['post']['id'];

                $em = $this->getDoctrine()->getEntityManager();
                $post = $em->getRepository('BlogBundle:Post')->find($id);  

                $comment->setPost($post);

                $em->persist($comment);
                $em->flush();

                return $this->redirect($this->generateUrl('_blog_detail',array('id' => $id)));
        // }

        }

    }

    /**
     * @Route("/delete", name="_comments_delete")
     * @Template()
     */
    public function deleteAction(Request $request = null)
    {
        if ($request->getMethod() == 'GET') {

            $id = $request->query->get('id');

            if(!empty($id)){
                $em = $this->getDoctrine()->getEntityManager();
                $comment = $em->getRepository('BlogBundle:Comment')->find($id);
                $em->remove($comment);
                $em->flush();
                
            }
        
        }
        
        return $this->redirect($this->generateUrl('_comments_list'));

    }
}
