<?php

namespace App\Controller\Admin;

use App\Entity\Manga;
use App\Form\MangaType;
use App\MesServices\ImageService;
use App\Repository\MangaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/manga')]
class MangaController extends AbstractController
{
    #[Route('/', name: 'manga_index', methods: ['GET'])]
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('admin/manga/index.html.twig', [
            'mangas' => $mangaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'manga_new', methods: ['GET', 'POST'])]
    public function new(Request $request,ImageService $imageService
    ): Response
    {
        $manga = new Manga();
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image_upload')->getData();

            if($file)
            {
                $imageService->sauvegarderImage($manga,$file);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($manga);
            $entityManager->flush();

            return $this->redirectToRoute('manga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/manga/new.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'manga_show', methods: ['GET'])]
    public function show(Manga $manga): Response
    {
        return $this->render('admin/manga/show.html.twig', [
            'manga' => $manga,
        ]);
    }

    #[Route('/{id}/edit', name: 'manga_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manga $manga,ImageService $imageService ): Response
    {
        $ancienneImage = $manga->getImage();
        $form = $this->createForm(MangaType::class, $manga);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('image_upload')->getData();

            if($file)
            {
                $imageService->sauvegarderImage($manga,$file);
            }
        
            if($ancienneImage)
            {
                $imageService->supprimerImage($ancienneImage);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manga_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/manga/edit.html.twig', [
            'manga' => $manga,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'manga_delete', methods: ['POST'])]
    public function delete(Request $request, Manga $manga): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manga->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($manga);
            $entityManager->flush();
        }

        return $this->redirectToRoute('manga_index', [], Response::HTTP_SEE_OTHER);
    }
}
