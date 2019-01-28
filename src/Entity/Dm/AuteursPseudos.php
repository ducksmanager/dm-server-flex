<?php

namespace App\Models\Dm;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuteursPseudos
 *
 * @ORM\Table(name="auteurs_pseudos")
 * @ORM\Entity
 */
class AuteursPseudos
{
    /**
     * @var string
     *
     * @ORM\Column(name="NomAuteurAbrege", type="string", length=30, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $nomauteurabrege = '';

    /**
     * @var int
     *
     * @ORM\Column(name="ID_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idUser;

    /**
     * @var bool
     *
     * @ORM\Column(name="Notation", type="boolean", nullable=false, options={"default"="-1"})
     */
    private $notation = '-1';

    public function getNomauteurabrege(): ?string
    {
        return $this->nomauteurabrege;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getNotation(): ?bool
    {
        return $this->notation;
    }

    public function setNotation(bool $notation): self
    {
        $this->notation = $notation;

        return $this;
    }


}
