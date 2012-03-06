<?php

namespace Niepi\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Niepi\BlogBundle\Entity\Comment;
use Niepi\BlogBundle\Form\CommentCreateForm;

class BlogController extends Controller
{
    /**
     * @Route("/", name="_blog")
     * @Template()
     */
    public function indexAction()
    {
        $repository = $this->getDoctrine()
            ->getRepository('BlogBundle:Post');


        $query = $repository->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $posts = $query->getResult();
    
        $comment = new Comment();
        $form = $this->createForm(new CommentCreateForm(), $comment);
        
        return array('posts' => $posts,
                     'form' => $form->createView());
    }

    /**
     * @Route("/post", name="_blog_detail")
     * @Template()
     */

    public function detailAction(Request $request)
    {

        if ($request->getMethod() == 'GET'){

            $id = $request->query->get('id');

            if(!empty($id)){
                $repository = $this->getDoctrine()
                    ->getRepository('BlogBundle:Post');

                $em = $this->getDoctrine()->getEntityManager();
                $post = $em->getRepository('BlogBundle:Post')->find($id);  

                $comments = $post->getComments();


                $comment = new Comment();
                $comment->setPost($post);
                $form = $this->createForm(new CommentCreateForm(), $comment);

                return array('post' => $post,
                             'comments' =>$comments,
                             'form' => $form->createView());
            }
        }
        else{
            return $this->redirect($this->generateUrl('_blog'));
        }
    }

    /**
     * @Route("/createComment", name="_blog_createComment")
     * @Template()
     */
    public function createCommentAction(Request $request)
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
}
