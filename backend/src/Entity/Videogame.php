<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\VideogameRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VideogameRepository::class)
 */
class Videogame
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("videogames_browse")
     * @Groups("videogames_read_reviews")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups("videogames_browse")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("videogames_browse")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $editor;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("videogames_browse")
     * @Groups("videogames_read_reviews")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("videogames_browse")  
     * @Groups("videogames_read_reviews")   
     */
    private $updatedAt;

    /**
     * A ManyToOne relation was created from entity Review to entity Videogame
     * A videogame can have many reviews, but only ONE videogame will belong to a specific review
     * 
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="videogame")
     * @Groups("videogames_read_item")
     */
    private $reviews;

    /**
     * @ORM\ManyToOne(targetEntity=Platform::class, inversedBy="videogames")
     * @Groups("videogames_browse")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $platform;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setVideogame($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getVideogame() === $this) {
                $review->setVideogame(null);
            }
        }

        return $this;
    }

    public function getPlatform(): ?Platform
    {
        return $this->platform;
    }

    public function setPlatform(?Platform $platform): self
    {
        $this->platform = $platform;

        return $this;
    }
}
