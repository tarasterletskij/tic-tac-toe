<?php


namespace App\Services;


use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BoardHandle implements BoardInterface
{
    /**
     * @var array
     */
    private $workingBoard;
    /**
     * @var array
     */
    private $oldBoard;
    /**
     * @var CheatValidationInterface
     */
    private $cheatValidation;

    /**
     * BoardHandle constructor.
     * @param string $board
     * @param string $oldBoard
     */
    public function __construct(string $board, string $oldBoard)
    {
        $this->workingBoard = $this->boardToArray($board);
        $this->oldBoard = $this->boardToArray($oldBoard);
        $this->cheatValidation = new CheatValidation($this->oldBoard, $this->workingBoard);
    }

    /**
     * @return array
     */
    public function getWorkingBoard(): array
    {
        return $this->workingBoard;
    }

    /**
     * @return array
     */
    public function getOldBoard(): array
    {
        return $this->oldBoard;
    }

    /**
     * @param array $workingBoard
     */
    public function setWorkingBoard(array $workingBoard): void
    {
        $this->workingBoard = $workingBoard;
    }

    /**
     * @param array $oldBoard
     */
    public function setOldBoard(array $oldBoard): void
    {
        $this->oldBoard = $oldBoard;
    }


    /**
     * @param string $board
     * @return array
     */
    public function boardToArray(string $board): array
    {
        return str_split($board);
    }

    /**
     * @param array $board
     * @return string
     */
    public function boardToString(array $board): string
    {
        return implode('', $board);
    }


    /**
     * @param $move
     */
    public function addMoveToBoard($move)
    {
        $this->workingBoard[$move] = CheckResult::COMPUTER;
    }

    /**
     * @return CheatValidationInterface
     */
    public function getCheatValidation(): CheatValidationInterface
    {
        return $this->cheatValidation;
    }
}