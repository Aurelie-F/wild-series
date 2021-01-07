<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ActorRepository::class)
 * @Vich\Uploadable
 */
class Actor
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Program::class, inversedBy="actors")
     */
    private $programs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @Vich\UploadableField(mapping="photo_file", fileNameProperty="photo")
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif",},
     *     mimeTypesMessage = "Please upload an image"
     * )
     */
    private ?File $photoFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
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

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): self
    {
        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        $this->programs->removeElement($program);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return File|null
     */
    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }

    /**
     * @param File|null $photoFile
     */
    public function setPhotoFile(?File $photoFile): void
    {
        $this->photoFile = $photoFile;
        if ($photoFile) {
            $this->updatedAt = new DateTime('now');
        }
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
}
