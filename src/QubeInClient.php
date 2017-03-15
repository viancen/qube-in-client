<?php
use GuzzleHttp\Client;

require_once 'QubeInClient/Exceptions.php';

class QubeInClient
{
    //private client (Guzzle)
    private $client;

    //API key, get one at qube-in.com
    public $apiKey;
    public $userKey = null;
    public $apiSecret;

    //What part of QubeIn is used
    public $settings = [];

    //Root url of API
    public $root;

    //not used yet
    public $debug = false;

    //Todo: map all errors into comprehensible messages
    public static $error_map = [
        "Invalid_Key" => "QubeIn_Invalid_Key",
    ];

    /**
     * QubeInClient constructor.
     *
     * @param null $apiKey
     * @param null $apiSecret
     * @param null $root
     * @param array $options
     */
    public function __construct($apikey = '', $apiSecret = '', $root = null, $options = [])
    {
        if (!$apikey) throw new QubeIn_Error('You must provide a QubeIn API key');
        if (!$apiSecret) throw new QubeIn_Error('You must provide a QubeIn API secret');
        if (!$root) {
            $root = 'https://api.qube-in.com/v1';
        }

        $this->apiKey = $apikey; //sha1($apikey . $apiSecret);
        $this->root = $root;
        $this->apiSecret = $apiSecret;

        if (!empty($options)) {
            if (!empty($options['settings'])) {
                $this->settings = $options['settings'];
            }
        }

        $this->client = new Client();
        $this->root = rtrim($this->root, '/') . '/';

    }

    public function getSettings()
    {
        return $this->settings;
    }

    //set a access token
    public function setAccessToken()
    {
        $token = $this->get('auth/request_token');
        $this->apiKey = sha1($token['data']['access_token'] . $this->apiSecret);
    }

    /**
     * Post request to QubeIn.io
     *
     * @param $endpoint
     * @param array $params
     * @return mixed
     */
    public function post($endpoint, $params = [])
    {
        try {
            $response = $this->client->request('POST', $this->root . $endpoint, [
                'headers' => [
                    'X-API-KEY' => $this->apiKey,
                    'X-response-type' => 'json',
                    'Content-Type' => 'application/json',
                ],
                'decode_content' => true,
                'verify' => $this->debug ? false : true,
                'body' => json_encode($params)
            ]);

        } catch (QubeIn_HttpError $error) {
            return [
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        }

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * Post request to QubeIn.io
     *
     * @param $endpoint
     * @return mixed
     */
    public function get($endpoint, $params = [])
    {

        //dd($this->apiKey);
        try {
            $response = $this->client->request('GET', $this->root . $endpoint, [
                'headers' => [
                    'X-API-KEY' => $this->apiKey,
                    'X-response-type' => 'json',
                    'Content-Type' => 'application/json',
                ],
                'decode_content' => true,
                'verify' => $this->debug ? false : true,
                'body' => json_encode($params)
            ]);

        } catch (QubeIn_HttpError $error) {
            return [
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        }

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * Put request to QubeIn.io
     *
     * @param $endpoint
     * @return mixed
     */
    public function put($endpoint, $params)
    {

        try {
            $response = $this->client->request('PUT', $this->root . $endpoint, [
                'headers' => [
                    'X-API-KEY' => $this->apiKey,
                    'X-response-type' => 'json',
                    'Content-Type' => 'application/json',
                ],
                'decode_content' => true,
                'verify' => $this->debug ? false : true,
                'body' => json_encode($params)
            ]);

        } catch (QubeIn_HttpError $error) {
            return [
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        }

        $body = json_decode($response->getBody(), true);
        return $body;
    }

    /**
     * Put request to QubeIn.io
     *
     * @param $endpoint
     * @return mixed
     */
    public function del($endpoint)
    {

        try {
            $response = $this->client->request('DELETE', $this->root . $endpoint, [
                'headers' => [
                    'X-API-KEY' => $this->apiKey,
                    'X-response-type' => 'json',
                    'Content-Type' => 'application/json',
                ],
                'decode_content' => true,
                'verify' => $this->debug ? false : true
            ]);

        } catch (QubeIn_HttpError $error) {
            return [
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        }

        $body = json_decode($response->getBody(), true);
        return $body;
    }

}