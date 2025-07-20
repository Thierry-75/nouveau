<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\File(
        maxSize: '2M',maxSizeMessage: 'Max 2Mo',extensions: ['jpg','jpeg'],extensionsMessage: 'Image type jpg/jpeg'
    )]
    #[Assert\Image(
        minWidth: '1920',
        maxWidth: '3840',
        maxHeight: '2160',
        minHeight: '1080',
        allowLandscape: true,
        allowLandscapeMessage: 'Format paysage !',
    )]
    private ?Article $article = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }
}
