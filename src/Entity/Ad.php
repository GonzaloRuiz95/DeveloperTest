<?php

namespace App\Entity;

use App\Repository\AdRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdRepository::class)]
class Ad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $tipology;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'integer')]
    private ?int $size;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $gardenSize;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $irrelevantSince;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $score;

    #[ORM\OneToMany(mappedBy: 'ad', targetEntity: Picture::class)]
    private $ad;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->ad = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipology(): ?string
    {
        return $this->tipology;
    }

    public function setTipology(string $tipology): self
    {
        $this->tipology = $tipology;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getGardenSize(): ?int
    {
        return $this->gardenSize;
    }

    public function setGardenSize(?int $gardenSize): self
    {
        $this->gardenSize = $gardenSize;

        return $this;
    }

    public function getIrrelevantSince(): ?\DateTimeInterface
    {
        return $this->irrelevantSince;
    }

    public function setIrrelevantSince(?\DateTimeInterface $irrelevantSince): self
    {
        $this->irrelevantSince = $irrelevantSince;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|Picture[]
     */
    public function getPictures(): Collection
    {
        return $this->ad;
    }
}
