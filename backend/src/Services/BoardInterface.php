<?php


namespace App\Services;


interface BoardInterface
{
    /**
     * BoardInterface constructor.
     * @param string $board
     * @param string $oldBoard
     */
    public function __construct(string $board, string $oldBoard);

    /**
     * @param string $board
     * @return array
     */
    public function boardToArray(string $board): array;

    /**
     * @param array $board
     * @return string
     */
    public function boardToString(array $board): string;

    /**
     * @param $move
     */
    public function addMoveToBoard($move);

    /**
     * @return array
     */
    public function getWorkingBoard(): array;

    /**
     * @param array $workingBoard
     */
    public function setWorkingBoard(array $workingBoard): void;

    /**
     * @return array
     */
    public function getOldBoard(): array;

    /**
     * @param array $oldBoard
     */
    public function setOldBoard(array $oldBoard): void;

}