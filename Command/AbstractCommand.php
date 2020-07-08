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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tchoulom\ViewCounterBundle\Manager\CounterManager;

/**
 * Class AbstractCommand
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var int Does the command end successfully.
     */
    protected const SUCCESS = 0;

    /**
     * @var int Does the command end with failure.
     */
    protected const FAILURE = 1;

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

    public function __construct(CounterManager $counterManager, string $name = null)
    {
        parent::__construct($name);
        $this->counterManager = $counterManager;
    }

    /**
     * @return int
     */
    abstract protected function executeCleanupCommand();

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->io = new SymfonyStyle($this->input, $this->output);

        return $this->executeCleanupCommand();
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
}
