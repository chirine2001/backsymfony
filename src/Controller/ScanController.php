<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ScanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScanController extends AbstractController
{
     /**
     * @Route("/scan/detail/{id}", name="public_scan_detail", methods={"GET"})
     */
    public function detail(int $id,ScanRepository $scanRepository, Request $request, EntityManagerInterface $em): Response
    {
        $scan = $scanRepository->find($id);
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $commentaire->setImage($scan);
            $commentaire->setAuteur($this->getUser());

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('public_scan_detail', ['id' => $id]);
        }

        return $this->render('scan/detail.html.twig', [
            'scan' => $scan,
            'form' => $form->createView()
        ]);
    }
}
