<?php

namespace App\Entity;

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
}
