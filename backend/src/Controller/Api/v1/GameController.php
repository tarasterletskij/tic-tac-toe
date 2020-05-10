<?php

namespace App\Controller\Api\v1;

use App\Entity\Game;
use App\Repository\GameRepository;
use App\Services\BoardHandle;
use App\Services\CheckResult;
use Doctrine\DBAL\Types\ConversionException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GameController extends AbstractController
{
    private $gameRepository;

    /**
     * GameController constructor.
     * @param GameRepository $gameRepository
     */
    public function __construct(GameRepository $gameRepository)
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @Route("api/v1/games/", name="games", methods={"GET"})
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $games = $this->gameRepository->findAllAsArray();

            return $this->json($games, Response::HTTP_OK);
        } catch (\Error $e) {
            return $this->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("api/v1/games/", name="startGame", methods={"POST"})
     * @param ValidatorInterface $validator
     * @param Request $request
     * @return JsonResponse
     */
    public function startGame(ValidatorInterface $validator, Request $request): JsonResponse
    {
        $board = ($request->get('board')) ?? '---------';

        $game = new Game($board);
        $errors = $validator->validate($game);
        if (count($errors) > 0) {
            return $this->json(['reason' => $errors->get(0)->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $gameId = $this->gameRepository->newGame($game);

        return $this->json(['location' => $gameId], Response::HTTP_CREATED);

    }

    /**
     * @Route("api/v1/games/{id}", name="getGame", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function getGame($id): JsonResponse
    {
        try {
            $game = $this->gameRepository->findOneBy(['id' => $id]);
            if ($game) {
                return $this->json($game->asArray(), Response::HTTP_OK);
            }
            return $this->json(null, Response::HTTP_NOT_FOUND);
        } catch (ConversionException $e) {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @Route("api/v1/games/{id}", name="moveGame", methods={"PUT"})
     * @param ValidatorInterface $validator
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function moveGame(ValidatorInterface $validator, Request $request, $id): JsonResponse
    {
        $requestBoard = $request->get('board');
        if (!$requestBoard) {
            return $this->json(['reason' => 'Your forgot put board to request'], Response::HTTP_BAD_REQUEST);
        }
        $game = $this->gameRepository->find($id);
        if (!$game) {
            return $this->json(null, Response::HTTP_NOT_FOUND);
        }
        if ($game->isFinish()) {
            return $this->json(['reason' => 'Game is finished already'], Response::HTTP_BAD_REQUEST);
        }
        $beforeMoveBoard = $game->getBoard();
        $game->setBoard($requestBoard);
        $errors = $validator->validate($game);
        if (count($errors) > 0) {
            return $this->json(['reason' => $errors->get(0)->getMessage()], Response::HTTP_BAD_REQUEST);
        }
//        TODO:: should be Queue in this endpoint
        $boardHandle = new BoardHandle($requestBoard, $beforeMoveBoard);
        if ($boardHandle->getCheatValidation()->isValid()) {
            $checkResult = new CheckResult($boardHandle);
            $checkResult->computerMove();
            $status = $checkResult->getStatusAfterMove();
            $newBoard = $checkResult->getBoardAfterMove();
            $game->setBoard($newBoard);
            $game->setStatus($status);
            $this->gameRepository->saveGame($game);

            return $this->json($game->asArray(), Response::HTTP_OK);
        }
        return $this->json(['reason' => $boardHandle->getCheatValidation()->getMessage()], Response::HTTP_BAD_REQUEST);
    }

    /**
     * @Route("api/v1/games/{id}", name="deleteGame", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteGame($id): JsonResponse
    {
        $game = $this->gameRepository->find($id);
        if ($game) {
            $this->gameRepository->removeGame($game);

            return $this->json(null, Response::HTTP_OK);
        }

        return $this->json(null, Response::HTTP_NOT_FOUND);
    }
}
