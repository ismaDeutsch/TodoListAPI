<?php

namespace App\Repository;

use App\Entity\TodoList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TodoList|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoList|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoList[]    findAll()
 * @method TodoList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoListRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, TodoList::class);
        $this->_entityManager = $entityManager;
    }

    public function save(TodoList $todoList){
        $this->_entityManager->persist($todoList);
        $this->_entityManager->flush();
    }

    public function delete(){
        $todolist = $this->findBy(array(), array(), 1, 0);
        $this->_entityManager->remove($todolist[0]);
        $this->_entityManager->flush();
    }

    // /**
    //  * @return TodoList[] Returns an array of TodoList objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TodoList
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
