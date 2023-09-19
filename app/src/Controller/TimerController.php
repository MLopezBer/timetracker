<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\TaskService;

class TimerController extends AbstractController
{
    private TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    #[Route('/startTimer')]
    public function startTimer(Request $request) : JsonResponse
    {
        $input = $request->request->get('label');

        $data = $this->taskService->startTask($input);

        return $this->json([
            'success' => $data['success'],
            'data' => $data['msg']
        ]);
    }

    #[Route('/stopTimer')]
    public function stopTimer(Request $request) : JsonResponse
    {
        $input = $request->request->get('label');
        $this->taskService->stopCurrentTask(new \DateTime());

        return $this->json([
            'success' => true
        ]);
    }
}
