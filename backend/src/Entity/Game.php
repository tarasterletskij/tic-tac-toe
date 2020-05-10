<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AcmeAssert;

/**
 * @ORM\Entity(repositoryClass=GameRepository::class)
 */
class Game
{
    const STATUS_RUNNING = 'RUNNING';
    const STATUS_X_WON = 'X_WON';
    const STATUS_O_WON = 'O_WON';
    const STATUS_DRAW = 'DRAW';

    /**
     * @var UuidInterface
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @AcmeAssert\ContainsBoard
     * @ORM\Column(type="string", options={"default": "---------"})
     */
    private $board;

    /**
     * @ORM\Column(name="status", type="string",options={"default": "RUNNING"}, columnDefinition="enum('RUNNING', 'X_WON', 'O_WON', 'DRAW')")
     */
    private $status = self::STATUS_RUNNING;

    /**
     * Game constructor.
     * @param $board
     */
    public function __construct($board)
    {
        $this->board = $board;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getBoard(): ?string
    {
        return $this->board;
    }

    /**
     * @param string $board
     * @return $this
     */
    public function setBoard(string $board): self
    {
        $this->board = $board;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return [
            "id" => $this->getId(),
            "board" => $this->getBoard(),
            "status" => $this->getStatus(),
        ];
    }

    /**
     * @return bool
     */
    public function isFinish()
    {
        if ($this->status === self::STATUS_RUNNING) {
            return false;
        }
        return true;
    }
}
