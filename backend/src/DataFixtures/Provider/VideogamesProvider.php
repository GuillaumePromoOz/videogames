<?php

namespace App\DataFixtures\Provider;

class VideogamesProvider
{

    private $videogames = [
        1 => [
            'name' => 'The Sims',
            'editor' => 'Electronic Arts',
            'platform' => 'PC',
        ],
        2 => [
            'name' => 'Rayman',
            'editor' => 'Ubi Soft',
            'platform' => 'Playstation',
        ],
        3 => [
            'name' => 'Duck Hunt',
            'editor' => 'Nintendo',
            'platform' => 'Nintendo',
        ],
        4 => [
            'name' => 'NBA Jam',
            'editor' => 'Midway',
            'platform' => 'Mega Drive',
        ],
        5 => [
            'name' => 'Madden NFL 2005',
            'editor' => 'EA Sports',
            'platform' => 'Xbox',
        ],
        5 => [
            'name' => 'Space Invaders',
            'editor' => 'Atari, Inc.',
            'platform' => 'Atari',
        ],
    ];

    private $platforms = [
        'PC',
        'Playstation',
        'Nintendo',
        'Mega Drive',
        'Xbox',
        'Atari',
    ];

    private $reviews = [
        1 => [
            'title' => 'Still great!',
            'content' => 'After all theses years, it holds up completely. Love it.',
            'author' => 'John',
            'display_rating' => '7',
            'gameplay_rating' => '8',
            'story_rating' => '6',
            'lifetime_rating' => '9',
        ],
        2 => [
            'title' => 'Pass the salsa por favor',
            'content' => 'So good, I can\'t get enough of it. Not the salsa, the game. I don\'t know why I said that, ha ha.',
            'author' => 'Mike',
            'display_rating' => '8',
            'gameplay_rating' => '9',
            'story_rating' => '7',
            'lifetime_rating' => '10',
        ],
        3 => [
            'title' => 'Woah, what happened?',
            'content' => 'OK, let me first say that this is an odd one. Can\'t say I hate right but still, pretty weird...',
            'author' => 'Zack B.',
            'display_rating' => '6',
            'gameplay_rating' => '7',
            'story_rating' => '5',
            'lifetime_rating' => '1',
        ],
        4 => [
            'title' => 'Watch out for tentacles!',
            'content' => 'This game is INSANE. Do not play unless you are planning on not having a life. You\'ve been warned.',
            'author' => 'DonnieDarkoFan61',
            'display_rating' => '8',
            'gameplay_rating' => '9',
            'story_rating' => '7',
            'lifetime_rating' => '10',
        ],
        5 => [
            'title' => 'Fantastic!',
            'content' => 'Nuff said.',
            'author' => 'Pete LeBlanc',
            'display_rating' => '9',
            'gameplay_rating' => '9',
            'story_rating' => '10',
            'lifetime_rating' => '10',
        ],
        6 => [
            'title' => 'Could have been so much better',
            'content' => 'Overlong and overwritten. Not much in the surprise department either. Shame.',
            'author' => 'Grumpy Old Man',
            'display_rating' => '2',
            'gameplay_rating' => '3',
            'story_rating' => '4',
            'lifetime_rating' => '1',
        ],
    ];

    /**
     * Get the value of videogames
     */
    public function getVideogameData()
    {
        return $this->videogames;
    }

    /**
     * Get the value of platforms
     */
    public function getPlatformName()
    {
        return $this->platforms;
    }

    /**
     * Get the value of reviews
     */
    public function getReviewData()
    {
        return $this->reviews;
    }
}
