<?php

declare(strict_types=1);

namespace PhpAT\App;

use PhpAT\App\Event\Listener\FatalErrorListener;
use PhpAT\App\Event\Listener\SuiteEndListener;
use PhpAT\App\Event\Listener\SuiteStartListener;
use PhpAT\App\Event\Listener\WarningListener;
use PhpAT\Output\OutputInterface;
use PhpAT\Rule\Event\Listener\RuleValidationEndListener;
use PhpAT\Rule\Event\Listener\RuleValidationStartListener;
use PhpAT\Statement\Event\Listener\StatementNotValidListener;
use PhpAT\Statement\Event\Listener\StatementValidListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EventListenerProvider
{
    private $builder;
    /**
     * @var OutputInterface
     */
    private $output;

    public function __construct(ContainerBuilder $builder, OutputInterface $output)
    {
        $this->builder  = $builder;
        $this->output = $output;
    }

    public function register(): ContainerBuilder
    {
        $this->builder
            ->register(SuiteStartListener::class, SuiteStartListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(SuiteEndListener::class, SuiteEndListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(WarningListener::class, WarningListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(FatalErrorListener::class, FatalErrorListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(RuleValidationStartListener::class, RuleValidationStartListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(RuleValidationEndListener::class, RuleValidationEndListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(StatementValidListener::class, StatementValidListener::class)
            ->addArgument($this->output);

        $this->builder
            ->register(StatementNotValidListener::class, StatementNotValidListener::class)
            ->addArgument($this->output);

        return $this->builder;
    }
}
