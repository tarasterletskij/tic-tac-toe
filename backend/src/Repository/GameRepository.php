<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\QueryException;
use Doctrine\Persistence\ManagerRegistry;
use http\Exception\BadConversionException;
use http\Exception\InvalidArgumentException;
use MongoDB\Driver\Exception\ExecutionTimeoutException;
use Ramsey\Uuid\UuidInterface;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * GameRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Game::class);
        $this->manager = $manager;
    }

    /**
     * @param Game $game
     */
    public function removeGame(Game $game): void
    {
        $this->manager->remove($game);
        $this->manager->flush();
    }

    /**
     * @param Game $game
     */
    public function saveGame(Game $game): void
    {
        $this->manager->persist($game);
        $this->manager->flush();
    }

    /**
     * @param Game $game
     * @return UuidInterface
     */
    public function newGame(Game $game): UuidInterface
    {
        $this->manager->persist($game);
        $this->manager->flush();

        return $game->getId();
    }

    /**
     * @return array
     */
    public function findAllAsArray(): array
    {
        $query = $this->createQueryBuilder('g')
            ->where('g.status=:status')
            ->setParameter('status', Game::STATUS_RUNNING)
            ->getQuery();

        return $query->getArrayResult();
    }
    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
