<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PostFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $faker = Factory::create();

            $post = new Post();
            $post->setTitle($faker->sentence());
            $post->setBody($faker->text());
            $post->setSlug($faker->slug);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
