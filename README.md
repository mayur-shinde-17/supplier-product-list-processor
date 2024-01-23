# Supplier Product List Processor

This PHP script processes supplier product lists in various file formats and generates unique combinations along with counts. It adheres to OOP principles, incorporates DI (Dependency Injection), and follows SOLID principles. Additionally, it supports various file formats, and the code is executable from the terminal.

## Table of Contents

- [Requirements](#requirements)
- [Clone the Repository](#clone-the-repository)
- [Install Composer](#install-composer)
- [Installation](#installation)
- [Usage](#usage)
- [Command Line Arguments](#command-line-arguments)
- [Additional Notes](#additional-notes)
- [Running Tests](#running-tests)
- [Author](#author)

## Requirements

- PHP 7+
- Composer

## Clone the Repository

```bash
git clone https://github.com/your-username/supplier-product-processor.git
cd supplier-product-processor
```
# Install Composer

[Composer](https://getcomposer.org/) is a dependency manager for PHP. If you haven't installed [Composer](https://getcomposer.org/doc/00-intro.md), refer to the Composer Installation Guide for instructions.

# Installation

Install Dependencies:
```
composer install
```
# Usage

Run the `parser.php` script from the terminal with the following options:

```bash
php parser.php --file example_1.csv --unique-combinations=combination_count.csv --required=brand_name,model_name
```

# Command Line Arguments:
* `--file` : (Required) Path to the input CSV file.
* `--unique-combinations` : (Required) Output file path for unique combinations.
* `--required` : (Optional) Comma-separated list of required fields. Defaults to brand_name,model_name if not provided.