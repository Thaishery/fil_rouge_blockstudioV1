<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesRepository::class)
 */
class Services
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
     * @ORM\Column(type="string", length=1024, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="text")
     */
    private $short_desc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $long_desc;

    /**
     * @ORM\Column(type="integer")
     */
    private $carousel_rank;

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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getShortDesc(): ?string
    {
        return $this->short_desc;
    }

    public function setShortDesc(string $short_desc): self
    {
        $this->short_desc = $short_desc;

        return $this;
    }

    public function getLongDesc(): ?string
    {
        return $this->long_desc;
    }

    public function setLongDesc(?string $long_desc): self
    {
        $this->long_desc = $long_desc;

        return $this;
    }

    public function getCarouselRank(): ?int
    {
        return $this->carousel_rank;
    }

    public function setCarouselRank(int $carousel_rank): self
    {
        $this->carousel_rank = $carousel_rank;

        return $this;
    }
}
