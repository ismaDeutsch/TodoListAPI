<?php


namespace App\Controller;
use App\Entity\Task;
use App\Entity\TodoList;
use App\Repository\TaskRepository;
use App\Repository\TodoListRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\View\View;

class ApiController
{
    private $todoListRepo;
    private $taskRepo;

    public function __construct(TodoListRepository $todoListRepo, TaskRepository $taskRepo)
    {
        $this->todoListRepo = $todoListRepo;
        $this->taskRepo = $taskRepo;
    }

    /**
     * @Rest\View(statusCode = 201)
     * @Rest\Post("/todolist")
     */

    public function postTodoList()
    {
        $todoList = new TodoList();
        $this->todoListRepo->save($todoList);
        return $todoList;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get("/todolist")
     */

    public function getTodoList()
    {
        $todoList = $this->todoListRepo->findAll();
        return $todoList;
    }

    /**
     * @Rest\View(statusCode = 201)
     * @Rest\Post("/task")
     * @ParamConverter("task", converter="fos_rest.request_body")
     */

    public function postTask(Task $task)
    {
        $task->setCreatedAt(new \DateTime());
        $task->setTodolist($this->todoListRepo->findBy(array(), array(), 1, 0)[0]);
        $this->taskRepo->save($task);
        return $task;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Get("/task")
     */

    public function getTask()
    {
        $task = $this->taskRepo->findAll();
        return $task;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Put(
     *     path = "/task/{id}",
     *     requirements = {"id" = "\d+"}
     *     )
     * @ParamConverter("newTask", converter="fos_rest.request_body")
     */

    public function updateTask(Task $task, Task $newTask)
    {
        $this->taskRepo->update($task, $newTask);
        return $task;
    }

    /**
     * @Rest\View(statusCode = 200)
     * @Rest\Patch(
     *     path = "/task/{id}",
     *     requirements = {"id" = "\d+"}
     *     )
     */

    public function completeTask(Task $task)
    {
        return $this->taskRepo->completedTask($task);
    }

    /**
     * @Rest\View(StatusCode = 204)
     * @Rest\Delete(
     *     path = "/task/{id}",
     *     requirements = {"id" = "\d+"}
     *     )
     */

    public function deleteTask(Task $task)
    {
        $this->taskRepo->delete($task);
    }

    /**
     * @Rest\View(StatusCode = 204)
     * @Rest\Delete("/todolist")
     */

    public function deleteTodolist()
    {
        $this->todoListRepo->delete();
    }
}