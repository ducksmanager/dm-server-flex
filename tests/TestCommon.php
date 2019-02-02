<?php

namespace App\Tests;

use App\Models\Dm\Users;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;

class TestCommon extends WebTestCase {

    /** @var Application $application  */
    protected static $application;
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

    protected static $exampleImage = 'cover_example.jpg';
    private static $roles = ['ducksmanager' => 'ducksmanagerpass'];

    private static function getSystemCredentials($appUser, $version = '1.3+') {
        return self::getSystemCredentialsNoVersion($appUser) + [
            'HTTP_X_DM_VERSION' => $version
        ];
    }

    protected static function getSystemCredentialsNoVersion($appUser)
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
        return implode(DIRECTORY_SEPARATOR, [__DIR__, 'fixtures', $fileName]);
    }

    /**
     * @param Application $app
     * @param Users $user
     */
    protected static function setSessionUser(Application $app, $user): void
    {
//        $app['session']->set('user', [
//            'username' => $user->getUsername(),
//            'id' => $user->getId()
//        ]);
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
