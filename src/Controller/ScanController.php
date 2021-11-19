<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\ScanRepository;
use App\Repository\MangaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ScanController extends AbstractController
{

    #[Route('/scan/liste/{id}', name: 'public_scan_liste')]
    public function liste(int $id,MangaRepository $mangaRepository, Request $request, EntityManagerInterface $em): Response
    {
        $manga = $mangaRepository->find($id);

        if(!$manga)
        {
            return $this->redirectToRoute("home");
        }

        $scans = $manga->getScans();
        return $this->render('scan/liste.html.twig', [
            'scans' => $scans

        ]);
    }

    #[Route('/scan/detail/{id}', name: 'public_scan_detail')]
    public function detail(int $id,ScanRepository $scanRepository, Request $request, EntityManagerInterface $em): Response
    {
        $scan = $scanRepository->find($id);

        if(!$scan)
        {
            return $this->redirectToRoute("home");
        }

        return $this->render('scan/detail.html.twig', [
            'scan' => $scan

        ]);
    }
}
