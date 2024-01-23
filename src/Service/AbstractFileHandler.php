<?php

namespace SupplierProductListProcessor\Service;
/**
 * Abstract class defining the interface for file handling operations.
 */
abstract class AbstractFileHandler
{
    /**
     * Get headers from a file (assumed to be in the first row).
     *
     * @param string $filename Path to the file.
     * @return array|false An array of headers or false if unable to open the file.
     */
    abstract public function getHeaders($filename);

    /**
     * Read data from a file and return it as an array.
     *
     * @param string $filename Path to the file.
     * @return array|false An array of data or false if unable to open the file.
     */
    abstract public function read($filename);

    /**
     * Write data to a file.
     *
     * @param string $filename Path to the file.
     * @param array $data Data to be written.
     * @return bool True if successful, false otherwise.
     */
    abstract public function write($filename, $data);

    /**
     * Iterate over data in a file and apply a callback function to each row.
     *
     * @param string $filename Path to the file.
     * @param callable $callback Callback function to apply to each row.
     * @return array|false An array of results or false if unable to open the file.
     */
    abstract public function iterate($filename, $callback);
}
