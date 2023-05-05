<?php

namespace DevelopersSavyour\Milvus;

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
        $this->host = config('milvus.host');
        $this->port = config('milvus.port');
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

    /**
     * @param $collection
     * @param $outputFields
     * @param $vectors
     * @param $topk
     * @param $annsField
     * @param $metricType
     * @return void
     */
    function searchVector($collection, $outputFields, $vectors, $topk = 100, $annsField = "embedding", $metricType="IP")
    {
        $path = "{$this->version}/search";
        $body = [
            "collection_name" => $collection,
            "output_fields" => $outputFields,
            "dsl_type" => 1,
            "search_params" => [
                ["key"  => "topk", "value"=> (string)$topk],
                ["key"  => "anns_field", "value"=> $annsField],
                ["key"  => "params", "value" => json_encode(["nprobe" => 4])],
                ["key"  => "metric_type", "value"=> $metricType],
                ["key"  => "round_decimal", "value"=> "-1"],
            ],
            "vectors"=> $vectors,
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
