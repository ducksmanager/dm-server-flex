<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuteursHistoires
 *
 * @ORM\Table(name="auteurs_histoires", indexes={@ORM\Index(name="index_storycode", columns={"storycode"})})
 * @ORM\Entity
 */
class AuteursHistoires
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

    public function getPersoncode(): ?string
    {
        return $this->personcode;
    }

    public function getStorycode(): ?string
    {
        return $this->storycode;
    }


}
