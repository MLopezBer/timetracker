<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\TaskService;
use App\Service\RecordService;

class IndexController extends AbstractController
{
    private TaskService $taskService;
    private RecordService $recordService;

    public function __construct(
        TaskService $taskService,
        RecordService $recordService
    ){
        $this->taskService = $taskService;
        $this->recordService = $recordService;
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            //'workedDay' => $this->recordService->totalWorkedByDay(),
            'tasksgrid' => $this->taskService->getGrid()
        ]);
    }
}
