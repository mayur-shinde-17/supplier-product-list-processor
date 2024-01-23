<?php

namespace SupplierProductListProcessor\Service;

/**
 * Class for handling delimiter-separated files.
 *
 * This class extends AbstractFileHandler and provides methods to read, write, and iterate over data in delimiter-separated files.
 */
class DelimiterSeparatedFileHandler extends AbstractFileHandler
{
    /**
     * The delimiter used in the file.
     *
     * @var string
     */
    protected $delimiter;

    /**
     * Constructor for the delimiter-separated file handler.
     *
     * @param string $delimiter The delimiter used in the file.
     */
    public function __construct(string $delimiter = ',')
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Set the delimiter used in the file.
     *
     * @param string $delimiter The delimiter to be set.
     */
    public function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;
    }

    /**
     * Get headers from a file (assumed to be in the first row).
     *
     * @param string $filename Path to the file.
     * @return array|false An array of headers or false if unable to open the file.
     */
    public function getHeaders($filename)
    {
        if (($handle = fopen($filename, 'r')) !== false) {
            $headers = fgetcsv($handle, 0, $this->delimiter);
            fclose($handle);
            return $headers;
        }

        return false;
    }

    /**
     * Read data from a file and return it as an array.
     *
     * @param string $filename Path to the file.
     * @return array|false An array of data or false if unable to open the file.
     */
    public function read($filename)
    {
        $data = [];

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, $this->delimiter)) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        } else {
            return false;
        }

        return $data;
    }

    /**
     * Write data to a file.
     *
     * @param string $filename Path to the file.
     * @param array $data Data to be written.
     * @return bool True if successful, false otherwise.
     */
    public function write($filename, $data)
    {
        if (($handle = fopen($filename, 'w')) !== false) {
            foreach ($data as $row) {
                fputcsv($handle, $row, $this->delimiter);
            }
            fclose($handle);
            return true;
        }

        return false;
    }

    /**
     * Iterate over data in a file and apply a callback function to each row.
     *
     * @param string $filename Path to the file.
     * @param callable $callback Callback function to apply to each row.
     * @param bool $hasHeader Flag indicating whether the file has a header row.
     * @return array|false An array of results or false if unable to open the file.
     */
    public function iterate($filename, $callback, $hasHeader = true)
    {
        $result = [];
        $headersSkipped = false;

        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, $this->delimiter)) !== false) {
                if ($hasHeader && !$headersSkipped) {
                    $headersSkipped = true;
                    continue;
                }
                $result[] = $callback($row);
            }
            fclose($handle);
        } else {
            return false;
        }

        return $result;
    }
}
