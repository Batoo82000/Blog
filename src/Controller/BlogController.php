<?php

namespace App\Controller;

use App\Services\CategoriesServices;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
    }
    #[Route('/', name: 'app_hello')]
    public function hello(ArticleRepository $repoArticle): Response
    {
        $articles = $repoArticle->findAll();
        
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $articles,
        ]);
    }
    #[Route('/article/{slug}', name: 'app_single_article')]
    public function single(ArticleRepository $repoArticle, string $slug): Response
    {
        $article = $repoArticle->findOneBySlug($slug);


        return $this->render('blog/single.html.twig', [
            'controller_name' => 'BlogController',
            'article' => $article
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


        return $this->render('blog/article_by_category.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles,
            'category' => $category
        ]);
    }

}
