<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $commentairetext;

    public function getId()
    {
        return $this->id;
    }

    public function getCommentairetext(): ?string
    {
        return $this->commentairetext;
    }

    public function setCommentairetext(string $commentairetext): self
    {
        $this->commentairetext = $commentairetext;

        return $this;
    }
}
