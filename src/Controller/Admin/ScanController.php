<?php

namespace App\Controller\Admin;

use App\Entity\Scan;
use App\Form\ScanType;
use App\MesServices\ImageService;
use App\Repository\ScanRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/scan')]
class ScanController extends AbstractController
{
    #[Route('/', name: 'scan_index', methods: ['GET'])]
    public function index(ScanRepository $scanRepository): Response
    {
        return $this->render('admin/scan/index.html.twig', [
            'scans' => $scanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'scan_new', methods: ['GET', 'POST'])]
    public function new(Request $request,ImageService $imageService): Response
    {
        $scan = new Scan();
        $form = $this->createForm(ScanType::class, $scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image_upload')->getData();

            if($file)
            {
                $imageService->sauvegarderImage($scan,$file);
            }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($scan);
            $entityManager->flush();

            return $this->redirectToRoute('scan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/scan/new.html.twig', [
            'scan' => $scan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'scan_show', methods: ['GET'])]
    public function show(Scan $scan): Response
    {
        return $this->render('admin/scan/show.html.twig', [
            'scan' => $scan,
        ]);
    }

    #[Route('/{id}/edit', name: 'scan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scan $scan,ImageService $imageService): Response
    {
        $ancienneImage = $scan->getImage();
        $form = $this->createForm(ScanType::class, $scan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image_upload')->getData();

            if($file)
            {
                $imageService->sauvegarderImage($scan,$file);
            }
        
            if($ancienneImage)
            {
                $imageService->supprimerImage($ancienneImage);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('scan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/scan/edit.html.twig', [
            'scan' => $scan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'scan_delete', methods: ['POST'])]
    public function delete(Request $request, Scan $scan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($scan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('scan_index', [], Response::HTTP_SEE_OTHER);
    }
}
