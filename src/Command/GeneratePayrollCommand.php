<?php

declare(strict_types=1);

namespace App\Command;

use App\Exception\CouldNotDetermineRemainingMonths;
use App\Exception\CouldNotInsertPayroll;
use App\Payroll\Generator;
use App\Payroll\Payroll;
use App\PayrollStorage\DocumentStorage;
use Carbon\Carbon;
use Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GeneratePayrollCommand
{
    private InputInterface $input;

    private OutputInterface $output;

    private DocumentStorage $documentStorage;

    private Generator $payrollGenerator;

    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        DocumentStorage $documentStorage,
        Generator $payrollGenerator
    ) {
        $this->input = $input;
        $this->output = $output;
        $this->documentStorage = $documentStorage;
        $this->payrollGenerator = $payrollGenerator;
    }

    public function execute(): int
    {
        $outputFile = $this->input->getArgument('filename');

        $this->documentStorage->create($outputFile);

        $csvHeaders = ['Month', 'Salary Payday', 'Bonus Payday'];
        $this->documentStorage->append($csvHeaders);

        try {
            $payrolls = $this->payrollGenerator->generate(Carbon::now());

            /** @var Payroll $payroll */
            foreach ($payrolls as $payroll) {
                $this->documentStorage->append($payroll->toArray());
            }
        } catch (CouldNotInsertPayroll | Exception $exception) {
            $this->output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

            return 1;
        }

        $this->output->writeln('<info>Successfully calculated paydays All results in <comment>output/'.$outputFile.'</comment></info>');

        return 0;
    }
}
