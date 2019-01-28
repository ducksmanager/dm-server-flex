<?php

namespace App\Models\Dm;

use Doctrine\ORM\Mapping as ORM;

/**
 * TranchesDoublons
 *
 * @ORM\Table(name="tranches_doublons")
 * @ORM\Entity
 */
class TranchesDoublons
{
    /**
     * @var string
     *
     * @ORM\Column(name="Pays", type="string", length=3, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="Magazine", type="string", length=6, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $magazine;

    /**
     * @var string
     *
     * @ORM\Column(name="Numero", type="string", length=8, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="NumeroReference", type="string", length=8, nullable=false)
     */
    private $numeroreference;

    /**
     * @var int|null
     *
     * @ORM\Column(name="TrancheReference", type="integer", nullable=true)
     */
    private $tranchereference;

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function getMagazine(): ?string
    {
        return $this->magazine;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function getNumeroreference(): ?string
    {
        return $this->numeroreference;
    }

    public function setNumeroreference(string $numeroreference): self
    {
        $this->numeroreference = $numeroreference;

        return $this;
    }

    public function getTranchereference(): ?int
    {
        return $this->tranchereference;
    }

    public function setTranchereference(?int $tranchereference): self
    {
        $this->tranchereference = $tranchereference;

        return $this;
    }


}
