<?php

namespace BackendBundle\Controller;

use BackendBundle\Entity\Besoin;
use BackendBundle\Entity\Besoincmd;
use BackendBundle\Entity\Commande;
use BackendBundle\Entity\Fournisseur;
use BackendBundle\Entity\Prodbesoin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommandeController extends Controller
{
    public function addCmdAction(){
        $besoins=$this->getDoctrine()->getRepository(Besoin::class)->findBy(array('statut'=>"Non traiter"));
        $fournisseurs=$this->getDoctrine()->getRepository(Fournisseur::class)->findAll();
        return $this->render('@Backend/Commande/addCmd.html.twig',array('besoins'=>$besoins,"fournisseurs"=>$fournisseurs));


    }
    public function addCmdTraitAction(Request $request){
        $besoins=$this->getDoctrine()->getRepository(Besoin::class)->findBy(array('statut'=>"En cours"));
        $idf=$request->request->get("f");
        $fournisseur=$this->getDoctrine()->getRepository(Fournisseur::class)->find((int)$idf);
        $commande=new Commande();
        $commande->setFournisseur($fournisseur->getFirstname());
        $commande->setDate(new \DateTime('now'));
        $commande->setStatus("En cours");
        $ref="refCMD00001";
        $commande->setReference($ref);
        $em= $this->getDoctrine()->getManager();
        $em->persist($commande);
        $em->flush();
        $ch=" ";
        foreach ($besoins as $besoin){
            $id=$request->request->get($besoin->getId());
            $besoin=$this->getDoctrine()->getRepository(Besoin::class)->find((int)$id);
            if($besoin){
                $besoin->setStatut("En cours");
                $besoincmd=new Besoincmd();
                $besoincmd->setBesoin($besoin);
                $besoincmd->setCommande($commande);
                $em->persist($besoincmd);
                $em->flush();
            }



        }





        return $this->redirectToRoute('index_cmd');
    }
    public function indexAction(){
        $commandes=$this->getDoctrine()->getRepository(Commande::class)->findAll();
        return $this->render('@Backend/Commande/index.html.twig',array('commandes'=>$commandes));


    }
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $commande=$this->getDoctrine()->getRepository(Commande::class)->find($id);
        $besoincmds= $this->getDoctrine()->getRepository(Besoincmd::class)
            ->findBy(array('commande'=>$commande));
        if($besoincmds){
            foreach ($besoincmds as $b ) {
                $em->remove($b);
                $em->flush();

            }
        }
        $em->remove($commande);
        $em->flush();
        return $this->redirectToRoute('index_cmd');

    }
    public function editAction($id,$f){
        $commande=$this->getDoctrine()->getRepository(Commande::class)->findOneBy(array('id'=>$id));
        $fournisseurs=$this->getDoctrine()->getRepository(Fournisseur::class)->findAll();

        $besoincmds= $this->getDoctrine()->getRepository(Besoincmd::class)
            ->findBy(array('commande'=>$commande));
        return $this->render('@Backend/Commande/edit.html.twig',array('commande'=>$commande,'id'=>$id,'besoincmds'=>$besoincmds,'fournisseurs'=>$fournisseurs,'f'=>$f));

    }
    public function editCmdAction(Request $request){
     $f=$request->request->get("f");
     $id=$request->request->get("cmd");
     $em=$this->getDoctrine()->getManager();
     $commande=$this->getDoctrine()->getRepository(Commande::class)->find((int)$id);
     if($commande){
         $commande->setFournisseur($f);
         $em->flush();
     }

       return $this->redirectToRoute('index_cmd');
    }
    public function deleteCmdBesoinAction($id,$f){
        $em = $this->getDoctrine()->getManager();
        $besoincmd=$em->getRepository(Besoincmd::class)->find($id);
        $idc=$besoincmd->getCommande()->getId();
        $em->remove($besoincmd);
        $em->flush();

        return $this->redirect($this->generateUrl('edit_cmd',array('id' => $idc,'f'=>$f)));


    }

}
