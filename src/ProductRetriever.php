<?php

namespace TDD;

use Elasticsearch;

class ProductRetriever {

    private $esClient;

    public function __construct(Elasticsearch\Client $esClient) {
        $this->setEsClient($esClient);
    }

    public function retrieveProduct($productId) {
        $client = $this->getEsClient();

        if (is_numeric($productId) === false) {
            throw new InvalidArgumentException("ProductId must be a number");
        }

        $getParams = array();
        $getParams['index'] = 'products';
        $getParams['type']= 'product';
        $getParams['id'] = $productId;

        try {
            $esResult = $client->get($getParams);

            $document = json_decode($esResult);

            $product = new Product();

           // $product->setProductId($document->_source->productId);
          //  $product->setName($document->_source->name);
           // $product->setSalesPrice($document->_source->salesPrice);

            return $esResult;
        }
        catch (Exception $error) {
            if ($error instanceof Elasticsearch\Common\Exceptions\Missing404Exception === true) {
                throw new NotFoundExeption('Product with id $productId is not found');
            }

            throw new UnexpectedResultException();
        }
    }

    private function setEsClient($value) {
        $this->esClient = $value;
    }

    private function getEsClient() {
        return $this->esClient;
    }

}