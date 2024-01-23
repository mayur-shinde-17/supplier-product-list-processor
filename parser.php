<?php

require 'vendor/autoload.php';

use SupplierProductListProcessor\Parser\FileParser;



/**
 * Main function for the Supplier Product List Processor.
 *
 * This function parses command line options, initializes a FileParser, and processes the specified file.
 */
function main()
{
    // Define long options for command line arguments
    $longopts  = array(
        "file:",                // Input file path
        "unique-combinations:", // Output file path for unique combinations
        "required::",           // Optional comma-separated list of required fields
    );

    // Parse command line options
    $options = getopt("", $longopts);

    // Set default required fields if not provided
    if (empty($options['required'])) {
        $options['required'] = array(
            'brand_name',
            'model_name',
        );
    } else {
        $options['required'] = array_map('trim', explode(",", $options['required']));
    }

    try {
        // Initialize FileParser with provided options
        $parser = new FileParser(
            $options['file'],
            $options['unique-combinations'],
            $options['required']
        );

        // Process the file
        $parser->process();
    } catch (Exception $e) {
        // Handle and display any exceptions
        echo $e->getMessage();
    }
}

// Execute the main function
main();
