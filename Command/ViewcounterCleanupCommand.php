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
use Tchoulom\ViewCounterBundle\Exception\RuntimeException;
use Tchoulom\ViewCounterBundle\Util\Date;

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
     * @var string successful deletion message.
     */
    protected const SUCCESSFUL_DELETION_MSG = '%s line%s %s been successfully deleted!';

    /**
     * @var string Nothing to delete message.
     */
    protected const NOTHING_TO_DELETE_MSG = 'Nothing to delete!';

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
            ->setDefinition(array(
                new InputOption(
                    'min', null, InputOption::VALUE_OPTIONAL,
                    "The option 'min' allows to remove viewcounters entities where view date greater than or equals the given value (Example: 1s).
                                If only this option is set, then the viewcounters records meeting this criteria will be deleted.
                                "
                ),
                new InputOption(
                    'max', null, InputOption::VALUE_OPTIONAL,
                    "The option 'max' allows to remove viewcounters entities where view date less than or equals the given value (Example: 1s).
                                If only this option is set, then the viewcounters records meeting this criteria will be deleted.
                                "
                )
            ))
            ->setHelp('
                            Deletes viewcounter data from the database according to the given criteria.
                            
                            Examples of date interval:
                            
                            "s" => "second"
                            "m" => "minute"
                            "h" => "hour"
                            "d" => "day"
                            "w" => "week"
                            "M" => "month"
                            "y" => "year"
                            
                
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
    protected function executeCleanupCommand(): int
    {
        return $this->handle();
    }

    /**
     * Handles cleanup viewcounter data.
     *
     * @return int Does the command end with success or failure?
     *
     * @throws \Exception
     */
    protected function handle(): int
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

        $confirmCleanup = $this->askQuestion(self::ASK_QUESTION_MSG);
        if (self::CLEANUP_CONFIRMED === $confirmCleanup) {
            $this->io->writeln(self::DELETING_VIEWCOUNTER_DATA_MSG);

            $min = (null === $min) ? $min : $this->subtractDuration($min);
            $max = (null === $max) ? $max : $this->subtractDuration($max);

            $rowsDeleted = $this->counterManager->cleanup($min, $max);
            $this->writeResponseMessage($rowsDeleted);
            return self::SUCCESS;
        } else {
            $this->io->writeln('<comment>' . self::NO_CHANGE_MADE_MSG . '</comment>');
            return self::SUCCESS;
        }

        $this->io->error(self::ERROR_OCCURRED_MSG);
        $this->io->writeln('<comment>' . self::NO_CHANGE_MADE_MSG . '</comment>');

        return self::FAILURE;
    }

    /**
     * Writes the response message.
     *
     * @param int $rowsDeleted The number of rows deleted.
     */
    protected function writeResponseMessage(int $rowsDeleted)
    {
        if ($rowsDeleted > 0) {
            $this->io->success(sprintf(self::SUCCESSFUL_DELETION_MSG, $rowsDeleted, $rowsDeleted > 1 ? 's' : '', $rowsDeleted > 1 ? 'have' : 'has'));
        } else {
            $this->io->writeln('');
            $this->io->writeln('<comment>' . self::NOTHING_TO_DELETE_MSG . '</comment>');
        }
    }
}
