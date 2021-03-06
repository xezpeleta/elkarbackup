<?php
namespace App\Tests\api;

class ClientMother
{
    const CLIENT_CONTEXT = [
        '@context' => [
            '@vocab' => 'http://127.0.0.1/api/docs.jsonld#',
            'hydra' => 'http://www.w3.org/ns/hydra/core#',
            'description' => 'ClientOutput/description',
            'id' => 'ClientOutput/id',
            'isActive' => 'ClientOutput/isActive',
            'maxParallelJobs' => 'ClientOutput/maxParallelJobs',
            'name' => 'ClientOutput/name',
            'owner' => 'ClientOutput/owner',
            'postScripts' => 'ClientOutput/postScripts',
            'preScripts' => 'ClientOutput/preScripts',
            'quota' => 'ClientOutput/quota',
            'rsyncLongArgs' => 'ClientOutput/rsyncLongArgs',
            'rsyncShortArgs' => 'ClientOutput/rsyncShortArgs',
            'sshArgs' => 'ClientOutput/sshArgs',
            'url' => 'ClientOutput/url'
        ],
        '@type' => 'Client'
    ];
    const UNEXISTING_ID = 726358291635;

    public static function base(): RequestObject
    {
        $clientName = self::createClientName();
        $data = [
            'description' => null,
            'isActive' => true,
            'maxParallelJobs' => 1,
            'name' => $clientName,
            'owner' => 1,
            'quota' => -1,
            'postScripts' => [],
            'preScripts' => [], 
            'rsyncLongArgs' => null,
            'rsyncShortArgs' => null,
            'sshArgs' => null,
            'url' => ""
        ];
        $response = new RequestObject(self::CLIENT_CONTEXT, $data);
        return $response;
    }

    private function createClientName(): string
    {
        $time = new \DateTime();
        $clientName = 'client_'.$time->getTimestamp().'_'.rand(1000, 9999);
        return $clientName;
    }

    public static function getNonExistentIri(): string
    {
        return '/api/clients/'.self::UNEXISTING_ID;
    }

    public static function named(string $clientName): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['name'] = $clientName;
        $response->setData($data);
        return $response;
    }

    public static function withAllParameters(
        int $owner, 
        string $description, 
        bool $isActive, 
        int $maxParallelJobs, 
        array $postScripts, 
        array $preScripts, 
        int $quota, 
        string $rsyncLongArgs, 
        string $rsyncShortArgs, 
        string $sshArgs, 
        string $url    
    ): RequestObject {
        $clientName = self::createClientName();
        $data = [
            'description' => $description,
            'isActive' => $isActive,
            'maxParallelJobs' => $maxParallelJobs,
            'name' => $clientName,
            'owner' => $owner,
            'postScripts' => $postScripts,
            'preScripts' => $preScripts,
            'quota' => $quota,
            'rsyncLongArgs' => $rsyncLongArgs,
            'rsyncShortArgs' => $rsyncShortArgs,
            'sshArgs' => $sshArgs,
            'url' => $url
        ];
        $response = new RequestObject(self::CLIENT_CONTEXT, $data);
        return $response;
    }

    public static function withInvalidMaxParallelJobs(): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['maxParallelJobs'] = -1;
        $response->setData($data);
        return $response;
    }
    public static function withMaxParallelJobs(int $maxParallelJobs): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['maxParallelJobs'] = $maxParallelJobs;
        $response->setData($data);
        return $response;
    }

    public static function withNonExistentOwner(): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['owner'] = self::UNEXISTING_ID;
        $response->setData($data);
        return $response;
    }

    public static function withNonExistentPostScripts(): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['postScripts'] = [self::UNEXISTING_ID];
        $response->setData($data);
        return $response;
    }

    public static function withNonExistentPreScripts(): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['preScripts'] = [self::UNEXISTING_ID];
        $response->setData($data);
        return $response;
    }

    public static function withOwner(int $owner): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['owner'] = $owner;
        $response->setData($data);
        return $response;
    }
    public static function withPostScripts(array $postScripts): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['postScripts'] = $postScripts;
        $response->setData($data);
        return $response;
    }

    public static function withPreScripts(array $preScripts): RequestObject
    {
        $response = self::base();
        $data = $response->getData();
        $data['preScripts'] = $preScripts;
        $response->setData($data);
        return $response;
    }
}

