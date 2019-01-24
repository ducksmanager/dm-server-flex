<?php
namespace App\Helper;

use App\Models\Dm\Numeros;

class PublicationHelper {
    public static function getPublicationCode(Numeros $issue) {
        return implode('/', [$issue->getPays(), $issue->getMagazine()]);
    }
}