<?php

namespace SupplierProductListProcessor\Parser;

use SupplierProductListProcessor\Service\DelimiterSeparatedFileHandler;
use SupplierProductListProcessor\Storage\InMemoryStorage;

/**
 * Class for parsing delimiter-separated files using a specified file handler.
 */
class DelimiterSeparatedParser extends AbstractParser
{
    /**
     * The delimiter used in the file.
     *
     * @var string
     */
    protected $delimiter;

    /**
     * Constructor for the delimiter-separated parser.
     *
     * @param array $requiredFields Array of required fields.
     * @param DelimiterSeparatedFileHandler $fileHandler Instance of the delimiter-separated file handler.
     * @param string $delimiter The delimiter used in the file.
     */
    public function __construct(array $requiredFields, DelimiterSeparatedFileHandler $fileHandler, string $delimiter)
    {
        parent::__construct($requiredFields, $fileHandler);
        $this->delimiter = $delimiter;
        $fileHandler->setDelimiter($delimiter);
    }

    /**
     * Check if the required fields are present in the delimiter-separated file.
     *
     * @param string $filePath Path to the file to be checked.
     * @return bool True if all required fields are present, false otherwise.
     */
    public function hasRequiredFields(string $filePath): bool
    {
        $headers = $this->fileHandler->getHeaders($filePath);
        return empty(array_diff($this->requiredFields, $headers));
    }

    /**
     * Parse the delimiter-separated file and return the result.
     *
     * @param string $filePath Path to the file to be parsed.
     * @return array Parsed data including products and headers.
     */
    public function parse(string $filePath): array
    {
        $headers = $this->fileHandler->getHeaders($filePath);
        $storage = new InMemoryStorage();

        // Iterate through the file rows and increment product counts
        $this->fileHandler->iterate($filePath, function ($row) use ($headers, $storage) {
            $row = array_combine($headers, $row);
            return $this->incrementProductCount($row, $headers, $storage);
        });

        // Add 'count' to headers for the final result
        array_push($headers, 'count');

        // Return the parsed data including products and headers
        return array($storage->getProducts(true), $headers);
    }
}
