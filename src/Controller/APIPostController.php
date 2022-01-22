<?php

namespace App\Controller;

use App\Repository\PostRepository;
use MediaMonks\RestApi\Response\OffsetPaginatedResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class APIPostController extends AbstractController
{
    /**
     * @Route("/api/blogs", name="api.posts")
     */
    public function index(PostRepository $postRepository, Request $request) 
    {
        $limit = (int) $request->query->get('limit', $postRepository::PAGINATION_DEFAULT_LIMIT);
        $offset = (int) $request->query->get('offset', 0);

        $posts = $postRepository->getAllPostsPaginatedByOffset($offset, $limit);

        $total = $posts->count();

        return new OffsetPaginatedResponse($posts->getIterator(), $offset, $limit, $total);
    }

    /**
     * @Route("/api/blogs/{id}", name="api.posts_show")
     */
    public function show(PostRepository $postRepository, int $id) 
    {
        $post = $postRepository->find($id);

        if(!$post) {
            throw $this->createNotFoundException(
                'The post you are looking for does not exists.'
            );
        }

        return $post;
    }
}
