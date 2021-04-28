<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager as PersistenceObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(PersistenceObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');
        for($i= 0; $i <100 ; $i++){
            $property= new Property();
            $property
            ->setTitle($faker->words(3,true))
            ->setDescription($faker->sentences(3,true))
            ->setSurface($faker->numberBetween(9,1000000))
            ->setRooms($faker->numberBetween(1,20))
            ->setBedrooms($faker->numberBetween(1,20))
            ->setFloor($faker->numberBetween(0,350))
            ->setPrice($faker->numberBetween(100,10000000))
            ->setHeat($faker->numberBetween(0,count( Property::HEAT) - 1))
            ->setCity($faker->city)
            ->setAddress($faker->address)
            ->setPostalCode($faker->postcode)
            ->setIdSeller($faker->numberBetween(0,count( Property::ID_SELLER) - 1))
            ->setSold(false);

            $manager->persist($property);
        }
     

        $manager->flush();
    }
}
