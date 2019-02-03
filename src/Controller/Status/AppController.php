<?php
namespace App\Controller\Status;

use App\Controller\AbstractController;
use App\Helper\dbQueryHelper;
use App\Helper\similarImagesHelper;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    use dbQueryHelper;
    use similarImagesHelper;

    /**
     * @Route(methods={"GET"}, path="/status/db"))
     * @param LoggerInterface $logger
     * @return Response
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getDbStatus(LoggerInterface $logger): Response {
        $errors = [];
        $log = [];
        $databaseChecks = [
            'dm' => 'SELECT * FROM users LIMIT 1',
            'coa' => self::generateRowCheckOnTables($this->getEm('coa')),
            'coverid' => 'SELECT ID, issuecode, url FROM covers LIMIT 1',
            'dmstats' => 'SELECT * FROM utilisateurs_histoires_manquantes LIMIT 1',
            'edgecreator' => 'SELECT * FROM edgecreator_modeles2 LIMIT 1'
        ];
        foreach ($databaseChecks as $db=>$dbCheckQuery) {
            $response = self::checkDatabase($logger, $dbCheckQuery, $db, $this->getEm($db));
            if ($response !== true) {
                $errors[] = $response;
            }
        }
        if (count($errors) === 0) {
            $log[] = 'OK for all databases';
        }
        return new Response(implode('<br />', $log));
    }

    /**
     * @Route(methods={"GET"}, path="/status/pastecsearch/{pastecHost}", defaults={"pastecHost"="pastec"}))
     * @param LoggerInterface $logger
     * @param string          $pastecHost
     * @return Response
     */
    public function getPastecSearchStatus(LoggerInterface $logger, string $pastecHost): Response {
        $log = [];

        try {
            $outputObject = self::getSimilarImages(new File(self::$sampleCover, false), $logger, $pastecHost);
            $matchNumber = count($outputObject->getImageIds());
            if ($matchNumber > 0) {
                $log[] = "Pastec search returned $matchNumber image(s)";
            }
            else {
                throw new \Exception('Pastec search returned no image');
            }
        }
        catch(\Exception $e) {
            $error = $e->getMessage();
        }

        $output = implode('<br />', $log);
        if (isset($error)) {
            return new Response($error, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new Response($output);
    }
}
