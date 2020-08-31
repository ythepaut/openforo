<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Forum;
use App\Entity\Discussion;
use App\Entity\Post;

/**
 * OpenForo Fixtures
 * 
 * @author      Yohann THEPAUT (ythepaut) <contact@ythepaut.com>
 * @copyright   CC BY-NC-SA 4.0
 */
class AppFixtures extends Fixture {

    public function load(ObjectManager $manager) {
        
        for ($i = 1 ; $i <= 10 ; $i++) {
            $forum = new Forum();
            $forum->setTitle("FORUM " . $i);

            for ($j = 1 ; $j <= 10 ; $j++) {
                $discussion = new Discussion();
                $discussion->setTitle("Discussion n°" . $j . " du forum n°" . $i);
                $discussion->setCreationDate(new \DateTime());
                $discussion->setStatus("OPEN");
                $discussion->setForum($forum);

                for ($k = 1 ; $k <= 3 ; $k++) {
                    $post = new Post();
                    $post->setCreationDate(new \DateTime());
                    $post->setContent("Post n°" . $k . " de la discussion n°" . $j . " du forum n°" . $i . "<br />Lorem ipsum dolor sit amet consectetur adipisicing elit. Unde est nesciunt voluptatum cupiditate voluptate quis quos blanditiis saepe ad rem reiciendis, aliquid voluptatem adipisci placeat, tempora alias, repellat corrupti eius!");
                    $post->setDiscussion($discussion);
                
                    $manager->persist($post);
                }

                $manager->persist($discussion);
            }

            $manager->persist($forum);
        } 

        $manager->flush();
    }
}
