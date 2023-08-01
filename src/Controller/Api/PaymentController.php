<?php

namespace App\Controller\Api;

use App\Form\DTO\PaymentDTO;
use App\Form\PaymentFormType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment', name: 'payment.')]
class PaymentController extends ApiController
{

    #[Route('/calculation', name: 'calculation', methods: 'POST')]
    public function calculation(Request $request)
    {
        try {
            $this->setRequestData($request)
                ->setDto(PaymentDTO::class)
                ->setForm(PaymentFormType::class)
                ->formHandler();

            if ($this->errorExists()) {
                return new JsonResponse(['error' => $this->getErrors()], 400);
            }

            return new JsonResponse([
                'success' => true,
                'data'=>$this->getRequestData()
            ], 200);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => $exception->getMessage()
            ], $exception->getCode());
        }
    }
}
