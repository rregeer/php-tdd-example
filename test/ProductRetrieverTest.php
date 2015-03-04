<?php

namespace TDD\Test;

use TDD;

class ProductRetrieverTest extends \PHPUnit_Framework_TestCase {

    public function testRetrieverProductHappyPath() {
        $clientStub = $this->getMockBuilder('\Elasticsearch\Client')
            ->getMock();

        $clientStub->method('get')
            ->willReturn('2');

        $retriever = new TDD\ProductRetriever($clientStub);

        $result = $retriever->retrieveProduct("2");

        $this->assertEquals($result, "2");
    }
}