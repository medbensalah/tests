<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PersonneFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for($i = 0; $i < 150; $i++) {
            $personne = new Personne();
            $personne->setName($faker->name);
            $personne->setFirstName($faker->firstName);
            $personne->setJob($faker->jobTitle);
            $personne->setCin($faker->numberBetween(10000000,99999999));
            $personne->setAge($faker->numberBetween(18,70));
            $personne->setPath($faker->imageUrl($width = 640, $heigth = 480));
            $manager->persist($personne);
        }
        $manager->flush();
    }
}
