<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     */
    private $years;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_of_tracks;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sample;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linktwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $linkthree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cover;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="projets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;
    

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="projetsfeat")
     */
    private $feat;

    public function __construct()
    {
        $this->feat = new ArrayCollection();
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

    public function getYears(): ?\DateTimeInterface
    {
        return $this->years;
    }

    public function setYears(\DateTimeInterface $years): self
    {
        $this->years = $years;

        return $this;
    }

    public function getNbOfTracks(): ?int
    {
        return $this->nb_of_tracks;
    }

    public function setNbOfTracks(int $nb_of_tracks): self
    {
        $this->nb_of_tracks = $nb_of_tracks;

        return $this;
    }

    public function getSample(): ?string
    {
        return $this->sample;
    }

    public function setSample(?string $sample): self
    {
        $this->sample = $sample;

        return $this;
    }

    public function getLinkone(): ?string
    {
        return $this->linkone;
    }

    public function setLinkone(?string $linkone): self
    {
        $this->linkone = $linkone;

        return $this;
    }

    public function getLinktwo(): ?string
    {
        return $this->linktwo;
    }

    public function setLinktwo(?string $linktwo): self
    {
        $this->linktwo = $linktwo;

        return $this;
    }

    public function getLinkthree(): ?string
    {
        return $this->linkthree;
    }

    public function setLinkthree(?string $linkthree): self
    {
        $this->linkthree = $linkthree;

        return $this;
    }

    // public function getCover(): ?string
    // {
    //     return $this->cover;
    // }

    // public function setCover(?string $cover): self
    // {
    //     $this->cover = $cover;

    //     return $this;
    // }
    public function getCover()
    {
        return $this->cover;
    }

    public function setCover($cover): self
    {
        $this->cover = $cover;

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

    public function getCreateur(): ?User
    {
        return $this->createur;
    }

    public function setCreateur(?User $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getFeat(): Collection
    {
        return $this->feat;
    }

    public function addFeat(User $feat): self
    {
        if (!$this->feat->contains($feat)) {
            $this->feat[] = $feat;
        }

        return $this;
    }

    public function removeFeat(User $feat): self
    {
        $this->feat->removeElement($feat);

        return $this;
    }
}
