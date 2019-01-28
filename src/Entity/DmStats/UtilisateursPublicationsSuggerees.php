<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateursPublicationsSuggerees
 *
 * @ORM\Table(name="utilisateurs_publications_suggerees", indexes={@ORM\Index(name="user", columns={"ID_User"})})
 * @ORM\Entity
 */
class UtilisateursPublicationsSuggerees
{
    /**
     * @var string
     *
     * @ORM\Column(name="publicationcode", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $publicationcode;

    /**
     * @var string
     *
     * @ORM\Column(name="issuenumber", type="string", length=12, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $issuenumber;

    /**
     * @var int
     *
     * @ORM\Column(name="Score", type="integer", nullable=false)
     */
    private $score;

    /**
     * @var \AuteursPseudos
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AuteursPseudos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_User", referencedColumnName="ID_User")
     * })
     */
    private $idUser;

    public function getPublicationcode(): ?string
    {
        return $this->publicationcode;
    }

    public function getIssuenumber(): ?string
    {
        return $this->issuenumber;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getIdUser(): ?AuteursPseudos
    {
        return $this->idUser;
    }

    public function setIdUser(?AuteursPseudos $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
