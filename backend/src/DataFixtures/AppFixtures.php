<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Review;
use App\Entity\Platform;
use App\Entity\Videogame;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\DataFixtures\Provider\VideogamesProvider;

class AppFixtures extends Fixture
{
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    // This method will reset all id's to 1
    private function truncate()
    {
        // Deactivates Foreign Key constraints
        $this->connection->query('SET foreign_key_checks = 0');
        // Truncates
        $this->connection->query('TRUNCATE TABLE videogame');
        $this->connection->query('TRUNCATE TABLE platform');
        $this->connection->query('TRUNCATE TABLE review');
        // etc.
    }


    public function load(ObjectManager $manager)
    {
        $this->truncate();

        // Instance of Faker
        $faker = Faker\Factory::create();

        // Keeps same data upon each reload of fixtures
        $faker->seed('videogame');
        // we use the Faker service for our custom data (@see VideogamesProvider.php)
        $faker->addProvider(new VideogamesProvider());

        // PLATFORMS

        // Platform list
        $platforms = $faker->getPlatformName();

        // Array that will store our list of platforms
        $platformsList = [];

        foreach ($platforms as $content) {
            // One platform
            $platform = new Platform();
            $platform->setName($content);
            $platform->setCreatedAt(new \Datetime());

            $platformsList[] = $platform;

            $manager->persist($platform);
        }

        // VIDEOGAMES

        // Videogame List 
        $videogames = $faker->getVideogameData();

        // Array that will store our list of videogames
        // But also used to associate videogames to reviews
        $gamesList = [];

        foreach ($videogames as $key => $content) {
            // One videogame
            $game = new Videogame();

            //!\ As $videogames is a multidimensional array (see Provider)...
            //! the main/first array's keys are numbers and its values are the second array's keys ("name", "editor",...)
            //! we need a second foreach to iterate over the second array in order to retrieve the CONTENT
            foreach ($content as $key => $value) {
                if ($key === 'name') {
                    $game->setName($value);
                }
                if ($key === 'editor') {
                    $game->setEditor($value);
                }
                if ($key === 'platform') {
                    foreach ($platformsList as $platform) {
                        if ($platform->getName() === $value) {
                            $game->setPlatform($platform);
                        }
                    }
                }
            }

            $game->setCreatedAt(new \Datetime());

            // Add games to list
            $gamesList[] = $game;

            // Save
            $manager->persist($game);
        }

        // REVIEWS
        $reviews = $faker->getReviewData();
        foreach ($reviews as $key => $content) {
            $review = new Review();

            foreach ($content as $key => $value) {
                if ($key === 'title') {
                    $review->setTitle($value);
                }
                if ($key === 'content') {
                    $review->setContent($value);
                }
                if ($key === 'author') {
                    $review->setAuthor($value);
                }
                if ($key === 'display_rating') {
                    $review->setDisplayRating($value);
                }
                if ($key === 'gameplay_rating') {
                    $review->setGameplayRating($value);
                }
                if ($key === 'story_rating') {
                    $review->setStoryRating($value);
                }
                if ($key === 'lifetime_rating') {
                    $review->setLifetimeRating($value);
                }
            }

            $review->setPublicationDate(new \DateTime());

            // Fetches a videogame at random for the above list
            $randomGame = $gamesList[mt_rand(0, count($gamesList) - 1)];
            $review->setVideogame($randomGame);

            // On persist
            $manager->persist($review);
        }

        $manager->flush();
    }
}
