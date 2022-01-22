<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Task::class);
        $this->_entityManager = $entityManager;
    }

    public function findAll()
    {
        return $this->findBy(array(), array('id' => 'DESC'));
    }

    public function save(Task $task)
    {
        $this->_entityManager->persist($task);
        $this->_entityManager->flush();
    }

    public function update(Task $task, Task $newTask){
        $task->setTitle($newTask->getTitle());
        $this->_entityManager->flush();
    }

    public function completedTask(Task $task)
    {
        $task->getCompleted() ? $task->setCompleted(false) : $task->setCompleted(true);
        $this->_entityManager->flush();
    }

    public function delete(Task $task){
        $this->_entityManager->remove($task);
        $this->_entityManager->flush();
    }

    // /**
    //  * @return Task[] Returns an array of Task objects
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
    public function findOneBySomeField($value): ?Task
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
