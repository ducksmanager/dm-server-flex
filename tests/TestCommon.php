<?php

namespace App\Tests;

use App\Models\Dm\Numeros;
use App\Models\Dm\Users;
use App\Tests\Fixtures\DmCollectionFixture;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;

abstract class TestCommon extends WebTestCase {

    /** @var Client $client  */
    protected static $client;

    protected static $defaultTestDmUserName = 'dm_test_user';
    public static $testDmUsers = [
        'dm_test_user' => 'test'
    ];
    protected static $dmUser = 'ducksmanager';
    protected static $edgecreatorUser = 'edgecreator';
    protected static $rawSqlUser = 'rawsql';
    protected static $adminUser = 'admin';
    protected static $uploadBase = '/tmp/dm-server';

    public static $exampleImage = 'cover_example.jpg';
    private static $roles = ['ducksmanager' => 'ducksmanagerpass'];

    /** @var Application $application */
    protected static $application;

    abstract protected function getEmNameToCreate(): string;

    protected function setUp() {
        parent::setUp();
        $this->spinUp($this->getEmNameToCreate());
    }

    protected function tearDown() {
        self::runCommand("doctrine:database:drop --connection={$this->getEmNameToCreate()}");
        parent::tearDown();
    }

    protected function spinUp($emName): void
    {
        self::runCommand("doctrine:database:drop --force --connection=$emName");
        self::runCommand("doctrine:database:create --connection=$emName");
        self::runCommand("doctrine:schema:create --em=$emName");
    }

    private static function getSystemCredentials($appUser, $version = '1.3+'): array
    {
        return self::getSystemCredentialsNoVersion($appUser) + [
            'HTTP_X_DM_VERSION' => $version
        ];
    }

    protected static function getSystemCredentialsNoVersion($appUser): array
    {
        return [
            'HTTP_AUTHORIZATION' => 'Basic '.base64_encode(implode(':', [$appUser, self::$roles[$appUser]]))
        ];
    }

    /**
     * @param string $path
     * @param array $userCredentials
     * @param array $parameters
     * @param array $systemCredentials
     * @param string $method
     * @param array $files
     * @return TestServiceCallCommon
     */
    protected function buildService(
        $path, $userCredentials = [], $parameters = [], $systemCredentials = [], $method = 'POST', $files = []
    ): TestServiceCallCommon
    {
        if (null === self::$application) {
            self::$client = static::createClient();
            self::$client->disableReboot();
        }
        $service = new TestServiceCallCommon(self::$client);
        $service->setPath($path);
        $service->setUserCredentials($userCredentials);
        $service->setParameters($parameters);
        $service->setSystemCredentials($systemCredentials);
        $service->setMethod($method);
        $service->setFiles($files);
        return $service;
    }

    protected function buildAuthenticatedService($path, $appUser, $userCredentials, $parameters = [], $method = 'POST'): TestServiceCallCommon
    {
        return $this->buildService($path, $userCredentials, $parameters, self::getSystemCredentials($appUser), $method);
    }

    protected function buildAuthenticatedServiceWithTestUser($path, $appUser, $method = 'GET', $parameters = [], $files = []): TestServiceCallCommon
    {
        return $this->buildService(
            $path, [
            'username' => self::$defaultTestDmUserName,
            'password' => sha1(self::$testDmUsers[self::$defaultTestDmUserName])
        ], $parameters, self::getSystemCredentials($appUser), $method, $files
        );
    }


    protected static function runCommand($command) {
        $command = sprintf('%s --quiet', $command);

        try {
            return self::getApplication()->run(new StringInput($command));
        } catch (\Exception $e) {
            self::fail("Couldn't run command '$command' : {$e->getMessage()}");
        }
        return null;
    }

    protected static function getApplication(): Application
    {
        if (null === self::$application) {
            self::$client = static::createClient();

            self::$application = new Application(self::$client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    protected static function getPathToFileToUpload($fileName) {
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'Fixtures', $fileName]);
    }

    /**
     * @param string $name
     * @return EntityManagerInterface
     */
    protected function getEm($name): EntityManagerInterface
    {
        $kernel = static::createKernel(['environment' => 'test']);
        $kernel->boot();
        return $kernel->getContainer()->get('doctrine')->getManager($name);
    }

    /**
     * @param string $username
     * @return Users
     */
    protected function getUser($username): Users
    {
        return $this->getEm('dm')->getRepository(Users::class)->findOneBy(compact('username'));
    }

    /**
     * @param string $username
     * @return Numeros[]
     */
    protected function getUserIssues($username): array
    {
        return $this->getEm('dm')
            ->getRepository(Numeros::class)
            ->findBy(['idUtilisateur' => $this->getUser($username)->getId()]);
    }

    protected function loadFixture(string $emName, $fixture): void
    {
        $loader = new Loader();
        $loader->addFixture($fixture);

        $purger = new ORMPurger();
        $executor = new ORMExecutor($this->getEm($emName), $purger);
        $executor->execute($loader->getFixtures(), true);
    }

    protected function createUserCollection($username): void
    {
        $this->loadFixture('dm', new DmCollectionFixture($username));
    }

    /**
     * @param Response $response
     * @return string
     */
    protected function getResponseContent($response): string
    {
        if ($response->isSuccessful()) {
            return $response->getContent();
        }

        $this->fail($response->getContent());
        return null;
    }

    /**
     * @param Response $response
     * @param $checkCallback
     */
    protected function assertUnsuccessfulResponse($response, $checkCallback): void
    {
        $this->assertFalse($response->isSuccessful());
        $checkCallback($response);
    }
}
