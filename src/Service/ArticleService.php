<?php

namespace App\Service;

use App\Contracts\Service\ArticleServiceInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ArticleService implements ArticleServiceInterface
{
    private HttpClientInterface $client;
    private $rapidApiKey;

    public function __construct(
        HttpClientInterface $client,
        string $rapidApiKey
    ) {
        $this->client = $client;
        $this->rapidApiKey = $rapidApiKey;
    }

    /**
     * {@inheritDoc}
     */
    public function generateBionicContent(string $content): string
    {
        if (strlen($content) < 500) {
            $content = $this->apiCall($content);
        }
        $arrayContent = str_split($content, 500);
        $arrayContentBionic = array();
        foreach ($arrayContent as $contentSplit) {
             $arrayContentBionic[] = $this->apiCall($contentSplit);
        }
        return implode('', $arrayContentBionic);
    }

    /**
     * @param string $content
     * @return string
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function apiCall(string $content): string
    {
        $newContent = $this->client->request(
            'POST',
            'https://bionic-reading1.p.rapidapi.com/convert', array(
                'headers' => array(
                    "X-RapidAPI-Host: bionic-reading1.p.rapidapi.com",
                    "X-RapidAPI-Key: $this->rapidApiKey",
                    "content-type: application/x-www-form-urlencoded"
                ),
                'body' => array(
                    'content' => $content,
                    'response_type' => 'html',
                    'request_type' => 'html',
                    'fixation' => '2',
                    'saccade' => '20'
                )
            )
        );
        $contentType = $newContent->getHeaders()['content-type'][0];
        $content = $newContent->getContent();
        return $content;
    }
}
