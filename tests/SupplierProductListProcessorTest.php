<?php

// tests/SupplierProductListProcessorTest.php

use PHPUnit\Framework\TestCase;
use SupplierProductListProcessor\Model\Product;
use SupplierProductListProcessor\Parser\CSVParser;
use SupplierProductListProcessor\Parser\FileParser;
use SupplierProductListProcessor\Service\DelimiterSeparatedFileHandler;
use SupplierProductListProcessor\Storage\InMemoryStorage;

class SupplierProductListProcessorTest extends TestCase
{
    public function testCSVParser()
    {
        $csvParser = new CSVParser(['brand_name', 'model_name'], new DelimiterSeparatedFileHandler());

        // Mocking file content for testing
        $fileContent = "brand_name,model_name\nApple,iPhone 12\nSamsung,Galaxy S21";
        $filePath = 'test.csv';
        file_put_contents($filePath, $fileContent);

        // Testing parse method
        $parsedData = $csvParser->parse($filePath);
        $expectedData = [
            ['brand_name' => 'Apple', 'model_name' => 'iPhone 12'],
            ['brand_name' => 'Samsung', 'model_name' => 'Galaxy S21'],
        ];

        $this->assertEquals($expectedData, $parsedData);

        // Cleaning up
        unlink($filePath);
    }

    public function testInMemoryStorage()
    {
        $storage = new InMemoryStorage();

        // Adding a product
        $product = new Product();
        $product->setProperties(['brand_name' => 'Apple', 'model_name' => 'iPhone 12']);
        $storage->addProduct($product);

        // Testing productExists method
        $this->assertTrue($storage->productExists($product->getUniqueHash()));

        // Testing getProduct method
        $retrievedProduct = $storage->getProduct($product->getUniqueHash());
        $this->assertInstanceOf(Product::class, $retrievedProduct);
        $this->assertEquals($product->getUniqueHash(), $retrievedProduct->getUniqueHash());

        // Testing getProducts method
        $products = $storage->getProducts(true);
        $this->assertCount(1, $products);
        $this->assertEquals($product->getInsertableRow(), $products[0]);

    }

    public function testFileParser()
    {
        $fileParser = new FileParser('example.csv', 'output.csv', ['brand_name', 'model_name']);
        $csvParserMock = $this->createMock(CSVParser::class);

        // Mocking the parse method of CSVParser
        $csvParserMock->method('parse')
            ->willReturn([
                ['brand_name' => 'Apple', 'model_name' => 'iPhone 12'],
                ['brand_name' => 'Samsung', 'model_name' => 'Galaxy S21'],
            ]);

        $fileParser->setParser($csvParserMock);

        // Cleaning up
        unlink('output.csv');
    }
}
