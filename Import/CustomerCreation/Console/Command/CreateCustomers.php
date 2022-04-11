<?php

namespace Import\CustomerCreation\Console\Command;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem;
use Magento\Framework\App\State;
use Magento\Framework\App\Area;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Import\CustomerCreation\Model\Customer;
use Magento\Framework\Filesystem\Io\File;

class CreateCustomers extends Command
{
    const PROFILE = 'profile';

    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Customer
     */
    private $customer;
    /**
     * @var State
     */
    private $state;
    /**
     * @var File
     */
    private $filesystemIo;

    /**
     * @param Filesystem $filesystem
     * @param File $filesystemIo
     * @param Customer $customer
     * @param State $state
     */
    public function __construct(
        Filesystem $filesystem,
        File $filesystemIo,
        Customer $customer,
        State $state
    ) {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->filesystemIo = $filesystemIo;
        $this->customer = $customer;
        $this->state = $state;
    }

    /**
     * @return void
     */
    public function configure(): void
    {
        $options = [
            new InputOption(
                self::PROFILE,
                null,
                InputOption::VALUE_REQUIRED,
                'PROFILE'
            )
        ];

        $this->setName('customer:importer')
             ->setDescription('Import CSV and JSON file')
             ->setDefinition($options)
             ->addArgument('import_path', InputArgument::REQUIRED, '');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output): ?int
    {
        try {
            $this->state->setAreaCode(Area::AREA_GLOBAL);
            $filename = $input->getArgument('import_path');
            $profile = $input->getOption(self::PROFILE);

            $file = $this->filesystemIo->getPathInfo($filename);
            $extension = $file['extension'];

            if (!($profile ==='csv' || $profile === 'json')) {
                 throw new LocalizedException(__('You can only import either csv or json'));
            }
            if ($profile !== $extension) {
                throw new LocalizedException(__('Profile not same as file extension'));
            }

            $rootDir = $this->filesystem->getDirectoryWrite(DirectoryList::ROOT);
            $originalPath = $rootDir->getAbsolutePath().$filename;

            $varDir = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
            $copyFileFullPath = $varDir->getAbsolutePath() .$filename;

            if ($this->filesystemIo->cp($originalPath, $copyFileFullPath) == false) {
                throw new FileSystemException(__('No such file found '.$filename));
            }

            $this->customer->fileProcessor($copyFileFullPath, $output, $extension);

        } catch (LocalizedException $e) {
            $msg = $e->getMessage();
            $output->writeln("<error>$msg</error>", OutputInterface::OUTPUT_NORMAL);
            return Cli::RETURN_FAILURE;
        }
        return Cli::RETURN_SUCCESS;
    }
}
