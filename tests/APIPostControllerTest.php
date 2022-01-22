<?php

namespace App\Tests;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Post;
use App\Repository\PostRepository;

class APIPostControllerTest extends ApiTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \JMS\Serializer\SerializerBuilder
     */
    private $serializer;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testItReturnsAListOfPosts(): void
    {
        $postsFromRepository = $this->entityManager
            ->getRepository(Post::class)
            ->findBy([], ['createdAt' => 'DESC']);

        $paginatedPosts = array_slice($postsFromRepository, 0, 20);
        $paginatedPostsIds = array_map(function ($post) {
            return ['id' => $post->getId()];
        }, $paginatedPosts);

        $response = static::createClient()->request('GET', '/api/blogs');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'pagination' => [
                'offset' => 0,
                'limit' => 20,
                'total' => count($postsFromRepository)
            ]
        ]);

        $this->assertJsonContains(['data' => $paginatedPostsIds]);
    }

    public function testItReturnAListWithCertainOffsetAndLimit(): void
    {
        $limit = 14;
        $offset = 5;
        $postsFromRepository = $this->entityManager
            ->getRepository(Post::class)
            ->findBy([], ['createdAt' => 'DESC']);

        $paginatedPosts = array_slice($postsFromRepository, $offset, $limit);
        $paginatedPostsIds = array_map(function ($post) {
            return ['id' => $post->getId()];
        }, $paginatedPosts);

        $response = static::createClient()->request('GET', "/api/blogs?limit=$limit&offset=$offset");

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'pagination' => [
                'offset' => $offset,
                'limit' => $limit,
                'total' => count($postsFromRepository)
            ]
        ]);

        $this->assertJsonContains(['data' => $paginatedPostsIds]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
