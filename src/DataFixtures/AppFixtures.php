<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Issue;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Publisher;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;

    /**
     * @var \Faker\Factory
     */
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        
        $this->loadUsers($manager);
        $this->loadIssues($manager);
        $this->loadComments($manager);
        //$this->loadPublisher($manager);
    }


    public function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('JBoullion');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password123'));
        $user->setName('James Boullion');
        $user->setEmail('jboullion83@gmail.com');
        $user->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $this->addReference('JBoullion', $user);

        $manager->persist($user);

        $user = new User();
        $user->setUsername('KBoullion');
        $user->setPassword($this->passwordEncoder->encodePassword($user, 'password123'));
        $user->setName('Katherine Boullion');
        $user->setEmail('katbrown83@gmail.com');
        $user->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $this->addReference('KBoullion', $user);

        $manager->persist($user);

        $manager->flush();
    }


    public function loadIssues(ObjectManager $manager)
    {
        $user = $this->getReference('JBoullion');

        for($i = 0; $i < 100; $i++){
            $issue = new Issue();
            $issue->setTitle($this->faker->realText(30));
            $issue->setSlug($this->faker->slug);
            $issue->setPublication($this->faker->datetime);
            $issue->setPublisher($this->faker->numerify('##'));
            $issue->setEditor($this->faker->realText(30));
            $issue->setUser($user);
            $issue->setBarcode($this->faker->numerify('#############'));
            $issue->setGcdissueid($this->faker->numerify('########'));
            $issue->setPrice($this->faker->randomFloat(2, 1.00, 1000.00));
            $issue->setCreated($this->faker->datetime);
            
            $this->setReference("issue_$i", $issue);

            $manager->persist($issue);
        }

        $manager->flush();
    }


    public function loadComments(ObjectManager $manager)
    {
        $user = $this->getReference('KBoullion');
        
        for($i = 0; $i < 100; $i++){
            for($j = 0; $j < rand(1,10); $j++){
                $comment = new Comment();
                $comment->setContent($this->faker->realText());
                $comment->setUser($user);
                $comment->setPublished($this->faker->datetime);

                $manager->persist($comment);
            }
        }

        $manager->flush();
    }


    public function loadPublisher(ObjectManager $manager)
    {

    }
}
