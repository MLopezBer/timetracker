<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Tasks;
use App\Entity\Records;
use Symfony\Component\Validator\Constraints\Date;

class TaskService
{

    private EntityManagerInterface $entityManager;
    private RecordService $recordService;

    public function __construct(
        EntityManagerInterface $entityManager,
        RecordService $recordService
    ){
        $this->entityManager = $entityManager;
        $this->recordService = $recordService;
    }

    /**
     * @param string $taskName
     * @return object|bool
     */
    public function getTaskByLabel(string $taskName) : object|null
    {
        return $this->entityManager->getRepository(Tasks::class)->findOneBy(['label'=>$taskName]);
    }

    /**
     * @param string $taskName
     * @return void
     */
    public function startTask(string $taskName = "") : array
    {
        $now = new \DateTime();
        $task = $this->getTaskByLabel($taskName);

        if($task===NULL)
        {
            $task = new Tasks();
            $task->setLabel($taskName);
            $task->setCreationDate($now);
            $return = ['success'=> true, 'msg' => true];
        }
        elseif($task->isStatus()) return ['success'=> false, 'msg' => 1];
        else $return = ['success'=> true, 'msg' => $this->recordService->returnCurrentValue($task->getId())];

        $this->stopCurrentTask($now);

        $task->setStatus(true);

        $this->entityManager->persist($task);

        $record = new Records();
        $record->setStart($now);

        $task->addRecord($record);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $return;
    }

    /**
     * @param \DateTimeInterface $now
     * @return void
     */
    public function stopCurrentTask(\DateTimeInterface $now) : void
    {
        $currentTask = $this->entityManager->getRepository(Tasks::class)->findOneBy(['status'=>'1']);
        if($currentTask===NULL) return;

        $this->recordService->endCurrentRecord($now, $currentTask->getId());

        $currentTask->setStatus(false);

        $this->entityManager->persist($currentTask);
        $this->entityManager->flush();
    }

    /**
     * @return string
     */
    public function getGrid() : string
    {
        $return = "";
        $tasks = $this->entityManager->getRepository(Tasks::class)->findAll();
        if($tasks===NULL) return "";

        foreach ($tasks as $task)
        {
            $val = json_decode($this->recordService->returnCurrentValue($task->getId()), true);
            $time = $val['hours'].":".$val['minutes'].":".$val['seconds'];

            $return .= '<div class="col-7">'.$task->getLabel().'</div><div class="col-5">'.$time.'</div>';
        }

        return $return;
    }
}