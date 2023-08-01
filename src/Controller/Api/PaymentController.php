<?php

namespace App\Controller\Api;

use App\Form\DTO\PaymentDTO;
use App\Form\PaymentFormType;
use App\Utils\Handler\AmountCalculationHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/payment', name: 'payment.')]
class PaymentController extends ApiController
{

    public function __construct(private AmountCalculationHandler $amountCalculationHandler)
    {
    }

    #[Route('/calculation', name: 'calculation', methods: 'POST')]
    public function calculation(Request $request)
    {
        try {
            $this->processPaymentRequest($request);

            return new JsonResponse([
                'success' => true,
                'message' => "Total amount of product is {$this->getTotalAmount()}"
            ], 200);
        } catch (\Exception $exception) {
            return $this->jsonError($exception);
        }
    }


    private function processPaymentRequest(Request $request)
    {
        $this->setRequestData($request)
            ->setDto(PaymentDTO::class)
            ->setForm(PaymentFormType::class)
            ->formHandler();

        if ($this->errorExists()) {
            throw new \Exception(json_encode($this->getErrors()), 400);
        }
    }

    private function getTotalAmount()
    {
        $data = $this->getRequestData();

        return $this->amountCalculationHandler->setProduct($data['product'])
            ->setCouponCode($data['couponCode'] ?? null)
            ->setTaxNumber($data['taxNumber'])
            ->calculation();
    }
}
