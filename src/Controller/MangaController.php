<?php 

namespace App\Controller;


use App\Repository\MangaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MangaController extends AbstractController
{
     /**
     * @Route("/mangas", name="public_manga_liste", methods={"GET"})
     */
    public function index(MangaRepository $mangaRepository): Response
    {
        return $this->render('manga_public/liste.html.twig', [
            'manga' => $mangaRepository->findAll(),
        ]);
    }

     /**
     * @Route("/manga/detail/{id}", name="public_manga_detail", methods={"GET"})
     */
    public function detail(int $id,MangaRepository $mangaRepository): Response
    {
        $manga = $mangaRepository->find($id);

        return $this->render('manga_public/detail.html.twig', [
            'manga' => $manga,
        ]);
    }
}