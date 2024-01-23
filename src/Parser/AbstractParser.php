<?php

namespace SupplierProductListProcessor\Parser;

use SupplierProductListProcessor\Model\Product;
use SupplierProductListProcessor\Service\AbstractFileHandler;

/**
 * Abstract class providing a foundation for parsers.
 */
abstract class AbstractParser
{
    /**
     * Array of required fields that must be present in the parsed data.
     *
     * @var array
     */
    protected array $requiredFields;

    /**
     * File handler responsible for reading and processing the input file.
     *
     * @var AbstractFileHandler
     */
    protected AbstractFileHandler $fileHandler;

    /**
     * Constructor for the abstract parser.
     *
     * @param array $requiredFields Array of required fields.
     * @param AbstractFileHandler $fileHandler Instance of the file handler.
     */
    public function __construct(array $requiredFields, AbstractFileHandler $fileHandler)
    {
        $this->requiredFields = $requiredFields;
        $this->fileHandler = $fileHandler;
    }

    /**
     * Abstract method to be implemented by concrete parsers for parsing a file.
     *
     * @param string $filePath Path to the file to be parsed.
     * @return array Parsed data.
     */
    abstract public function parse(string $filePath): array;

    /**
     * Abstract method to check if the required fields are present in the file.
     *
     * @param string $filePath Path to the file to be checked.
     * @return bool True if all required fields are present, false otherwise.
     */
    abstract public function hasRequiredFields(string $filePath): bool;

    /**
     * Increment the count of a product based on the provided row data.
     *
     * @param array $row Row data from the parsed file.
     * @param array $headers Headers corresponding to the row data.
     * @param AbstractStorage $storage Storage for products and counts.
     * @return Product The product after incrementing the count.
     */
    public function incrementProductCount($row, $headers, $storage): Product
    {

        // Create a new Product instance and set its properties
        $product = new Product();
        $product->setProperties($row);

        // Generate a unique hash for the product
        $hash = $product->getUniqueHash();

        // Check if the product already exists in the storage
        if ($storage->productExists($hash)) {
            $product = $storage->getProduct($hash);
        } else {
            // If not, add the product to the storage
            $storage->addProduct($product);
        }

        // Increment the count for the product in the storage
        $storage->increment($hash);

        // Display the product's properties
        $product->show();

        // Return the updated product
        return $product;
    }
}
