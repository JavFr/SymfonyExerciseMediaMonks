<?php

namespace App\Tests\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testItReturnsACompleteListOfPosts(): void
    {
        $postsFromRepository = $this->entityManager
            ->getRepository(Post::class)
            ->findBy([], ['createdAt' => 'DESC'], 20);

        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertCount(count($postsFromRepository), $crawler->filter('.post-card'));

        $crawledTitles = $crawler->filter('.post-card > a')->extract('_text');

        foreach ($postsFromRepository as $post)
        {
            $this->assertTrue(in_array($post->getTitle(), $crawledTitles), "Post {$post->getId()}: missing title.");
        }

    }

    public function testItReturnsTheSecondPageOfPosts(): void
    {
        $postsFromRepository = $this->entityManager
            ->getRepository(Post::class)
            ->findBy([], ['createdAt' => 'DESC'], 20, 20);

        $client = static::createClient();
        $crawler = $client->request('GET', '/?page=2');

        $this->assertResponseIsSuccessful();
        $this->assertCount(count($postsFromRepository), $crawler->filter('.post-card'));

        $crawledTitles = $crawler->filter('.post-card > a')->extract('_text');

        foreach ($postsFromRepository as $post)
        {
            $this->assertTrue(in_array($post->getTitle(), $crawledTitles), "Post {$post->getId()}: missing title.");
        }

    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null;
    }
}
