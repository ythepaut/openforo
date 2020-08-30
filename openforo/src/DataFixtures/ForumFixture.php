<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Forum;

/**
 * OpenForo ForumFixture
 * 
 * @author      Yohann THEPAUT (ythepaut) <contact@ythepaut.com>
 * @copyright   CC BY-NC-SA 4.0
 */
class ForumFixture extends Fixture {

    public function load(ObjectManager $manager) {
        
        for ($i = 0 ; $i<10 ; $i++) {
            $forum = new Forum();
            $forum->setTitle("Forum n°" . $i);

            $manager->persist($forum);
        } 

        $manager->flush();
    }
}
