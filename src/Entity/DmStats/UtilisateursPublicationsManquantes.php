<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateursPublicationsManquantes
 *
 * @ORM\Table(name="utilisateurs_publications_manquantes", indexes={@ORM\Index(name="user_stories", columns={"ID_User", "personcode", "storycode"}), @ORM\Index(name="issue", columns={"ID_User", "publicationcode", "issuenumber"})})
 * @ORM\Entity
 */
class UtilisateursPublicationsManquantes
{
    /**
     * @var string
     *
     * @ORM\Column(name="personcode", type="string", length=22, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $personcode;

    /**
     * @var string
     *
     * @ORM\Column(name="storycode", type="string", length=19, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $storycode;

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
     * @ORM\Column(name="ID_User", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idUser;

    /**
     * @var bool
     *
     * @ORM\Column(name="Notation", type="boolean", nullable=false)
     */
    private $notation;

    public function getPersoncode(): ?string
    {
        return $this->personcode;
    }

    public function getStorycode(): ?string
    {
        return $this->storycode;
    }

    public function getPublicationcode(): ?string
    {
        return $this->publicationcode;
    }

    public function getIssuenumber(): ?string
    {
        return $this->issuenumber;
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
