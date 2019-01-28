<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * UtilisateursHistoiresManquantes
 *
 * @ORM\Table(name="utilisateurs_histoires_manquantes")
 * @ORM\Entity
 */
class UtilisateursHistoiresManquantes
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
     * @var int
     *
     * @ORM\Column(name="ID_User", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idUser;

    public function getPersoncode(): ?string
    {
        return $this->personcode;
    }

    public function getStorycode(): ?string
    {
        return $this->storycode;
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }


}
