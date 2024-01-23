<?php

namespace SupplierProductListProcessor\Parser;

use Exception;
use SupplierProductListProcessor\Service\DelimiterSeparatedFileHandler;

/**
 * Class for processing files using a specified parser strategy.
 */
class FileParser
{
    /**
     * The parser strategy to be used for file processing.
     *
     * @var AbstractParser
     */
    private AbstractParser $parser;

    /**
     * Path to the input file.
     *
     * @var string
     */
    private $filePath;

    /**
     * Path to the output file.
     *
     * @var string
     */
    private $outputFilePath;

    /**
     * Array of required fields that must be present in the parsed data.
     *
     * @var array
     */
    private array $requiredFields;

    /**
     * Constructor for the file parser.
     *
     * @param string $filePath Path to the input file.
     * @param string $outputFilePath Path to the output file.
     * @param array $requiredFields Array of required fields.
     */
    public function __construct(string $filePath, string $outputFilePath, array $requiredFields)
    {
        $this->filePath = $filePath;
        $this->outputFilePath = $outputFilePath;
        $this->requiredFields = $requiredFields;
    }

    /**
     * Set the parser strategy to be used for file processing.
     *
     * @param AbstractParser $parser The parser strategy.
     */
    public function setParser(AbstractParser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Get the parser strategy based on the file extension.
     *
     * @param string $extension File extension.
     * @return AbstractParser The parser strategy.
     * @throws Exception If the file format is not supported.
     */
    public function getParserStrategyFromExtension(string $extension): AbstractParser
    {
        switch ($extension) {
            case 'csv':
                return new CSVParser($this->requiredFields, new DelimiterSeparatedFileHandler());
            case 'tsv':
                return new TSVParser($this->requiredFields, new DelimiterSeparatedFileHandler());
            default:
                throw new Exception("This file format is not supported yet.");
        }
    }

    /**
     * Get the file extension of the input file.
     *
     * @return string File extension.
     */
    public function getFileExtension(): string
    {
        $extension = explode('.', $this->filePath);
        return end($extension);
    }

    /**
     * Process the file using the specified parser strategy.
     *
     * @throws Exception If the input file is not found or required fields are not present.
     */
    public function process()
    {
        $strategy = $this->getParserStrategyFromExtension($this->getFileExtension());

        if (!file_exists($this->filePath)) {
            throw new Exception("'$this->filePath' file not found.");
        }

        $this->setParser($strategy);

        if (!$this->hasRequiredFields()) {
            throw new Exception("Fields " . implode(', ', $this->requiredFields) . ' not found');
        }

        list($results, $headers) = $this->parseFile();
        $this->writeResults($headers, $results);
    }

    /**
     * Check if the input file has the required fields.
     *
     * @return bool True if all required fields are present, false otherwise.
     */
    public function hasRequiredFields(): bool
    {
        return $this->parser->hasRequiredFields($this->filePath, $this->requiredFields);
    }

    /**
     * Parse the input file and return the result.
     *
     * @return array Parsed data including products and headers.
     */
    public function parseFile(): array
    {
        return $this->parser->parse($this->filePath);
    }

    /**
     * Write the parsed results to the output file.
     *
     * @param array $headers Headers for the output file.
     * @param array $results Parsed data to be written.
     */
    public function writeResults(array $headers, array $results)
    {
        $outputFileHandler = new DelimiterSeparatedFileHandler();
        $outputFileHandler->write($this->outputFilePath, array_merge(array($headers), $results));
    }
}
