<?php

namespace src\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class MilvusClient
{
    protected $host;
    protected $port;
    protected $version;
    protected $client;

    public function __construct()
    {
        $this->host = constants('milvus.host');
        $this->port = constants('milvus.port');
        $this->version = '/api/v1';
        $this->client = new Client([
            'base_uri' => "http://{$this->host}:{$this->port}"
        ]);
    }

    public function checkHealth()
    {
        $path = "{$this->version}/health";
        try {
            return $this->sendRequest("GET", $path);
        } catch (ClientException $e) {
            return false;
        }
    }

    public function createCollection($collectionName, $schema)
    {
        $path = "{$this->version}/collection";
        $body = [
            "collection_name" => $collectionName,
            "schema" => $schema
        ];

        return $this->sendRequest("POST", $path, $body);
    }

    public function loadCollection($collectionName)
    {
        $path = "{$this->version}/collection/load";
        $body = [
            "collection_name" => $collectionName
        ];

        return $this->sendRequest("POST", $path, $body);
    }

    public function insertData($collectionName, $data)
    {
        $path = "{$this->version}/collection";
        $body = [
            "collection_name" => $collectionName,
            "fields_data" => $data
        ];

        return $this->sendRequest("POST", $path, $body);
    }

    public function dropCollection($collectionName)
    {
        $path = "{$this->version}/collection";
        $body = [
            "collection_name" => $collectionName
        ];

        return $this->sendRequest("DELETE", $path, $body);
    }

    public function createIndex($collectionName, $fieldName, $extraParams)
    {
        $path = "{$this->version}/index";
        $body = [
            "collection_name" => $collectionName,
            "field_name" => $fieldName,
            "extra_params" => $extraParams
        ];

        return $this->sendRequest("POST", $path, $body);
    }

    protected function sendRequest($method, $path, $body = [])
    {
        $options = [
            "json" => $body
        ];

        try {
            $response = $this->client->request($method, $path, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $errorBody = $response->getBody()->getContents();
            throw new \Exception("Milvus API error: {$errorBody}");
        }
    }
}
