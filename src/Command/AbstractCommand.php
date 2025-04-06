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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tchoulom\ViewCounterBundle\Exception\RuntimeException;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;
use Tchoulom\ViewCounterBundle\Manager\StatsManager;
use Tchoulom\ViewCounterBundle\Util\Date;

/**
 * Class AbstractCommand
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var int Comment message.
     */
    protected const COMMENT = 2;

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var SymfonyStyle The SymfonyStyle class.
     */
    protected $io;

    /**
     * @var CounterManager The Counter Manager.
     */
    protected $counterManager;

    /**
     * The StatsManager service.
     *
     * @var StatsManager The StatsManager.
     */
    protected $statsManager;

    /**
     * @var string See the documentation message.
     */
    protected const SEE_DOCUMENTATION_MSG = '(See the documentation https://packagist.org/packages/tchoulom/view-counter-bundle#user-content-command)';

    /**
     * @var string Ask question confirmation message.
     */
    protected const ASK_QUESTION_MSG = 'ATTENTION: Do you really want to perform this action? (<comment>yes</comment>/<comment>no</comment>):';

    /**
     * @var string min value required message.
     */
    protected const ERROR_OCCURRED_MSG = 'An erroor has occurred!';

    /**
     * @var string No changes made message.
     */
    protected const NO_CHANGE_MADE_MSG = 'No changes have been made!';

    /**
     * @var string The criteria is not supported message.
     */
    protected const CRITERIA_NOT_SUPPORTED_MSG = 'The given criteria value %s is not supported!';

    /**
     * @var string successful deletion message.
     */
    protected const SUCCESSFUL_DELETION_MSG = '%s line%s %s been successfully deleted!';

    /**
     * @var string Nothing to delete message.
     */
    protected const NOTHING_TO_DELETE_MSG = 'Nothing to delete!';

    /**
     * @var string Allows interactive questions to be approved automatically.
     */
    protected const AUTO_APPROVE = 'auto-approve';

    /**
     * @var string The returned response for auto-approve argument.
     */
    protected const AUTO_APPROVE_RESPONSE = 'yes';

    /**
     * @var array The supported date interval.
     */
    protected const SUPPORTED_DATE_INTERVAL = [
        's' => 'second',
        'm' => 'minute',
        'h' => 'hour',
        'd' => 'day',
        'w' => 'week',
        'M' => 'month',
        'y' => 'year',
    ];

    /**
     * AbstractCommand constructor.
     *
     * @param CounterManager $counterManager
     * @param StatsManager $statsManager
     * @param string|null $name
     */
    public function __construct(
        CounterManager $counterManager,
        StatsManager $statsManager,
        ?string $name = null
    )
    {
        parent::__construct($name);

        $this->counterManager = $counterManager;
        $this->statsManager = $statsManager;
    }

    /**
     * @return int
     */
    abstract protected function doExecute();

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;
        $this->io = new SymfonyStyle($this->input, $this->output);

        return $this->doExecute();
    }

    /**
     * Try to approve questions automatically.
     *
     * @param string $questionText The question
     * @param null $defaultAnswer The answer
     *
     * @return bool|mixed
     */
    protected function tryAutoApprove(string $questionText, $defaultAnswer = null)
    {
        return true == $this->input->getOption(self::AUTO_APPROVE) ?
            self::AUTO_APPROVE_RESPONSE :
            $this->askQuestion(self::ASK_QUESTION_MSG);
    }

    /**
     * Asks the question.
     *
     * @param string $questionText The question
     * @param null $defaultAnswer The answer
     *
     * @return mixed The user answer
     */
    protected function askQuestion(string $questionText, $defaultAnswer = null)
    {
        $helper = $this->getHelper('question');
        $question = new Question($questionText, $defaultAnswer);

        return $helper->ask($this->input, $this->output, $question);
    }

    /**
     * Clears the screen.
     */
    protected function clearScreen(): void
    {
        // clears the entire screen
        $this->io->write("\x1b[2J");
        // moves cursor to top left position
        $this->io->write("\x1b[1;1H");
    }

    /**
     * Checks the given duration.
     *
     * @param string $duration The given duration.
     *
     * @return bool Is the duration OK?
     */
    protected function checkDuration(string $duration): bool
    {
        return is_int($this->getDurationValue($duration)) && array_key_exists($this->getDateInterval($duration),
                self::SUPPORTED_DATE_INTERVAL);
    }

    /**
     * Gets the duration value.
     *
     * @param string $duration
     *
     * @return int
     */
    public function getDurationValue(string $duration): int
    {
        return intval(substr($duration, 0, -1));
    }

    /**
     * Gets the date interval.
     *
     * @param string $minViewDate
     *
     * @return string
     */
    protected function getDateInterval(string $duration): string
    {
        return (string)substr($duration, -1);
    }

    /**
     * Subtracts the given duration.
     *
     * @param string $viewDate
     *
     * @return \DateTimeInterface
     *
     * @throws \Exception
     */
    protected function subtractDuration(string $duration): ?\DateTimeInterface
    {
        if (false === $this->checkDuration($duration)) {
            throw new RuntimeException(sprintf(self::CRITERIA_NOT_SUPPORTED_MSG, "'$duration'"));
        }

        $durationValue = $this->getDurationValue($duration);
        $nowDate = Date::getNowDate();

        switch ($this->getDateInterval($duration)) {
            case 's':
                return Date::subtractSecondsFromDate($nowDate, $durationValue);
            case 'm':
                return Date::subtractMinutesFromDate($nowDate, $durationValue);
            case 'h':
                return Date::subtractHoursFromDate($nowDate, $durationValue);
            case 'd':
                return Date::subtractDaysFromDate($nowDate, $durationValue);
            case 'w':
                return Date::subtractWeeksFromDate($nowDate, $durationValue);
            case 'M':
                return Date::subtractMonthsFromDate($nowDate, $durationValue);
            case 'y':
                return Date::subtractYearsFromDate($nowDate, $durationValue);
        }
        return null;
    }

    /**
     * Writes the rows deleted response.
     *
     * @param int $rowsDeleted The number of rows deleted.
     */
    protected function writeRowsDeletedResponse(int $rowsDeleted)
    {
        if ($rowsDeleted > 0) {
            $this->io->success(sprintf(self::SUCCESSFUL_DELETION_MSG, $rowsDeleted, $rowsDeleted > 1 ? 's' : '',
                $rowsDeleted > 1 ? 'have' : 'has'));
        } else {
            $this->io->writeln('');
            $this->io->writeln('<comment>' . self::NOTHING_TO_DELETE_MSG . '</comment>');
        }
    }

    /**
     *  Writes a message.
     *
     * @param string $message
     * @param int $status
     */
    protected function writeMessage(string $message, int $status)
    {
        switch ($status) {
            case self::SUCCESS:
                $this->io->success($message);
                break;
            case self::FAILURE:
                $this->io->error($message);
                break;
            case self::COMMENT:
                $this->io->writeln('<comment>' . $message . '</comment>');
        }
    }
}
