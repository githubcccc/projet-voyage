<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as FOSParentUser;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="app_user")
 */
class User extends FOSParentUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\IdentityUser", mappedBy="user", cascade={"persist", "remove"})
     */
    protected $identityUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voyage", mappedBy="user", orphanRemoval=true)
     */
    protected $voyages;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->voyages = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }



    public function getIdentityUser(): ?IdentityUser
    {
        return $this->identityUser;
    }

    public function setIdentityUser(IdentityUser $identityUser): self
    {
        $this->identityUser = $identityUser;

        // set the owning side of the relation if necessary
        if ($this !== $identityUser->getUser()) {
            $identityUser->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Voyage[]
     */
    public function getVoyages(): Collection
    {
        return $this->voyages;
    }

    public function addVoyage(Voyage $voyage): self
    {
        if (!$this->voyages->contains($voyage)) {
            $this->voyages[] = $voyage;
            $voyage->setUser($this);
        }

        return $this;
    }

    public function removeVoyage(Voyage $voyage): self
    {
        if ($this->voyages->contains($voyage)) {
            $this->voyages->removeElement($voyage);
            // set the owning side to null (unless already changed)
            if ($voyage->getUser() === $this) {
                $voyage->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Place un rôle unique à l'utilisateur (supprimer tous les anciens rôles)
     * @param string $userRole
     */
    public function setRole(string $userRole)
    {
        // Vider les rôles
        foreach ($this->getRoles() as $role) {
            $this->removeRole($role);
        }
        // Ajout le rôle unique passé en paramètre
        $this->addRole($userRole);
    }

}
