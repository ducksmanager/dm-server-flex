<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Response;

class AbstractController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    protected function callInternal($class, $function, $parameters): Response
    {
        return $this->forward($class.'::'.$function, $parameters);
    }

    /**
     * @param array $array
     * @return array
     */
    protected static function getSerializedArray($array): array
    {
        return array_map('serialize', $array);
    }

    /**
     * @param \stdClass[] $objectArray
     * @return array
     */
    protected static function getSimpleArray($objectArray): array
    {
        return array_map(/**
         * @param GenericReturnObjectInterface $object
         * @return array
         */
            function(GenericReturnObjectInterface $object) {
                return $object->toArray();
            }, $objectArray);
    }

    /**
     * @param array $array
     * @return array
     */
    protected static function getUnserializedArray($array): array
    {
        return array_map('unserialize', $array);
    }

    /**
     * @param string $json
     * @return array
     */
    protected static function getUnserializedArrayFromJson($json): array
    {
        return self::getUnserializedArray((array)json_decode($json));
    }

    /**
     * @param string $name
     * @return EntityManager
     */
    protected function getEm($name): EntityManager
    {
        return $this->container->get('doctrine')->getManager($name);
    }
}

interface GenericReturnObjectInterface {
    public function toArray();
}