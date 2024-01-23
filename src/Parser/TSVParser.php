<?php

namespace SupplierProductListProcessor\Parser;

use SupplierProductListProcessor\Service\DelimiterSeparatedFileHandler;

/**
 * Class for parsing TSV (Tab-Separated Values) files using a specified file handler.
 *
 * This class extends DelimiterSeparatedParser and specializes it for TSV files.
 */
class TSVParser extends DelimiterSeparatedParser
{
    /**
     * Constructor for the TSV parser.
     *
     * @param array $requiredFields Array of required fields.
     * @param DelimiterSeparatedFileHandler $fileHandler Instance of the TSV file handler.
     */
    public function __construct(array $requiredFields, DelimiterSeparatedFileHandler $fileHandler)
    {
        // TSV files typically use a tab character as the delimiter
        $delimiter = "\t";

        parent::__construct($requiredFields, $fileHandler, $delimiter);
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $filePath): array
    {
        // Additional logic specific to TSV parsing can be added here if needed
        // For now, it uses the parent class's parse method

        return parent::parse($filePath);
    }
}
