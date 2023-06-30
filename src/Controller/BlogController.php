<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/', name: 'app_hello')]
    public function hello(Request $request ,ArticleRepository $repoArticle, CategoryRepository $repoCat): Response
    {
        $articles = $repoArticle->findAll();
        $categories = $repoCat->findAll();

        $session = $request->getSession();
        $session->set("categories", $categories);
        

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $articles,
            // 'categories' => $categories,
        ]);
    }
    #[Route('/article/{slug}', name: 'app_single_article')]
    public function single(ArticleRepository $repoArticle, string $slug, CategoryRepository $repoCat): Response
    {
        $article = $repoArticle->findOneBySlug($slug);
        $categories = $repoCat->findAll();

        return $this->render('blog/single.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $article,
            'categories' => $categories,
        ]);
    }
    #[Route('/category/{slug}', name: 'app_article_by_category')]
    public function article_by_category(string $slug, CategoryRepository $repoCat, ArticleRepository $repoArticle, ): Response
    {
        $category = $repoCat->findOneBySlug($slug);
        $articles = [];
        if($category){
            $articles = $category->getArticles()->getValues();
        }

        $categories = $repoCat->findAll();

        return $this->render('blog/article_by_category.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
            'category' => $category,
            'categories' => $categories,
        ]);
    }

}
