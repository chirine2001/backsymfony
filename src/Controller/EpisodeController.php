<?php 

namespace App\Controller;


use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\EpisodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EpisodeController extends AbstractController
{

     /**
     * @Route("/episode/detail/{id}", name="public_episode_detail")
     */
    public function detail(int $id,EpisodeRepository $episodeRepository, Request $request, EntityManagerInterface $em): Response
    {
        $episode = $episodeRepository->find($id);
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $commentaire->setEpisode($episode);
            $commentaire->setAuteur($this->getUser());

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('public_episode_detail', ['id' => $id]);
        }

        return $this->render('episode_public/detail.html.twig', [
            'episode' => $episode,
            'form' => $form->createView()
        ]);
    }
}