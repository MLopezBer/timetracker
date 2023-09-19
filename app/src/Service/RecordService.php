<?php

namespace App\Service;

use App\Entity\Records;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\RecordsRepository;

class RecordService
{
    private EntityManagerInterface $entityManager;
    private RecordsRepository $recordsRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        RecordsRepository $recordsRepository
    ){
        $this->entityManager = $entityManager;
        $this->recordsRepository = $recordsRepository;
    }

    /**
     * @param \DateTimeInterface $now
     * @return void
     */
    public function endCurrentRecord(\DateTimeInterface $now, int $taskId): void
    {
        $record = $this->entityManager->getRepository(Records::class)->findOneBy(['endtime'=>NULL, 'task'=>$taskId]);
        if($record===NULL) return;

        $record->setEndtime($now);

        $diff = $record->getStart()->diff($now)->format('%H:%I:%s');
        $record->setTotaltime(new \DateTime("0000-00-00 ".$diff));

        $this->entityManager->persist($record);
        $this->entityManager->flush();
    }

    /**
     * @param int $taskId
     * @return false|string
     */
    public function returnCurrentValue(int $taskId)
    {
        $records = $this->entityManager->getRepository(Records::class)->findBy(['task'=>$taskId]);
        $e = strtotime('00:00:00');

        foreach ($records as $record)
        {
            if($record->getTotaltime()===NULL) continue;

            $a = strtotime($record->getTotaltime()->format('H:i:s'))-strtotime("00:00:00");

            $e = $e+$a;
        }

        $r = [
            'hours' => date('H', $e),
            'minutes' => date('i', $e),
            'seconds' => date('s', $e)
        ];

        return json_encode($r);
    }

    public function totalWorkedByDay() : string
    {
        $registers = $this->recordsRepository->getTotalWorkedByDay(date('Y-m-d'));
        var_dump($registers);
        die();
    }
}