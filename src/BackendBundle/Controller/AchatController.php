<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Achat;
use BackendBundle\Entity\ProdAchat;
use BackendBundle\Entity\Product;
use BackendBundle\Form\ProdAchatType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;


class AchatController extends Controller
{
    public function indexAction(Request $request){
        $user=$this->getUser();
        $achat=$this->getDoctrine()->getRepository(Achat::class)->findOneBy(array('clientAddress'=>$user->getUsername(),'etat'=>0));
        if(!$achat){
          $achat=new Achat();
          $achat->setDate( new \DateTime('now') );
          $achat->setClientAddress($user->getUsername());
          $achat->setClientName($user->getUsername());
            $achats=$this->getDoctrine()->getRepository(Achat::class)->findAll();
            $longeur=count($achats);
            $ref="Reff".$user->getUsername();
            $ch="";
            for($i=0;$i<10-$longeur;$i++){
                $ch.='0';
            }
            $ref.=$ch.$longeur;
          $achat->setClientType($ref);
          $achat->setEtat(0);
          $achat->setQuantite(0);
            $em= $this->getDoctrine()->getManager();
            $em->persist($achat);
            $em->flush();
        }
        $products=$this->getDoctrine()->getRepository(Product::class)->findAll();

        if($request->isMethod('POST')){
            $name=$request->request->get('myInput');
            $products=$this->getDoctrine()->getRepository(Product::class)->findBy(array('productName'=>$name));

        }
        return $this->render('@Backend/Achat/index.html.twig',array('products'=>$products,'user'=>$user,'achat'=>$achat));


    }
    public function generateReference($user){
        $achats=$this->getDoctrine()->getRepository(Achat::class)->findAll();
        $longeur=count($achats);
        $ref="Reff".$user->getUsername();
        for($i=0;$i<10-$longeur;$i++){
            $ref=$ref."0";
        }
        $ref=$ref.$longeur;
        echo $ref;
    }

    public function readAction(){
        $achats=$this->getDoctrine()->getRepository(Achat::class)->findBy(array('etat'=>1));
        return $this->render('@Backend/Achat/read.html.twig',array('achats'=>$achats));


    }
    public function pdfAction($id){
        $achat=$this->getDoctrine()->getRepository(Achat::class)->find($id);

        $prodachats= $this->getDoctrine()->getRepository(ProdAchat::class)
            ->findBy(array('achat'=>$achat));
        $html = $this->renderView('@Backend/Achat/pdf.html.twig', array(
            'a'  => $achat,
            'prodachats' => $prodachats,
        ));
        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html,array(
                'default-header'=>null,
                'encoding' => 'utf-8',
                'images' => true,
                'enable-javascript' => true,
                'margin-right'  => 7,
                'margin-left'  =>7,
            )),
            'file.pdf'
        );

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
        $message = \Swift_Message::newInstance()
            ->setSubject('Chaya3ni Newsletter')
            ->setFrom('themazewhm@gmail.com')
            ->setTo('brahimhm470@gmail.com')
            ->setBody(
              "Votre commande est confirmez sous la reference".$achat->getClientName()."<br> et selivré dans 4 jours ouvrables",
                'text/html'
            );
        $this->get('mailer')->send($message);

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
