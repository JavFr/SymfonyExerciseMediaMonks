<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $postRepository, Request $request): Response
    {
        $currentPage = $request->query->get('page', 1);
        $posts = $postRepository->getAllPosts($currentPage);

        $allPosts = $posts->count();
        $pagePosts = $posts->getIterator()->count();

        $maxPages = $allPosts > $pagePosts? ceil($allPosts / $postRepository::PAGINATION_DEFAULT_LIMIT) : 1;  


        return $this->render('post/index.html.twig', compact('posts', 'currentPage', 'maxPages'));
    }
}
