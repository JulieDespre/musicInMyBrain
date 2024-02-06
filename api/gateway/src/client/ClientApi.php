<?php

namespace geoquizz\gate\client;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

class ClientApi
{

    protected Client $client;

    public function __construct(array $config = [])
    {
        $this->client = new Client($config);
    }

    public function get($url, $data = [], $headers = [])
    {
        try {
            $options = [
                'json' => $data,
                'headers' => $headers,
            ];

            if (!empty($data)) {
                $url .= '?' . http_build_query($data);
            }

            $response = $this->client->get($url, $options);
            $jsonContents = $response->getBody()->getContents();

            $responseData = json_decode($jsonContents, true);

            return json_encode($responseData, JSON_PRETTY_PRINT);

        } catch (GuzzleException | RequestException $e) {
            return $e;
        }
    }


    public function post($url, $data = [], $headers = [], $form = [])
    {
        try {
            $options = [
                'form_params' => $data,
                'headers' => $headers,
            ];

            $response = $this->client->post($url, $options);

            return $response->getBody()->getContents();

        } catch (GuzzleException|RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                return $response->getBody()->getContents();
            } else {
                echo "Erreur de communication : " . $e->getMessage();
            }
        }
    }

    public function patch($url, $data = [], $headers = [])
    {
        try {
            // Créez un tableau d'options pour la requête PATCH
            $options = [
                'json'    => $data,
                'headers' => $headers,
            ];

            $response = $this->client->patch($url, $options);

            return $response->getBody()->getContents();
        } catch (GuzzleException | RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $statusCode = $response->getStatusCode();
                return $response->getBody()->getContents();
            } else {
                return "Erreur de communication : " . $e->getMessage();
            }
        }
    }


}