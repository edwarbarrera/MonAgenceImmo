<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     * 
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    
    {
        $this->encoder=$encoder;
        
    }



    public function load(ObjectManager $em)
    {
         $user = new User();
         $user->setUsername('demo');
         $user->setPassword($this->encoder->encodePassword($user, 'demo'));
         $em->persist($user);

        $em->flush();
    }
}
