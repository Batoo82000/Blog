<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Article;
use App\Entity\Profile;
use App\Entity\Category;
use EsperoSoft\Faker\Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();

        $users = [];
        for ($i=0; $i < 100 ; $i++) { 
            $user = (new User())->setFullName($faker->full_name())
                                ->setEmail($faker->email())
                                ->setPassword(sha1("azerty"))
                                ->setCreatedAt($faker->dateTimeImmutable());

            $address = (new Address())  ->setStreet($faker->streetAddress())
                                        ->setCodePostal($faker->codepostal())
                                        ->setCity($faker->city())
                                        ->setCountry($faker->country())
                                        ->setCreatedAt($faker->dateTimeImmutable());

            $profile = (new Profile())  ->setPicture($faker->image())
                                        ->setCoverPicture($faker->image())
                                        ->setDescription($faker->description(60))
                                        ->setCreatedAt($faker->dateTimeImmutable());

            $user->addAddress($address);
            $user->setProfile($profile);
            $users[] = $user;
            $manager->persist($user);
            $manager->persist($address);
            $manager->persist($profile);
        }
        // $product = new Product();
        // $manager->persist($product);

        $categories = [];
        for ($i=0; $i < 10 ; $i++) { 
            $category = (new Category())->setName($faker->description(30))
                                        ->setDescription($faker->description(60))
                                        ->setImageUrl($faker->image())
                                        ->setCreatedAt($faker->dateTimeImmutable());

            $categories[] = $category;   
            $manager->persist($category);                        

        }
        for ($i=0; $i < 300 ; $i++) { 
            $article = (new Article())  ->setTitle($faker->description(30))
                                        ->setContent($faker->text(5,10))
                                        ->setImageUrl($faker->image())
                                        ->setCreatedAt($faker->dateTimeImmutable())
                                        ->setAuthor($users[rand(0, count($users)-1)])
                                        ->addCategory($categories[rand(0, count($categories)-1)]); 
            $manager->persist($article);                        

        }

        $manager->flush();
    }
}
