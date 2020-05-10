<?php


namespace App\Services;


use App\Entity\Game;

class CheckResult implements CheckResultInterface
{
    /**
     * @param BoardInterface $board
     */
    private $boardHandle;

    /**
     * CheckResult constructor.
     * @param BoardInterface $boardHandle
     */
    public function __construct(BoardInterface $boardHandle)
    {
        $this->boardHandle = $boardHandle;
    }

    /**
     * @param array $boardArray
     * @return array
     */
    public function emptyIndexes(array $boardArray): ?array
    {
        return array_filter($boardArray, function ($spot) {
            if ($spot !== self::COMPUTER && $spot !== self::PLAYER) {
                return $spot;
            }
        });
    }


    /**
     * @param array $boardArray
     * @param string $player
     * @return bool
     */
    public function checkWinning(array $boardArray, string $player): bool
    {
        if (
            ($boardArray[0] == $player && $boardArray[1] == $player && $boardArray[2] == $player) ||
            ($boardArray[3] == $player && $boardArray[4] == $player && $boardArray[5] == $player) ||
            ($boardArray[6] == $player && $boardArray[7] == $player && $boardArray[8] == $player) ||
            ($boardArray[0] == $player && $boardArray[3] == $player && $boardArray[6] == $player) ||
            ($boardArray[1] == $player && $boardArray[4] == $player && $boardArray[7] == $player) ||
            ($boardArray[2] == $player && $boardArray[5] == $player && $boardArray[8] == $player) ||
            ($boardArray[0] == $player && $boardArray[4] == $player && $boardArray[8] == $player) ||
            ($boardArray[2] == $player && $boardArray[4] == $player && $boardArray[6] == $player)
        ) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Minimax algorithm
     * @param array $boardArray
     * @param string $player
     * @return array
     */
    public function moveAlgorithm(array $boardArray, string $player): array
    {
        $availSpots = $this->emptyIndexes($boardArray);

        if ($this->checkWinning($boardArray, self::PLAYER)) {
            return ['score' => -10];
        } else if ($this->checkWinning($boardArray, self::COMPUTER)) {
            return ['score' => 10];
        } else if (count($availSpots) === 0) {
            return ['score' => 0];
        }

        $moves = [];
        foreach ($availSpots as $key => $value) {
            $move['index'] = $key;
            $boardArray[$key] = $player;

            if ($player == self::COMPUTER) {
                $result = $this->moveAlgorithm($boardArray, self::PLAYER);
                $move['score'] = $result['score'];
            } else {
                $result = $this->moveAlgorithm($boardArray, self::COMPUTER);
                $move['score'] = $result['score'];
            }

            $boardArray[$key] = $move['index'];
            array_push($moves, $move);

        }
        $bestMove = null;
        if ($player === self::COMPUTER) {
            $bestScore = -10000;
            foreach ($moves as $key => $move) {
                if ($move['score'] > $bestScore) {
                    $bestScore = $move['score'];
                    $bestMove = $key;
                }
            }
        } else {
            $bestScore = 10000;
            foreach ($moves as $key => $move) {
                if ($move['score'] < $bestScore) {
                    $bestScore = $move['score'];
                    $bestMove = $key;
                }
            }

        }
        return $moves[$bestMove];
    }


    public function computerMove(): void
    {
        $boardArray = $this->boardHandle->getWorkingBoard();
        $moveArr = $this->moveAlgorithm($boardArray, CheckResult::COMPUTER);
        if (isset($moveArr['index'])) {
            $this->boardHandle->addMoveToBoard($moveArr['index']);
        }
    }


    public function getStatusAfterMove(): string
    {
        $boardArray = $this->boardHandle->getWorkingBoard();

        $availSpots = $this->emptyIndexes($boardArray);

        if ($this->checkWinning($boardArray, self::PLAYER)) {
            return Game::STATUS_X_WON;
        } else if ($this->checkWinning($boardArray, self::COMPUTER)) {
            return Game::STATUS_O_WON;
        } else if (count($availSpots) === 0) {
            return Game::STATUS_DRAW;
        }
        return Game::STATUS_RUNNING;
    }

    public function getBoardAfterMove(): string
    {
        return $this->boardHandle->boardToString($this->boardHandle->getWorkingBoard());
    }
}