<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PlatformRepository::class)
 */
class Platform
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("videogames_read_reviews")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("videogames_browse")
     * @Groups("reviews_browse")
     * @Groups("videogames_read_reviews")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=25)
     * @Groups("videogames_browse")
     * @Groups("videogames_read_reviews")
     */
    private $publisher;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Videogame::class, mappedBy="platform")
     */
    private $videogames;

    public function __construct()
    {
        $this->videogames = new ArrayCollection();
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

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): self
    {
        $this->publisher = $publisher;

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

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Videogame[]
     */
    public function getVideogames(): Collection
    {
        return $this->videogames;
    }

    public function addVideogame(Videogame $videogame): self
    {
        if (!$this->videogames->contains($videogame)) {
            $this->videogames[] = $videogame;
            $videogame->setPlatform($this);
        }

        return $this;
    }

    public function removeVideogame(Videogame $videogame): self
    {
        if ($this->videogames->removeElement($videogame)) {
            // set the owning side to null (unless already changed)
            if ($videogame->getPlatform() === $this) {
                $videogame->setPlatform(null);
            }
        }

        return $this;
    }
}
