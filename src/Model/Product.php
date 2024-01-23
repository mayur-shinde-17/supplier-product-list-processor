<?php

namespace SupplierProductListProcessor\Model;

/**
 * Class representing a product with various properties.
 */
class Product
{
    /**
     * Associative array to store properties of the product.
     *
     * @var array
     */
    private $properties = array();

    /**
     * Count property for tracking occurrences of the same product.
     *
     * @var int
     */
    public $count = 0;

    /**
     * Generate a unique hash for the product based on its properties.
     *
     * @return string
     */
    public function getUniqueHash()
    {
        return md5(implode(",", array_values($this->properties)));
    }

    /**
     * Set the properties of the product.
     *
     * @param array $properties Associative array of properties.
     * @return void
     */
    public function setProperties(array $properties)
    {
        foreach ($properties as $key => $value) {
            $this->properties[$key] = $value;
        }
    }

    /**
     * Get an array of the product's properties.
     *
     * @return array
     */
    public function getProperties(): array
    {
        return array_values($this->properties);
    }

    /**
     * Get an array suitable for insertion into a data store, including the count property.
     *
     * @return array
     */
    public function getInsertableRow()
    {
        return array_merge($this->getProperties(), array($this->count));
    }

    /**
     * Display the product's properties in a human-readable format.
     *
     * @return void
     */
    public function show()
    {
        foreach ($this->properties as $key => $value) {
            $key = ucwords(str_replace('_', ' ', $key));
            echo "$key : $value\n";
        }
        echo "\n";
    }
}
