<?php

namespace Opengento\SampleAiData\Console\Command;

use Magento\Framework\Console\Cli;
use Opengento\SampleAiData\Service\Generator\CategoryGenerator;
use Opengento\SampleAiData\Service\Generator\ProductGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SampleAiCategoryDataDeployCommand extends Command
{
    public const COMMAND = 'sampleaidata:category';
    public const KEYWORD = 'keyword';
    public const MAX_CATEGORIES = 'max-categories';
    private const DESCRIPTION_LENGTH = 'description-length';

    public function __construct(
        private readonly CategoryGenerator $productGenerator
    )
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName(self::COMMAND)
            ->setDescription('Deploy sample data generated by AI for composer-based Magento installations')
            ->setDefinition([
                    new InputArgument(
                        self::KEYWORD,
                        InputArgument::REQUIRED,
                        'Industry domain for which to generate sample data'
                    ),
                    new InputArgument(
                        self::MAX_CATEGORIES,
                        InputArgument::REQUIRED,
                        'Number of products to generate'
                    ),
                    new InputOption(
                        self::DESCRIPTION_LENGTH,
                        null,
                        InputOption::VALUE_OPTIONAL,
                        'Maximum length of product description',
                        25
                    )
            ]
        );
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $prompt = $input->getArgument(self::KEYWORD);
        $maxProducts = $input->getArgument(self::MAX_CATEGORIES);
        $descriptionLength = $input->getOption(self::DESCRIPTION_LENGTH);
        $this->productGenerator->generate($prompt, $maxProducts, $descriptionLength);
        return Cli::RETURN_SUCCESS;
    }
}
