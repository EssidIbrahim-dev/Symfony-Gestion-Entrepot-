<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Besoin;
use BackendBundle\Entity\Entrepot;
use BackendBundle\Entity\Prodbesoin;
use BackendBundle\Entity\Product;
use BackendBundle\Form\BesoinType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;



class BesoinController extends Controller
{

    public function createOneAction(Request $request){
        $besoin=new Besoin();
        $form=$this->createForm(BesoinType::class,$besoin);
        $form->handleRequest($request);
        $entrepots=$this->getDoctrine()->getRepository(Entrepot::class)->findAll();
        /*  if ($form->isSubmitted()){
              $echeance=$request->request->get("echeance");

           //   $time = date('H:i:s \O\n d/m/Y');
              $besoin->setDate( new \DateTime('now'));
              $besoin->setStatut("Non traiter");
              $besoin->setEcheance($echeance);
              $reference="Ref0001";
              $besoin->setReference($reference);
              $em= $this->getDoctrine()->getManager();
              $em->persist($besoin);
              $em->flush();
              return $this->redirectToRoute("backend_besoin_createOne");
          }*/
        return $this->render('@Backend/Besoin/createOne.html.twig',array("entrepots"=>$entrepots));
    }
    public function addBesoinAction(Request $request){
        $echeance=$request->request->get("echeance");
        $id_entrepot=$request->request->get("entrepot");
        $entrepot=$this->getDoctrine()->getRepository(Entrepot::class)->find((int)$id_entrepot);
        $besoin=new Besoin();
        $besoin->setDate( new \DateTime('now'));
        $besoin->setStatut("Non traiter");
        $besoin->setEcheance($echeance);
        $besoin->setEntrepot($entrepot);
        $reference="Ref0001";
        $besoin->setReference($reference);
        $em= $this->getDoctrine()->getManager();
        $em->persist($besoin);
        $em->flush();
        return $this->redirect($this->generateUrl('step2',array('id' => $besoin->getId())));

    }
    public function createTwoAction($id){
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find((int)$id);
        $prodbesoins= $this->getDoctrine()->getRepository(Prodbesoin::class)
            ->findBy(array('besoin'=>$besoin));
        $products=$this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('@Backend/Besoin/createTwo.html.twig',array('id'=>$id,'products'=>$products,'prodbesoins'=>$prodbesoins));


    }
    public function addBesoinProductAction(Request $request){
        $prodbesoin=new Prodbesoin();
        $id_besoin=$request->request->get("besoin");
        $id_prod=$request->request->get("product");
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find((int)$id_besoin);
        $product=$this->getDoctrine()->getRepository(Product::class)->find((int)$id_prod);
        $prodbesoin1=$this->getDoctrine()->getRepository(Prodbesoin::class)->findOneBy(array('besoin'=>$besoin,'product'=>$product));
        $qte=$request->request->get("qte");
        $unite=$request->request->get("unite");
        if($prodbesoin1){
            $quantite=(float)$qte+$prodbesoin1->getQte();
            $prodbesoin1->setQte($quantite);
            $prodbesoin1->setUnite($unite);
            $em= $this->getDoctrine()->getManager();
            $em->persist($prodbesoin1);
            $em->flush();
        }
        else{
            $prodbesoin->setBesoin($besoin);
            $prodbesoin->setProduct($product);
            $prodbesoin->setQte((float)$qte);
            $prodbesoin->setUnite($unite);
            $em= $this->getDoctrine()->getManager();
            $em->persist($prodbesoin);
            $em->flush();
        }


        $prodbesoins= $this->getDoctrine()->getRepository(Prodbesoin::class)
            ->findBy(array('besoin'=>$besoin));
        $products=$this->getDoctrine()->getRepository(Product::class)->findAll();
        return $this->render('@Backend/Besoin/createTwo.html.twig',array('id'=>$id_besoin,'products'=>$products,'prodbesoins'=>$prodbesoins));
    }
    public function deleteProdBesoinAction($id,$idb){
        $em = $this->getDoctrine()->getManager();
        $prodbesoin=$em->getRepository(Prodbesoin::class)->find($id);

        $em->remove($prodbesoin);
        $em->flush();

        return $this->redirect($this->generateUrl('step2',array('id' => $idb)));


    }
    public function editProdBesoinAction($id,$idb){
        $prodbesoin=$this->getDoctrine()->getRepository(Prodbesoin::class)->findOneBy(array('id'=>$id));
        return $this->render('@Backend/Besoin/editProdBesoin.html.twig',array('idb'=>$idb,'prodbesoin'=>$prodbesoin));

    }
    public function editProductBesoinAction(Request $request){
        $em=$this->getDoctrine()->getManager();
        $prodbesoin=$this->getDoctrine()->getRepository(Prodbesoin::class)->find((int)$request->request->get('prodbesoin'));
        $prodbesoin->setQte((float)$request->request->get('qte'));
        $prodbesoin->setUnite($request->request->get('unite'));
        $em->flush();
        return $this->redirect($this->generateUrl('step2',array('id' => $request->request->get('besoin'))));



    }
    public function indexAction(){
        $besoins=$this->getDoctrine()->getRepository(Besoin::class)->findAll();
        return $this->render('@Backend/Besoin/index.html.twig',array('besoins'=>$besoins));

    }
    public function showAction($id){
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find($id);
        $prodbesoins= $this->getDoctrine()->getRepository(Prodbesoin::class)
            ->findBy(array('besoin'=>$besoin));
        return $this->render('@Backend/Besoin/show.html.twig',array('besoin'=>$besoin,'prodbesoins'=>$prodbesoins));


    }
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find($id);
        $prodbesoins= $this->getDoctrine()->getRepository(Prodbesoin::class)
            ->findBy(array('besoin'=>$besoin));
        foreach ($prodbesoins as $p ) {
            $em->remove($p);
            $em->flush();

        }
        $em->remove($besoin);
        $em->flush();
        return $this->redirectToRoute('index_besoins');

    }
    public function editAction($id){
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find($id);

        $prodbesoins= $this->getDoctrine()->getRepository(Prodbesoin::class)
            ->findBy(array('besoin'=>$besoin));
        return $this->render('@Backend/Besoin/edit.html.twig',array('prodbesoins'=>$prodbesoins,'id'=>$id,'besoin'=>$besoin));


    }
    public function edittraitAction(Request $request){
        $id=(int)$request->request->get('besoin');
        $em = $this->getDoctrine()->getManager();
        $echeance=$request->request->get("e");
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find($id);
        $besoin->setEcheance($echeance);
        $em->persist($besoin);
        $em->flush();
        return new Response("id ".$id);
        // return $this->redirectToRoute('index_besoins');


        //  return $this->redirect($this->generateUrl('edit_besoin',array('id' => $request->request->get('besoin'))));

    }
    public function pdfAction($id){
        $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find($id);

        $prodbesoins= $this->getDoctrine()->getRepository(Prodbesoin::class)
            ->findBy(array('besoin'=>$besoin));
        $html = $this->renderView('@Backend/Besoin/pdf.html.twig', array(
            'besoin'  => $besoin,
            'prodbesoins' => $prodbesoins,
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

}
