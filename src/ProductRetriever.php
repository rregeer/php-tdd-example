<?php

namespace TDD;

use Elasticsearch;
use TDD;
use TDD\Exceptions;

class ProductRetriever {

    private $esClient;

    public function __construct(Elasticsearch\Client $esClient) {
        $this->setEsClient($esClient);
    }

    public function retrieveProduct($productId) {
        $client = $this->getEsClient();

        if (is_numeric($productId) === false) {
            throw new \InvalidArgumentException('ProductId must be a number');
        }

        $getParams = array();
        $getParams['index'] = 'products';
        $getParams['type']= 'product';
        $getParams['id'] = $productId;

        try {
            $esResult = $client->get($getParams);

            $product = new Product();
            $product->setProductId($esResult['data']['_source']['productId']);
            $product->setName($esResult['data']['_source']['name']);
            $product->setSalesPrice($esResult['data']['_source']['salesPrice']);

            return $product;
        }
        catch (Elasticsearch\Common\Exceptions\Missing404Exception $exception) {
          throw new Exceptions\NotFoundException('Product with id '.$productId.' is not found');
        }
        catch(\Exception $exception) {
            throw new Exceptions\UnexpectedResultException('Error in retrieving product: '.$exception->getMessage());
        }
    }

    private function setEsClient($value) {
        $this->esClient = $value;
    }

    private function getEsClient() {
        return $this->esClient;
    }
}