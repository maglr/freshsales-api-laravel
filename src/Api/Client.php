<?php


namespace Gentor\Freshsales\Api;

use DateTime;
use Exception;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client as GuzzleHttpClient;

/**
 * Class Client
 * @package Gentor\Freshsales\Api
 */
class Client
{
    /**
     * The current API call limits from last request.
     *
     * @var array
     */
    protected $apiCallLimits = [
        'limit' => 2000,
        'left' => 0,
        'made' => 0,
        'reset' => null,
    ];

    /**
     * If rate limit is enabled.
     *
     * @var bool
     */
    protected $rateLimitEnabled = false;

    /**
     * Request timestamp for every new call.
     * Used for rate limiting.
     *
     * @var int
     */
    protected $requestTimestamp;

    /**
     * @var GuzzleHttpClient
     */
    protected $client;

    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->client = new GuzzleHttpClient(
            [
                'base_uri' => "https://{$config['domain']}",
                'headers' => [
                    'Authorization' => "Token token=" . $config['api_key'],
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
            ]
        );

        $this->rateLimitEnabled = $config['enable_rate_limit'] ?? false;
    }

    /**
     * Set the rate limit to enabled.
     *
     * @return self
     */
    public function enableRateLimit(): self
    {
        $this->rateLimitEnabled = true;

        return $this;
    }

    /**
     * Set the rate limit to disabled.
     *
     * @return self
     */
    public function disableRateLimit(): self
    {
        $this->rateLimitEnabled = false;

        return $this;
    }

    /**
     * Determines if rate limit is enabled.
     *
     * @return bool
     */
    public function isRateLimitEnabled(): bool
    {
        return $this->rateLimitEnabled === true;
    }

    /**
     * Returns the current API call limits.
     *
     * @param string|null $key The key to grab (left, made, limit, etc).
     *
     * @return mixed Either whole array of call data or single key.
     * @throws Exception When attempting to grab a key that doesn't exist.
     */
    public function getApiCallLimits(string $key = null)
    {
        if ($key) {
            $keys = array_keys($this->apiCallLimits);
            if (!in_array($key, $keys)) {
                // No key like that in array
                throw new Exception('Invalid API call limit key. Valid keys are: ' . implode(', ', $keys));
            }

            // Return the key value requested
            return $this->apiCallLimits[$key];
        }

        // Return all the values
        return $this->apiCallLimits;
    }

    /**
     * Handles rate limit (if enabled).
     *
     * @return void
     * @throws Exception
     */
    protected function handleRateLimit(): void
    {
        if (!$this->isRateLimitEnabled() || !$this->requestTimestamp) {
            return;
        }

        /** @var DateTime $limitReset */
        $limitReset = $this->getApiCallLimits('reset');
        if (!$limitReset) {
            return;
        }

        $limitLeft = $this->getApiCallLimits('left');
        $secondsLeft = $limitReset->getTimestamp() - time();
        $rateLimitCycle = round(($secondsLeft / $limitLeft) * 1000);

        // Calculate in milliseconds the duration the API call took
        $duration = round(microtime(true) - $this->requestTimestamp, 3) * 1000;
        $waitTime = $rateLimitCycle - $duration;

        if ($waitTime > 0) {
            // Do the sleep for X microseconds (convert from milliseconds)
            usleep($waitTime * 1000);
        }
    }

    /**
     * Updates the request time.
     *
     * @return void
     */
    protected function updateRequestTime()
    {
        $this->requestTimestamp = microtime(true);
    }

    /**
     * Updates the REST API call limits from Freshsales headers.
     *
     * @param ResponseInterface $response The response from the request.
     *
     * @return void
     */
    protected function updateApiCallLimits(ResponseInterface $response): void
    {
        // Grab the API call limit header returned from Freshsales
        $callLimitRemaining = $response->getHeader('x-RateLimit-Remaining')[0];
        $callLimitTotal = $response->getHeader('x-RateLimit-Limit')[0];
        $callLimitReset = $response->getHeader('x-RateLimit-Reset')[0];
        if (!$callLimitRemaining) {
            return;
        }

        $this->apiCallLimits = [
            'limit' => (int)$callLimitTotal,
            'left' => (int)$callLimitRemaining,
            'made' => (int)$callLimitTotal - $callLimitRemaining,
            'reset' => DateTime::createFromFormat('dmyHis', $callLimitReset),
        ];
    }

    /**
     * @param string $method
     * @param string $path
     * @param array|null $params
     * @param array $headers
     * @return mixed
     * @throws Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request(string $method, string $path, array $params = null, array $headers = [])
    {
        // Check the rate limit before firing the request
        $this->handleRateLimit();

        // Update the timestamp of the request
        $this->updateRequestTime();

        $uri = $this->getBaseUri()->withPath($path);

        // Build the request parameters for Guzzle
        $options = [];
        if ($params !== null) {
            $options[strtoupper($method) === 'GET' ? 'query' : 'json'] = $params;
        }

        // Add custom headers
        if (!empty($headers)) {
            $options['headers'] = $headers;
        }

        /** @var ResponseInterface $response */
        try {
            $response = $this->client->request($method, $uri, $options);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $this->updateApiCallLimits($e->getResponse());
                throw $e;
            }
        }

        return $this->response($response);
    }

    /**
     * @return \GuzzleHttp\Psr7\Uri
     */
    public function getBaseUri()
    {
        return new Uri($this->client->getConfig('base_uri'));
    }

    public function response(ResponseInterface $response)
    {
        $this->updateApiCallLimits($response);
//        dd($this->apiCallLimits);
        return json_decode($response->getBody());
    }
}