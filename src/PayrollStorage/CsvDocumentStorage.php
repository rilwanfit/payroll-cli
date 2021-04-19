<?php

declare(strict_types=1);

namespace App\PayrollStorage;

use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use Psr\Log\LoggerInterface;

class CsvDocumentStorage implements DocumentStorage
{
    private string $outputFolder;

    private Writer $writer;

    private LoggerInterface $logger;

    public function __construct(string $outputFolder, LoggerInterface $logger)
    {
        $this->outputFolder = $outputFolder;
        $this->logger = $logger;
    }

    public function create(string $outputFile): void
    {
        $this->writer = Writer::createFromPath(sprintf('%s/%s.csv', $this->outputFolder, $outputFile), 'w');
    }

    public function append(array $record): int
    {
        try {
            return $this->writer->insertOne($record);
        } catch (CannotInsertRecord $exception) {
            $this->logger->error($exception->getMessage(), [
                'record' => $record,
            ]);
        }
    }
}
