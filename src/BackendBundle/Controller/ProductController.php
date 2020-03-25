<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 21/03/2020
 * Time: 00:11
 */

namespace BackendBundle\Controller;

use BackendBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use BackendBundle\Form\ProductType;


class ProductController extends Controller
{
    public function addAction(Request $request)
    {

        $produit = new Product();
        $form = $this->createForm(ProductType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $produit->getPhoto();
            $filename = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $produit->setPhoto($filename);
            $em->persist($produit);
            $em->flush();

            $this->addFlash('info', 'Created Successfully !');
        }
        return $this->render('@Backend/Product/add.html.twig', array(
            "Form" => $form->createView()
        ));
    }

    public function listAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BackendBundle:Product')->findAll();
        return $this->render('@Backend/Product/list.html.twig', array(
            "posts" => $posts
        ));

    }

    public function showAction($id)
    {
        if(is_granted(ROLE_GESTIONNAIRE))
        {
        $em = $this->getDoctrine()->getManager();
        $p = $em->getRepository('BackendBundle:Product')->find($id);
        return $this->render('@Backend/Product/detailedpost.html.twig', array(
            'type' => $p->getProductType(),
            'name' => $p->getProductName(),
            'photo' => $p->getPhoto(),
            'Price' => $p->getPriceTTC(),
            'posts' => $p,
            'comments' => $p,
            'id' => $p->getId()
        ));}
        else{
            return $this->render('default/index.html.twig');
        }
    }

    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $posts = $em->getRepository('BackendBundle:Product')->findPostById(1);

        if (!$posts) {
            $result['posts']['error'] = "Product Not found :( ";
        } else {

            $result['posts'] = $this->getRealEntities($posts);
        }
        return new Response(json_encode($result));
    }

    public function getRealEntities($posts)
    {
        foreach ($posts as $posts) {
            $realEntities[$posts->getId()] = [$posts->getPhoto(), $posts->getProductName()];
        }
    }
}
