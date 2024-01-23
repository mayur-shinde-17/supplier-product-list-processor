<?php


namespace SupplierProductListProcessor\Storage;

use SupplierProductListProcessor\Model\Product;

/**
 * Class implementing an in-memory storage for products.
 *
 * This class extends AbstractStorage and stores products in an associative array.
 */
class InMemoryStorage extends AbstractStorage
{
    /**
     * Array to store products using their unique hash as the key.
     *
     * @var array
     */
    private $products = array();

    /**
     * Add a product to the in-memory storage.
     *
     * @param Product $product The product to be added.
     * @return void
     */
    public function addProduct(Product $product)
    {
        $hash = $product->getUniqueHash();
        $this->products[$hash] = $product;
    }

    /**
     * Increment the count of a product in the in-memory storage.
     *
     * @param string $hash The unique hash of the product.
     * @return void
     */
    public function increment($hash)
    {
        $this->products[$hash]->count++;
    }

    /**
     * Get all stored products from the in-memory storage.
     *
     * @param bool $dataOnly If true, returns only the data without additional information.
     * @return array Array of stored products.
     */
    public function getProducts(bool $dataOnly = false): array
    {
        $products = array_values($this->products);

        if (!$dataOnly) {
            return $products;
        }

        return array_map(
            function (Product $product) {
                return $product->getInsertableRow();
            },
            $products
        );
    }

    /**
     * Check if a product with the given ID exists in the in-memory storage.
     *
     * @param string $id The unique hash of the product.
     * @return bool True if the product exists, false otherwise.
     */
    public function productExists($id): bool
    {
        return array_key_exists($id, $this->products);
    }

    /**
     * Get a product by its ID from the in-memory storage.
     *
     * @param string $id The unique hash of the product.
     * @return Product|null The product with the specified ID, or null if not found.
     */
    public function getProduct($id): Product
    {
        if ($this->productExists($id)) {
            return $this->products[$id];
        }
        return null; // Product not found
    }
}
