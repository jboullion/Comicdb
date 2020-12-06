<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Issue;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $issue = new Issue();
        $issue->setTitle('A Test Comic');
        $issue->setSlug('a-test-comic');
        $issue->setPublication(new \DateTime(date('Y-m-d H:i:s')));
        $issue->setPublisher('26');
        $issue->setEditor('James Boullion');
        $issue->setBarcode('01526525485');
        $issue->setGcdissueid('31919');
        $issue->setPrice(26.00);
        $issue->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($issue);

        $issue = new Issue();
        $issue->setTitle('Another Comic');
        $issue->setSlug('another-comic');
        $issue->setPublication(new \DateTime(date('Y-m-d H:i:s')));
        $issue->setPublisher('36');
        $issue->setEditor('Jordan Boullion');
        $issue->setBarcode('03652658412');
        $issue->setGcdissueid('35265');
        $issue->setPrice(36.00);
        $issue->setCreated(new \DateTime(date('Y-m-d H:i:s')));

        $manager->persist($issue);

        $manager->flush();
    }
}
