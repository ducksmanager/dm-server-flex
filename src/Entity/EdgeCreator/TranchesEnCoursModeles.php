<?php

namespace App\Models\EdgeCreator;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

/**
 * TranchesEnCoursModeles
 *
 * @ORM\Table(name="tranches_en_cours_modeles", uniqueConstraints={@ORM\UniqueConstraint(name="tranches_en_cours_modeles__numero", columns={"Pays", "Magazine", "Numero", "username"})})
 * @ORM\Entity
 */
class TranchesEnCoursModeles
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=3, nullable=false)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="Magazine", type="string", length=6, nullable=false)
     */
    private $magazine;

    /**
     * @var string
     *
     * @ORM\Column(name="Numero", type="string", length=10, nullable=false)
     */
    private $numero;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=25, nullable=true)
     */
    private $username;

    /**
     * @var TranchesEnCoursModelesImages[]
     *
     * @OneToMany(fetch="EAGER", targetEntity="TranchesEnCoursModelesImages", cascade={"persist", "remove"}, mappedBy="idModele")
     */
    private $photos = [];

    /**
     * @var TranchesEnCoursContributeurs[]
     *
     * @OneToMany(fetch="EAGER", targetEntity="TranchesEnCoursContributeurs", cascade={"persist", "remove"}, mappedBy="idModele")
     */
    private $contributeurs = [];

    /**
     * @var bool
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @var bool
     *
     * @ORM\Column(name="PretePourPublication", type="boolean", nullable=false)
     */
    private $pretepourpublication;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getMagazine(): ?string
    {
        return $this->magazine;
    }

    public function setMagazine(string $magazine): self
    {
        $this->magazine = $magazine;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set photos
     *
     * @param TranchesEnCoursModelesImages[] $photos
     *
     * @return TranchesEnCoursModeles
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;

        return $this;
    }

    /**
     * Get photographes
     *
     * @return TranchesEnCoursModelesImages[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set contributeurs
     *
     * @param TranchesEnCoursContributeurs[] $contributeurs
     *
     * @return TranchesEnCoursModeles
     */
    public function setContributeurs($contributeurs)
    {
        $this->contributeurs = $contributeurs;

        return $this;
    }

    /**
     * Get contributeurs
     *
     * @return TranchesEnCoursContributeurs[]
     */
    public function getContributeurs()
    {
        return $this->contributeurs;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getPretepourpublication(): ?bool
    {
        return $this->pretepourpublication;
    }

    public function setPretepourpublication(bool $pretepourpublication): self
    {
        $this->pretepourpublication = $pretepourpublication;

        return $this;
    }


}
