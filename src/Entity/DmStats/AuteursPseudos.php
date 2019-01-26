<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuteursPseudos
 *
 * @ORM\Table(name="auteurs_pseudos", uniqueConstraints={@ORM\UniqueConstraint(name="auteurs_pseudos_ID_User_NomAuteurAbrege_uindex", columns={"ID_User", "NomAuteurAbrege"})}, indexes={@ORM\Index(name="index_auteur_inducks", columns={"NomAuteurAbrege"})})
 * @ORM\Entity
 */
class AuteursPseudos
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
     * @var int
     *
     * @ORM\Column(name="ID_User", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="NomAuteurAbrege", type="string", length=79, nullable=false)
     */
    private $nomauteurabrege;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="Notation", type="boolean", nullable=true)
     */
    private $notation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function setIdUser(int $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getNomauteurabrege(): ?string
    {
        return $this->nomauteurabrege;
    }

    public function setNomauteurabrege(string $nomauteurabrege): self
    {
        $this->nomauteurabrege = $nomauteurabrege;

        return $this;
    }

    public function getNotation(): ?bool
    {
        return $this->notation;
    }

    public function setNotation(?bool $notation): self
    {
        $this->notation = $notation;

        return $this;
    }


}
