<?php


namespace App\Services;


interface CheatValidationInterface
{
    const NO_MOVE_MESS = "You didn't move";
    const MANY_MOVES_MESS = "You are cheating. You can make only one move";
    const REWRITE_MOVE_MESS = "You are cheating. You try rewrite your previous move";

    /**
     * CheatValidationInterface constructor.
     * @param array $oldBoard
     * @param array $newBoard
     */
    public function __construct(array $oldBoard, array $newBoard);

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return bool
     */
    public function isValid(): bool;
}