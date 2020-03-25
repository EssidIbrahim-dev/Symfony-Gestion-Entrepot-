<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 21/03/2020
 * Time: 00:11
 */

namespace BackendBundle\Controller;
use BackendBundle\Entity\MatrielMag;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
class MatrielMagController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();

        $matriels = $em->getRepository('BackendBundle:MatrielMag')->findAll();

        return $this->render('@Backend/matriel/index.html.twig', array(
            'matriels' => $matriels,
        ));

    }
    public function addAction(Request $request)
    {
        $matriel = new MatrielMag();
        $form = $this->createForm('BackendBundle\Form\MatrielMagType', $matriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $matriel->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $matriel->setPhoto($filename);
            $em->persist($matriel);
            $em->flush();
            return $this->redirectToRoute('matriel_show', array('id' => $matriel->getIDM()));
        }

        return $this->render('@Backend/matriel/new.html.twig', array(
            'matriel' => $matriel,
            'form' => $form->createView(),
        ));
    }
    /**
     * Finds and displays a MatrielMag entity.
     *
     */
    public function showAction(MatrielMag $matriel)
    {
        $deleteForm = $this->createDeleteForm($matriel);

        return $this->render('@Backend/matriel/show.html.twig', array(
            'matriel' => $matriel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MatrielMag entity.
     *
     */
    public function editAction(Request $request, MatrielMag $matriel)
    {
        $deleteForm = $this->createDeleteForm($matriel);
        $editForm = $this->createForm('BackendBundle\Form\MatrielMagType', $matriel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $file = $matriel->getPhoto();
            $filename= md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('photos_directory'), $filename);
            $matriel->setPhoto($filename);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('matriel_edit', array('id' => $matriel->getIDM()));
        }

        return $this->render('@Backend/matriel/edit.html.twig', array(
            'fournisseur' => $matriel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a matrielMag entity.
     *
     */
    public function deleteAction(Request $request, MatrielMag $matriel)
    {
        $form = $this->createDeleteForm($matriel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($matriel);
            $em->flush();
        }

        return $this->redirectToRoute('matriel_index');
    }

    /**
     * Creates a form to delete a matriel entity.
     *
     * @param MatrielMag $matriel The matriel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MatrielMag $matriel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matriel_delete', array('id' => $matriel->getIDM())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $materiels =  $em->getRepository('BackendBundle:MatrielMag')->findEntitiesByString($requestString);
        if(!$materiels) {
            $result['materiels']['error'] = "material Not found :( ";
        } else {
            $result['materiels'] = $this->getRealEntities($materiels);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($materiels){
        foreach ($materiels as $materiels){
            $realEntities[$materiels->getIDM()] = [$materiels->getPhoto(),$materiels->getType()];
        }
        return $realEntities;
    }
}