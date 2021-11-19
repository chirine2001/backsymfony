<?php 

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends AbstractController
{
    /**
     * @Route("manga/article/{id}", name="public_article_show", methods={"GET","POST"})
     */
    public function show(Article $article,Request $request,EntityManagerInterface $em,int $id): Response
    {
        $commentaire = new Commentaire();

        $form = $this->createForm(CommentaireType::class, $commentaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $commentaire->setArticle($article);
            $commentaire->setAuteur($this->getUser());

            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('public_article_show', ['id' => $id]);
        }
        


        return $this->render('article_public/detail.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }
}