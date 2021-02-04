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
     * @ORM\Column(type="blob", nullable=true)
     */
    private $sample;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="UserProjet")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getSample()
    {
        return $this->sample;
    }

    public function setSample($sample): self
    {
        $this->sample = $sample;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addUserProjet($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeUserProjet($this);
        }

        return $this;
    }
}
