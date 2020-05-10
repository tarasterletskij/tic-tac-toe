<?php


namespace App\Services;


class CheatValidation implements CheatValidationInterface
{
    /**
     * @var string
     */
    private $message;

    /**
     * @var boolean
     */
    private $isValid;

    /**
     * CheatValidation constructor.
     * @param array $oldBoard
     * @param array $newBoard
     */
    public function __construct(array $oldBoard, array $newBoard)
    {
        $this->validating($oldBoard, $newBoard);
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    private function validating(array $oldBoard, array $newBoard)
    {
        $arrayDiff = array_diff_assoc($oldBoard, $newBoard);
        if (count($arrayDiff) === 0) {
            $this->isValid = false;
            $this->message = self::NO_MOVE_MESS;
        } elseif (count($arrayDiff) > 1) {
            $this->isValid = false;
            $this->message = self::MANY_MOVES_MESS;
        }

        $this->isValid = true;
    }
}