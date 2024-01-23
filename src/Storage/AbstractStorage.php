<?php



namespace SupplierProductListProcessor\Storage;

use SupplierProductListProcessor\Model\Product;

/**
 * Abstract class defining the interface for product storage.
 */
abstract class AbstractStorage
{
    /**
     * Add a product to the storage.
     *
     * @param Product $product The product to be added.
     * @return void
     */
    abstract public function addProduct(Product $product);

    /**
     * Get all stored products.
     *
     * @param bool $dataOnly If true, returns only the data without additional information.
     * @return array Array of stored products.
     */
    abstract public function getProducts(bool $dataOnly = false): array;

    /**
     * Check if a product with the given ID exists in the storage.
     *
     * @param int $id The ID of the product.
     * @return bool True if the product exists, false otherwise.
     */
    abstract public function productExists($id): bool;

    /**
     * Get a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return Product|null The product with the specified ID, or null if not found.
     */
    abstract public function getProduct($id): Product;
}
