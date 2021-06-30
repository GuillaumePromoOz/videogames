<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Review;
use App\Entity\Platform;
use App\Entity\Videogame;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    // Our values
    const NB_VIDEOGAMES = 5;
    const NB_PLATFORMS = 5;
    // We want 5 reviews per videogame
    const NB_REVIEWS = 5 * self::NB_VIDEOGAMES;


    public function load(ObjectManager $manager)
    {
        // Instance of Faker
        $faker = Faker\Factory::create();

        // Keeps same data upon each reload of fixtures
        $faker->seed('videogame');

        //TODO : create Provider with real data

        // VIDEOGAMES

        // Array that will store our list of videogames
        // But also used to associate videogames to reviews
        $gamesList = [];

        for ($i = 1; $i <= self::NB_VIDEOGAMES; $i++) {
            // One videogame
            $game = new Videogame();
            // We define its title with the setter
            $game->setName($faker->word());
            // etc ...
            $game->setEditor($faker->company());
            $game->setCreatedAt(new \Datetime());

            // Add games to list
            $gamesList[] = $game;

            // Save
            $manager->persist($game);
        }

        // PLATFORMS

        // Array that will store our list of platforms
        $platformsList = [];

        for ($i = 1; $i <= self::NB_PLATFORMS; $i++) {
            // One platform
            $platform = new Platform();
            $platform->setName($faker->safeColorName());
            $platform->setPublisher($faker->company());
            $platform->setCreatedAt(new \Datetime());

            // Associates 1 to 3 videogames at random
            // Using shuffle will make each one Unique
            shuffle($gamesList);

            for ($r = 0; $r < mt_rand(1, 3); $r++) {
                // Fetches the $r index in the array
                // unicity is warranted
                $randomGame = $gamesList[$r];
                $platform->addVideogame($randomGame);
            }

            $platformsList[] = $platform;

            $manager->persist($platform);
        }

        // REVIEWS
        for ($i = 1; $i <= self::NB_REVIEWS; $i++) {
            $review = new Review();
            $review->setTitle($faker->text());
            $review->setContent($faker->paragraph());
            $review->setAuthor($faker->name());
            $review->setPublicationDate(new \DateTime());
            $review->setDisplayRating($faker->randomDigitNotNull());
            $review->setGameplayRating($faker->randomDigitNotNull());
            $review->setStoryRating($faker->randomDigitNotNull());
            $review->setLifetimeRating($faker->randomDigitNotNull());

            // Fetches a videogame at random for the above list
            $randomGame = $gamesList[mt_rand(0, count($gamesList) - 1)];
            $review->setVideogame($randomGame);

            // On persist
            $manager->persist($review);
        }

        $manager->flush();
    }
}
