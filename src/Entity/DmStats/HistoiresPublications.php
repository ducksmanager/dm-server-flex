<?php

namespace App\Models\DmStats;

use Doctrine\ORM\Mapping as ORM;

/**
 * HistoiresPublications
 *
 * @ORM\Table(name="histoires_publications", indexes={@ORM\Index(name="index_issue", columns={"publicationcode", "issuenumber"}), @ORM\Index(name="index_story", columns={"storycode"})})
 * @ORM\Entity
 */
class HistoiresPublications
{
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


}
