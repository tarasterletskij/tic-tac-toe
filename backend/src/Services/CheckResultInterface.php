<?php


namespace App\Services;


interface CheckResultInterface
{
    const PLAYER = "X";
    const COMPUTER = "O";

    /**
     * CheckResultInterface constructor.
     * @param BoardInterface $boardHandle
     */
    public function __construct(BoardInterface $boardHandle);

    /**
     * @param array $board
     * @return array|null
     */
    public function emptyIndexes(array $board): ?array;

    /**
     * @param array $board
     * @param string $player
     * @return bool
     */
    public function checkWinning(array $board, string $player): bool;

    /**
     * @param array $board
     * @param string $player
     * @return array
     */
    function moveAlgorithm(array $board, string $player): array;

    public function computerMove(): void;

    /**
     * @return string
     */
    public function getStatusAfterMove(): string;

    /**
     * @return string
     */
    public function getBoardAfterMove(): string;

}