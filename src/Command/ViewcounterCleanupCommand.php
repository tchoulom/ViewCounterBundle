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

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * The Viewcounter cleanup Command.
 *
 * Class CleanupViewcounterCommand
 */
class ViewcounterCleanupCommand extends AbstractCommand
{
    /**
     * @var string confirmation before cleanup.
     */
    protected const CLEANUP_CONFIRMED = 'yes';

    /**
     * @var bool determines if the given value is correct
     */
    protected $check = true;

    /**
     * @var string The cleanup message.
     */
    protected const CLEANUP_MSG = 'Cleanup the viewcounter data';

    /**
     * @var string Deleting viewcounter message.
     */
    protected const DELETING_VIEWCOUNTER_DATA_MSG = 'Deleting viewcounter data...';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tchoulom:viewcounter:cleanup')
            ->setDescription(
                'Deletes viewcounter data from the database according to the given criteria.'
            )
            ->setDefinition([
                new InputOption(
                    'min', null, InputOption::VALUE_OPTIONAL,
                    "The option 'min' allows to remove viewcounters entities where view date greater than or equals the given value (Example: 1s).
                                If only this option is set, then the viewcounters records meeting this criteria will be deleted.
                                "
                ),
                new InputOption(
                    'max', null, InputOption::VALUE_OPTIONAL,
                    "The option 'max' allows to remove viewcounters entities where view date less than or equals the given value (Example: 7m).
                                If only this option is set, then the viewcounters records meeting this criteria will be deleted.
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
            ])
            ->setHelp('
                            bin/console tchoulom:viewcounter:cleanup --min=3y

                            Deletes viewcounter data from the database according to the given criteria.

                            Examples of date interval:

                            "s" => "second"
                            "m" => "minute"
                            "h" => "hour"
                            "d" => "day"
                            "w" => "week"
                            "M" => "month"
                            "y" => "year"

                            bin/console tchoulom:viewcounter:cleanup --auto-approve=true
                            

                            <comment>' . self::SEE_DOCUMENTATION_MSG . '</comment>'
            );
    }

    /**
     * Executes the cleanup Command.
     *
     * @return int Does the command end with success or failure?
     *
     * @throws \Exception
     */
    protected function doExecute(): int
    {
        return $this->cleanup();
    }

    /**
     * Handles cleanup viewcounter data.
     *
     * @return int Does the command end with success or failure?
     *
     * @throws \Exception
     */
    protected function cleanup(): int
    {
        $this->io->title(self::CLEANUP_MSG);

        $min = $this->input->getOption('min');
        $max = $this->input->getOption('max');

        if (null !== $min && false === $this->checkDuration($min)) {
            $this->io->error(sprintf(self::CRITERIA_NOT_SUPPORTED_MSG, "'$min'"));
            $this->check = false;
        }
        if (null !== $max && false === $this->checkDuration($max)) {
            $this->io->error(sprintf(self::CRITERIA_NOT_SUPPORTED_MSG, "'$max'"));
            $this->check = false;
        }

        if (false === $this->check) {
            $this->io->writeln('');
            $this->io->note(self::SEE_DOCUMENTATION_MSG);
            $this->io->writeln('');
            $this->io->comment(self::NO_CHANGE_MADE_MSG);

            return self::FAILURE;
        }

        $confirmCleanup = $this->tryAutoApprove(self::ASK_QUESTION_MSG);

        if (self::CLEANUP_CONFIRMED === $confirmCleanup) {
            $this->io->writeln(self::DELETING_VIEWCOUNTER_DATA_MSG);

            $min = (null === $min) ? $min : $this->subtractDuration($min);
            $max = (null === $max) ? $max : $this->subtractDuration($max);

            $rowsDeleted = $this->counterManager->cleanup($min, $max);
            $this->writeRowsDeletedResponse($rowsDeleted);

            return self::SUCCESS;
        } else {
            $this->io->writeln('<comment>' . self::NO_CHANGE_MADE_MSG . '</comment>');

            return self::SUCCESS;
        }

        $this->io->error(self::ERROR_OCCURRED_MSG);
        $this->io->writeln('<comment>' . self::NO_CHANGE_MADE_MSG . '</comment>');

        return self::FAILURE;
    }
}
