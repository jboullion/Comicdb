<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Issue;
use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Publisher;

class AppFixtures extends Fixture
{
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
        $user->setPassword('testing');
        $user->setName('James Boullion');
        $user->setEmail('jboullion83@gmail.com');
        $user->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $this->addReference('JBoullion', $user);

        $manager->persist($user);

        $user = new User();
        $user->setUsername('KBoullion');
        $user->setPassword('testing');
        $user->setName('Katherine Boullion');
        $user->setEmail('katbrown83@gmail.com');
        $user->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $this->addReference('KBoullion', $user);

        $manager->persist($user);

        $manager->flush();
    }


    public function loadIssues(ObjectManager $manager)
    {
        $issue = new Issue();
        $issue->setTitle('A Test Comic');
        $issue->setSlug('a-test-comic');
        $issue->setPublication(new \DateTime(date('Y-m-d H:i:s')));
        $issue->setPublisher(26);
        $issue->setEditor('James Boullion');
        $issue->setUser($this->getReference('JBoullion'));
        $issue->setBarcode('01526525485');
        $issue->setGcdissueid('31919');
        $issue->setPrice(26.00);
        $issue->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($issue);

        $issue = new Issue();
        $issue->setTitle('Another Comic');
        $issue->setSlug('another-comic');
        $issue->setPublication(new \DateTime(date('Y-m-d H:i:s')));
        $issue->setPublisher(36);
        $issue->setEditor('Jordan Boullion');
        $issue->setUser($this->getReference('KBoullion'));
        $issue->setBarcode('03652658412');
        $issue->setGcdissueid('35265');
        $issue->setPrice(36.00);
        $issue->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($issue);

        $manager->flush();
    }


    public function loadComments(ObjectManager $manager)
    {
        $comment = new Comment();
        $comment->setContent('I love this comic!');
        $comment->setUser($this->getReference('JBoullion'));
        $comment->setPublished(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($comment);

        $comment = new Comment();
        $comment->setContent('I hate this comic!');
        $comment->setUser($this->getReference('KBoullion'));
        $comment->setPublished(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($comment);
    }


    public function loadPublisher(ObjectManager $manager)
    {

    }
}
