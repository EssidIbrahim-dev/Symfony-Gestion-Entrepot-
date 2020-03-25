<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Achat;
use BackendBundle\Entity\ProdAchat;
use BackendBundle\Entity\Product;
use BackendBundle\Form\ProdAchatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AchatController extends Controller
{
    public function indexAction(){
        $user=$this->getUser();
        $achat=$this->getDoctrine()->getRepository(Achat::class)->findOneBy(array('clientAddress'=>$user->getUsername(),'etat'=>0));
        if(!$achat){
          $achat=new Achat();
          $achat->setDate( new \DateTime('now') );
          $achat->setClientAddress($user->getUsername());
          $achat->setClientName($user->getUsername());
          $achat->setClientType("client");
          $achat->setEtat(0);
          $achat->setQuantite(0);
            $em= $this->getDoctrine()->getManager();
            $em->persist($achat);
            $em->flush();
        }
        $products=$this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('@Backend/Achat/index.html.twig',array('products'=>$products,'user'=>$user,'achat'=>$achat));


    }
    public function readAction(){
        $achats=$this->getDoctrine()->getRepository(Achat::class)->findBy(array('etat'=>1));
        return $this->render('@Backend/Achat/read.html.twig',array('achats'=>$achats));


    }
    public function detailsProduitAction($id){
        $product=$this->getDoctrine()->getRepository(Product::class)->find($id);
        return $this->render('@Backend/Achat/show.html.twig',array('product'=>$product));


    }
    public function addAchatAction($id){
        $em= $this->getDoctrine()->getManager();
        $product=$this->getDoctrine()->getRepository(Product::class)->find($id);
        $user=$this->getUser();
        $achat=$this->getDoctrine()->getRepository(Achat::class)->findOneBy(array('clientAddress'=>$user->getUsername(),'etat'=>0));
        $prodachat=$this->getDoctrine()->getRepository(ProdAchat::class)->findOneBy(array('product'=>$product,'achat'=>$achat));
        if($prodachat){
            $achat->setQuantite($achat->getQuantite()+1);
            $prodachat->setQte($prodachat->getQte()+1);
            $em->persist($achat);
            $em->persist($prodachat);
            $em->flush();

        }
        else{
            $prodachat=new ProdAchat();
            $prodachat->setProduct($product);
            $prodachat->setAchat($achat);
            $prodachat->setQte(1);
            $achat->setQuantite($achat->getQuantite()+1);
            $em->persist($achat);
            $em->persist($prodachat);
            $em->flush();
        }

        return $this->redirectToRoute("index_achat");



    }
    public function panierAction(){
        $user=$this->getUser();
        $achat=$this->getDoctrine()->getRepository(Achat::class)->findOneBy(array('clientAddress'=>$user->getUsername(),'etat'=>0));
        $prodachats=$this->getDoctrine()->getRepository(ProdAchat::class)->findBy(array('achat'=>$achat));
        return $this->render('@Backend/Achat/panier.html.twig',array('prodachats'=>$prodachats));



    }
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $prodachat=$em->getRepository(ProdAchat::class)->find($id);

        $em->remove($prodachat);
        $em->flush();
        return $this->redirectToRoute("panier_achat");
    }
    public function editAction($id,Request $request){
        $entityManager = $this->getDoctrine()->getManager();
        $prodachat = $entityManager->getRepository(ProdAchat::class)->find($id);
        $form=$this->createForm(ProdAchatType::class,$prodachat)->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($prodachat);
            $em->flush();
            return $this->redirectToRoute("panier_achat");
        }
        return $this->render("@Backend/Achat/edit.html.twig",array(
            "form" =>$form->createView(),
        ));
    }
    public function confirmAction(){
        $user=$this->getUser();
        $achat=$this->getDoctrine()->getRepository(Achat::class)->findOneBy(array('clientAddress'=>$user->getUsername(),'etat'=>0));
        $achat->setEtat(1);
        $em=$this->getDoctrine()->getManager();
        $em->persist($achat);
        $em->flush();
        return $this->redirectToRoute("index_achat");
    }
    public function commandesAction(){
        $user=$this->getUser();
        $achats=$this->getDoctrine()->getRepository(Achat::class)->findBy(array('clientAddress'=>$user->getUsername(),'etat'=>1));
        $commandes=array();
        foreach($achats as $achat){
            $prodachats=$this->getDoctrine()->getRepository(ProdAchat::class)->findBy(array('achat'=>$achat));
            array_push($commandes,$prodachats);

        }
        return $this->render("@Backend/Achat/commandes.html.twig",array(
            'commandes'=>$commandes,

        ));

    }
}
