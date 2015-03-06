# php-tdd-example
This example contains a product retriever class to retriever a product from a data storage. In the example elasticsearch is used as the as the data storage.

There are a couple of simple test-cases that covers:
- If a product is not found (Elasticsearch returns 404).
- The storage engine is not available.
- The given id of the product is not a valid id.
- Happy path example.

There's no real data in elasticsearch. The client and data is mocked to create the tests.

The product entity contains of the following fields:
- productId (int)
- name (string)
- salesPrice (float)

## Installation
The install and run the test of the code we need a couple of tools:
- Php5
- Php5-curl
- Composer
- Phpunit
- git

### Installation on Linux
Use the package manager of your OS: yum or apt-get for example. In this example apt-get is used.
Install php5 and php5-curl.
```bash
sudo apt-get update
sudo apt-get install php5
sudo apt-get install php5
sudo apt-get install php5-curl
```
Install the php package manager composer. For easy use install it globally.
```bash
sudo curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin
sudo ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
```
Install the phpunit globally so you can use it from the command line.
```bash
sudo composer global require "phpunit/phpunit=4.1.*"
sudo composer global require "phpunit/php-invoker=~1.1."
```
To retrieve the code we need git.
```bash
sudo apt-get install git
```
Now you can clone the git repository, checkout the code and install the packages.
```bash
git clone https://github.com/rregeer/php-tdd-example
cd php-tdd-example
sudo composer install
```
The tests can be run using phpunit on the command line
```bash
cd php-tdd-example
phpunit test/
```
## Exercise 1: finding bugs.
All the tests are running, but is everything ok?. There can be still bugs in the code we haven't seen and covered.
Take a look at the tests and the code and see if everything is covered and the code is correct.
If you found the bug(s). Correct the code and create a test for it so the bug will never happen again.
## Exercise 2: extending result and refactor code.
Add salesprice and product information to the product.
If there´s no salesprice then the salesprice is null.
If there´s no product information then the product information is null.
All the data is in the "product" index the type is "product".

Product:
- productId (int)
- productInformation (object)
- salesPrice (object)

ProductInformation:
- shortName (string)
- fullName (string)
- description (string)

SalesPrice:
- priceExcludingVat (float)
- priceIncludingVat (float)

Example of the elastic-search response:
```js
_source: {
  id: 123456,
  productInformation: {
    shortName: "Apple iPhone 6 GB",
    fullName: "Apple Iphone 6 special edition",
    description: "The Apple Iphone 6 special edition."
    },
    salesPrice: {
      priceExcludingVat: 660.33058,
      priceIncludingVat: 799
    }
  }
}
```
## Exercise 3: refactor code and add new functionality.
Add brand information to the product.
If there´s no brand information then the brand is null.
The brand is in a separate elastic-search index "brand". The type is "brand".
The brand can also be retrieved separately from the product.

Brand:
- brandId (int)
- name (string)

Product:
- brand (object)
- productId (int)
- productInformation (object)
- salesPrice (object)

Example of the product elastic-search response:
```js
_source: {
  id: 123456,
  brandId: 32,
  productInformation: {
    shortName: "Apple iPhone 6 GB",
    fullName: "Apple Iphone 6 special edition",
    description: "The Apple Iphone 6 special edition."
    },
    salesPrice: {
      priceExcludingVat: 660.33058,
      priceIncludingVat: 799
    }
  }
}
```
Example of the brand elastic-search response:
```js
_source: {
  id: 12,
  name: "Apple"
}
```
