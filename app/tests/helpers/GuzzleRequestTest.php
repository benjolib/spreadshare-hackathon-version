<?php

namespace DS\Tests\helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GuzzleRequestTest
{
    private $testCase;
    private $container;
    private $history;
    private $mock;

    public function __construct(TestCase $testCase)
    {
        $this->testCase = $testCase;
        $this->container = [];
        $this->history = Middleware::history($this->container);
    }

    public function expectResponse(Response $response){
        $this->mock = new MockHandler([
            $response
        ]);
        $handler = HandlerStack::create($this->mock);
        $handler->push($this->history);
        return new Client(['handler' => $handler]);
    }

    public function assertMethod($methodName){
        foreach ($this->container as $transaction) {
            $request = $transaction['request'];
            $this->testCase->assertEquals($methodName, $request->getMethod());
        }
        return $this;
    }

    public function assertUrl(String $schema, String $host, String $path){
        foreach ($this->container as $transaction) {
            $request = $transaction['request'];
            $uri = $request->getUri();

            $this->testCase->assertEquals($schema, $uri->getScheme());
            $this->testCase->assertEquals($host, $uri->getHost());
            $this->testCase->assertEquals($path, $uri->getPath());
        }
        return $this;
    }

    public function assertErrorDisabled(){
        foreach ($this->container as $transaction) {
            $this->testCase->assertFalse($transaction['options']['http_errors']);
        }
        return $this;
    }

    public function assertHeader(String $key, String $value){
        foreach ($this->container as $transaction) {
            $request = $transaction['request'];
            $headers = $request->getHeaders();
            $this->testCase->assertEquals($value, $headers[$key][0]);
        }
        return $this;
    }

    public function assertBody(String $body){
        foreach ($this->container as $transaction) {
            $request = $transaction['request'];
            $this->testCase->assertEquals($body, $request->getBody()->__toString());
        }
        return $this;
    }

}