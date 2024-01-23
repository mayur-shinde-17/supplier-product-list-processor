<?php

namespace SupplierProductListProcessor\Parser;

use SupplierProductListProcessor\Service\DelimiterSeparatedFileHandler;

/**
 * Class for parsing CSV files using a specified file handler.
 *
 * This class extends DelimiterSeparatedParser and specializes it for CSV files.
 */
class CSVParser extends DelimiterSeparatedParser
{
    /**
     * Constructor for the CSV parser.
     *
     * @param array $requiredFields Array of required fields.
     * @param DelimiterSeparatedFileHandler $fileHandler Instance of the CSV file handler.
     */
    public function __construct(array $requiredFields, DelimiterSeparatedFileHandler $fileHandler)
    {
        // CSV files typically use a comma as the delimiter
        $delimiter = ',';
        parent::__construct($requiredFields, $fileHandler, $delimiter);
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $filePath): array
    {
        // Additional logic specific to CSV parsing can be added here if needed
        // For now, it uses the parent class's parse method

        return parent::parse($filePath);
    }
}
