<?php

use PHPUnit\Framework\TestCase;
use EnricoStahn\JsonAssert\Assert as JsonAssert;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

abstract class BaseTest extends TestCase
{

    use JsonAssert;

    //todo указать токен тестового пользователя и хост
    private const TOKEN = '';
    private $host = 'http://127.0.0.1:8000';
    private static $client;
    private $httpMethod = 'GET';
    private $httpPath;
    private $queryParams;
    private $paramsType = 'query';
    private $headers = [
        'token' => self::TOKEN
    ];

    public function getHttpClient(): CurlHttpClient
    {
        if (null === self::$client) {
            self::$client = new CurlHttpClient();
        }

        return self::$client;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    public function getHttpMethod(): string
    {
        return mb_strtoupper($this->httpMethod);
    }

    public function setHttpMethod(string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): void
    {
        $this->host = $host;
    }

    public function getHttpPath(): string
    {
        return $this->httpPath;
    }

    public function setHttpPath(string $httpPath): void
    {
        $this->httpPath = $httpPath;
    }

    public function getUrl(): string
    {
        return $this->getHost() . $this->getHttpPath();
    }

    public function getParamsType(): string
    {
        return $this->paramsType;
    }

    public function setParamsType(string $paramsType): void
    {
        $this->paramsType = $paramsType;
    }

    public function getQueryParams(): ?array
    {
        return $this->queryParams;
    }

    public function setQueryParams(array $queryParams): void
    {
        $this->queryParams = $queryParams;
    }

    public function getScheme(string $schema): string
    {
        $file = __DIR__ . '\\' . $schema;
        if (!file_exists($file)) {
            throw new Exception('Json-схема не найдена.');
        }

        return $file;
    }

    /**
     * @return array
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getResponse(): array
    {
        return json_decode(
            $this
                ->getHttpClient()
                ->request(
                    $this->httpMethod,
                    $this->getUrl(),
                    [
                        'headers' => $this->getHeaders(),
                        $this->getParamsType() => $this->getQueryParams()
                    ]
                )
                ->getContent(),
            true
        );
    }

}