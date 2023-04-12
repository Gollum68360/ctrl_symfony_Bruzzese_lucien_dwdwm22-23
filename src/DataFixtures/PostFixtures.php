<?php

namespace App\DataFixtures;


use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use App\Repository\UserRepository;



class PostFixtures extends Fixture implements DependentFixtureInterface
{

    private UserRepository $userRepository;


    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 100; $i++) {

            $users = $this->userRepository->findAll();
            $post = new Post();
            $title = $faker->word();
            $userRandomKey = array_rand($users);
            $user = $users[$userRandomKey];
            $image = $faker->image(null, 360, 360, 'animals', true);




            $post
                ->setTitle($title)
                ->setAuthor($user)
                ->setCreatedAt(new DateTimeImmutable())
                ->setUpdatedAt(new DateTimeImmutable())
                ->setImage($image);



            $manager->persist($post);
        }



        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class
        ];
    }
}
