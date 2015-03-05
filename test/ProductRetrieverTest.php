<?php

namespace TDD\Test;

use Elasticsearch;
use TDD;

class ProductRetrieverTest extends \PHPUnit_Framework_TestCase {

    private $clientStub;
    private $productRetriever;

    public function setUp(){
        $this->clientStub = $this->getMockBuilder('\Elasticsearch\Client')->getMock();
        $this->productRetriever = new TDD\ProductRetriever($this->clientStub);
    }

    public function testRetrieverProductHappyPath() {
        $result = array();
        $result['data'] = array();
        $result['data']['_source']['productId'] = 1;
        $result['data']['_source']['name'] = 'Apple Iphone';
        $result['data']['_source']['salesPrice'] = 500;

        $this->clientStub->method('get')
            ->willReturn($result);

        $product = $this->productRetriever->retrieveProduct(1);

        $this->assertEquals($product->getProductId(), 1);
        $this->assertEquals($product->getName(), 'Apple Iphone');
        $this->assertEquals($product->getSalesPrice(), 500);
    }

    public function testInvalidProductId() {
        try
        {
            $this->productRetriever->retrieveProduct('invalidId');
        }
        catch (\InvalidArgumentException $exception) {
            $this->assertInstanceOf('InvalidArgumentException', $exception);
            return;
        }

        $this->fail('Expected InvalidArgumentException has not been raised.');
    }

    public function testRaiseErrorIfProductNotFound() {
        $this->clientStub->method('get')
            ->will($this->throwException(new Elasticsearch\Common\Exceptions\Missing404Exception()));

        try
        {
            $this->productRetriever->retrieveProduct(1);
        }
        catch (TDD\Exceptions\NotFoundException $exception) {
            $this->assertInstanceOf('TDD\Exceptions\NotFoundException', $exception);
            return;
        }

        $this->fail('Expected NotFoundException has not been raised.');
    }
}