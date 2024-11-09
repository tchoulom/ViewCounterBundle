<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@gmail.com>
 *
 * (c) Ernest TCHOULOM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\Command;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Tchoulom\ViewCounterBundle\ETL\StatsConverter;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;
use Tchoulom\ViewCounterBundle\Manager\StatsManager;

/**
 * Class StatsConverterCommand
 *
 * @package Tchoulom\ViewCounterBundle\Command
 */
class StatsConverterCommand extends AbstractCommand
{
    /**
     * @var string confirmation before converting to stats.
     */
    protected const CONVERT_TO_STATS_CONFIRMED = 'yes';

    /**
     * @var string The conversion stats.
     */
    protected const CONVERT_TO_STATS_MSG = 'Converts ViewCounter entities to statistical data.';

    /**
     * @var string Converting to stats data.
     */
    protected const CONVERTING_TO_STATS_DATA_MSG = 'Converting ViewCounter entities to statistical data...';

    /**
     * @var string No data to convert to stats.
     */
    protected const NO_DATA_TO_CONVERT_TO_STATS_MSG = 'No ViewCounter entities to convert into statistical data!';

    /**
     * The Stats converter.
     *
     * @var StatsConverter The Stats converter.
     */
    protected $statsConverter;

    /**
     * StatConverterCommand constructor.
     *
     * @param CounterManager $counterManager
     * @param StatsManager $statsManager
     * @param StatsConverter $statsConverter
     * @param string|null $name
     */
    public function __construct(
        CounterManager $counterManager,
        StatsManager   $statsManager,
        StatsConverter $statsConverter,
        string         $name = null
    )
    {
        parent::__construct($counterManager, $statsManager, $name);

        $this->statsConverter = $statsConverter;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tchoulom:viewcounter:stats:convert')
            ->setDescription(
                self::CONVERT_TO_STATS_MSG
            )->setDefinition(array(
                new InputOption(
                    'cleanup', null, InputOption::VALUE_OPTIONAL,
                    "The 'cleanup' option allows to delete or not the ViewCounter entities after the generation of the statistical data (Example: true | false).
                                If the 'cleanup' option is equal to true, the ViewCounter entities will be deleted after generating the statistical data.
                                If the 'cleanup' option is equal to false, the ViewCounter entities will not be deleted after generating the statistical data.
                                By default the value of the 'cleanup' option is equal to true.
                                "
                ),
                new InputOption(
                    self::AUTO_APPROVE, null, InputOption::VALUE_OPTIONAL,
                    "The argument 'auto-approve' allows interactive questions to be approved automatically.
                               If the 'auto-approve' option is equal to true, interactive questions will be automatically approved.
                               If the 'auto-approve' option is equal to false, interactive questions will not be automatically approved.
                               By default the value of the 'auto-approve' option is equal to false.
                              "
                ),
            ))
            ->setHelp('
                            Converts ViewCounter entities to statistical data.

                            Examples of using the command:

                            bin/console tchoulom:viewcounter:stats:convert --cleanup=true
                            bin/console tchoulom:viewcounter:stats:convert --cleanup=false
                            bin/console tchoulom:viewcounter:stats:convert
                            bin/console tchoulom:viewcounter:stats:convert --auto-approve=true


                            <comment>' . self::SEE_DOCUMENTATION_MSG . '</comment>'
            );
    }

    /**
     * Executes the stats converter Command.
     *
     * @return int Does the command end with success or failure?
     *
     * @throws \Exception
     */
    protected function doExecute(): int
    {
        return $this->convert();
    }

    /**
     * Converts ViewCounter entities to statistical data.
     *
     * @return int Does the command end with success or failure?
     *
     * @throws \Exception
     */
    protected function convert(): int
    {
        $this->io->title(self::CONVERT_TO_STATS_MSG);

        $confirmConvert = $this->tryAutoApprove(self::ASK_QUESTION_MSG);

        if (self::CONVERT_TO_STATS_CONFIRMED === $confirmConvert) {
            $this->io->writeln(self::CONVERTING_TO_STATS_DATA_MSG);

            $viewCounterData = $this->counterManager->loadViewCounterData();
            $canConvertToStats = is_array($viewCounterData) && !empty($viewCounterData);

            if ($canConvertToStats) {
                $nbVcEntities = count($viewCounterData);
                $progressBar = new ProgressBar($this->output, $nbVcEntities);
                $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s%');
                $progressBar->start();

                foreach ($viewCounterData as $viewcounter) {
                    $viewcounter = $this->counterManager->setProperty($viewcounter);
                    $this->statsConverter->convert($viewcounter);
                    $progressBar->advance();
                }

                $progressBar->finish();

                $vcMessage = $nbVcEntities > 1 ? 'entities from the ViewCounter table have been' : 'entity from the viewCounter table has been';
                $this->writeMessage($nbVcEntities . ' ' . $vcMessage . ' successfully converted into statistical data.',
                    self::SUCCESS);

                // Cleanup ViewCounter entities.
                $cleanup = $this->input->getOption('cleanup') ?? true;
                $cleanup = filter_var($cleanup, FILTER_VALIDATE_BOOLEAN);
                if (true === $cleanup) {
                    $rowsDeleted = $this->counterManager->cleanup();
                    $this->writeRowsDeletedResponse($rowsDeleted);
                }
            } else {
                $this->writeMessage(self::NO_DATA_TO_CONVERT_TO_STATS_MSG, self::COMMENT);
            }

            return self::SUCCESS;
        }

        $this->writeMessage(self::NO_CHANGE_MADE_MSG, self::COMMENT);

        return self::SUCCESS;
    }
}
