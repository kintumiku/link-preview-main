<?php

namespace LinkPreview\Reader;

use Guzzle\Http\Client;
use LinkPreview\Model\LinkInterface;

class GeneralReader implements ReaderInterface
{
    /**
     * @inheritdoc
     */
    private $link;

    /**
     * @var Client $client
     */
    private $client;

    /**
     * @inheritdoc
     */
    public function setLink(LinkInterface $link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        if (!$this->client) {
            $this->client = new Client();
        }

        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    public function readLink()
    {
        $link = $this->getLink();

        $client = $this->getClient();
        $client->setBaseUrl($link->getUrl());
        $response = $client->get()->send();

        $link->setContent($response->getBody(true))
            ->setContentType($response->getContentType())
            ->setRealUrl($response->getEffectiveUrl());

        return $link;
    }
} 