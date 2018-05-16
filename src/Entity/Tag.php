<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagRepository")
 */
class Tag
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $tagname;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Voyage", inversedBy="tags")
     */
    private $voyage;

    public function __construct()
    {
        $this->voyage = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->tagname;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTagname(): ?string
    {
        return $this->tagname;
    }

    public function setTagname(string $tagname): self
    {
        $this->tagname = $tagname;

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyage(): Collection
    {
        return $this->voyage;
    }

    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyage->contains($voyage)) {
            $this->voyage[] = $voyage;
        }

        return $this;
    }

    public function removeVoyage(Voyage $voyage): self
    {
        if ($this->voyage->contains($voyage)) {
            $this->voyage->removeElement($voyage);
        }

        return $this;
    }
}
