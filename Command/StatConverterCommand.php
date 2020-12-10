<?php

/**
 * This file is part of the TchoulomViewCounterBundle package.
 *
 * @package    TchoulomViewCounterBundle
 * @author     Original Author <tchoulomernest@yahoo.fr>
 *
 * (c) Ernest TCHOULOM <https://www.tchoulom.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tchoulom\ViewCounterBundle\Command;

use Symfony\Component\Console\Input\InputOption;

/**
 * Class StatConverterCommand
 *
 * @package Tchoulom\ViewCounterBundle\Command
 */
class StatConverterCommand extends AbstractCommand
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
    protected const NO_DATA_TO_CONVERT_TO_STATS_MSG = 'No ViewCounter entities to convert to statistical data!';

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
            ))
            ->setHelp('
                            Converts ViewCounter entities to statistical data.
                            
                            Examples of using the command:
                            
                            bin/console tchoulom:viewcounter:stats:convert --cleanup=true
                            bin/console tchoulom:viewcounter:stats:convert --cleanup=false
                            bin/console tchoulom:viewcounter:stats:convert
                            
                
                            <comment>'.self::SEE_DOCUMENTATION_MSG.'</comment>'
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
        $confirmConvert = $this->askQuestion(self::ASK_QUESTION_MSG);

        if (self::CONVERT_TO_STATS_CONFIRMED === $confirmConvert) {
            $this->io->writeln(self::CONVERTING_TO_STATS_DATA_MSG);

            $viewCounterData = $this->counterManager->loadViewCounterData();
            $canConvertToStats = is_array($viewCounterData) && !empty($viewCounterData);

            if ($canConvertToStats) {
                $this->statManager->convertToStats($viewCounterData);

                $nbVcEntities = count($viewCounterData);
                $vcMessage = $nbVcEntities > 1 ? 'entities from the ViewCounter table have been' : 'entity from the viewCounter table has been';
                $this->writeMessage($nbVcEntities.' '.$vcMessage.' successfully converted to statistical data.',
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
