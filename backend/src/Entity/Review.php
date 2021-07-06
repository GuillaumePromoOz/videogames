<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ReviewRepository::class)
 */
class Review
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("videogames_read_reviews")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $publicationDate;

    /**
     * @ORM\Column(type="smallint")
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $displayRating;

    /**
     * @ORM\Column(type="smallint")
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $gameplayRating;

    /**
     * @ORM\Column(type="smallint")
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $storyRating;

    /**
     * @ORM\Column(type="smallint")
     * @Groups("videogames_read_item")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $lifetimeRating;

    /**
     * Many reviews to one videogame
     * 
     * @ORM\ManyToOne(targetEntity=Videogame::class, inversedBy="reviews")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $videogame;

    public function __construct()
    {
        $this->videogames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getPublicationDate(): ?\DateTimeInterface
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTimeInterface $publicationDate): self
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getDisplayRating(): ?int
    {
        return $this->displayRating;
    }

    public function setDisplayRating(int $displayRating): self
    {
        $this->displayRating = $displayRating;

        return $this;
    }

    public function getGameplayRating(): ?int
    {
        return $this->gameplayRating;
    }

    public function setGameplayRating(int $gameplayRating): self
    {
        $this->gameplayRating = $gameplayRating;

        return $this;
    }

    public function getStoryRating(): ?int
    {
        return $this->storyRating;
    }

    public function setStoryRating(int $storyRating): self
    {
        $this->storyRating = $storyRating;

        return $this;
    }

    public function getLifetimeRating(): ?int
    {
        return $this->lifetimeRating;
    }

    public function setLifetimeRating(int $lifetimeRating): self
    {
        $this->lifetimeRating = $lifetimeRating;

        return $this;
    }

    public function getVideogame(): ?Videogame
    {
        return $this->videogame;
    }

    public function setVideogame(?Videogame $videogame): self
    {
        $this->videogame = $videogame;

        return $this;
    }
}
