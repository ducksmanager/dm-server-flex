<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * NumerosSimple
 *
 * @ORM\Table(name="numeros_simple", indexes={@ORM\Index(name="user_issue", columns={"Publicationcode", "Numero"}), @ORM\Index(name="ID_Utilisateur", columns={"ID_Utilisateur"})})
 * @ORM\Entity
 */
class NumerosSimple
{
    /**
     * @var string
     *
     * @ORM\Column(name="Publicationcode", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $publicationcode;

    /**
     * @var string
     *
     * @ORM\Column(name="Numero", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $numero;

    /**
     * @var \AuteursPseudos
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AuteursPseudos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_Utilisateur", referencedColumnName="ID_User")
     * })
     */
    private $idUtilisateur;

    public function getPublicationcode(): ?string
    {
        return $this->publicationcode;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function getIdUtilisateur(): ?AuteursPseudos
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?AuteursPseudos $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }


}
