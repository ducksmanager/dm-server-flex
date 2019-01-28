<?php

namespace App\Models\Dm;

use Doctrine\ORM\Mapping as ORM;

/**
 * BibliothequeAccesExternes
 *
 * @ORM\Table(name="bibliotheque_acces_externes")
 * @ORM\Entity
 */
class BibliothequeAccesExternes
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_Utilisateur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idUtilisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="Cle", type="string", length=16, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $cle;

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function getCle(): ?string
    {
        return $this->cle;
    }


}
