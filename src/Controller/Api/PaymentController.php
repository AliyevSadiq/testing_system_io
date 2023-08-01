<?php

namespace App\Controller\Api;

use App\Exception\PaymentException;
use App\Form\DTO\PaymentDTO;
use App\Form\PaymentFormType;
use App\Utils\Calculator\AmountCalculator;
use App\Utils\Payment\PaymentService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Payment')]
#[Route('/payment', name: 'payment.')]
class PaymentController extends ApiController
{

    public function __construct(
        private AmountCalculator $amountCalculationHandler,
        private LoggerInterface $logger
    )
    {
    }
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'paypal', property: 'paymentProcessor'),
            new OA\Property(type: 'string', example: '1', property: 'product'),
            new OA\Property(type: 'string', example: 'IT12345678912', property: 'taxNumber'),
            new OA\Property(type: 'string', example: '9EH3PNL', property: 'couponCode'),
        ])
    )]
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
            return $this->jsonError($exception->getMessage());
        }
    }
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(properties: [
            new OA\Property(type: 'string', example: 'paypal', property: 'paymentProcessor'),
            new OA\Property(type: 'string', example: '1', property: 'product'),
            new OA\Property(type: 'string', example: 'IT12345678912', property: 'taxNumber'),
            new OA\Property(type: 'string', example: '9EH3PNL', property: 'couponCode'),
        ])
    )]
    #[Route('/pay', name: 'pay', methods: 'POST')]
    public function pay(PaymentService $paymentService, Request $request)
    {
        try {
            $this->processPaymentRequest($request);
            $amount = $this->getTotalAmount();

            $result = $paymentService->setPaymentProcessor($this->getRequestData()['paymentProcessor'])
                ->makePayment($amount);

            if (!$result) {
                return $this->jsonError("Payment failed by {$this->getRequestData()['paymentProcessor']}");
            }

            return new JsonResponse([
                'success' => true,
                'message' => "Payment created by {$this->getRequestData()['paymentProcessor']}"
            ], 200);

        } catch (PaymentException $exception) {
            $this->logger->info($exception->getMessage());
            return $this->jsonError($exception->getMessage());
        } catch (\Exception $exception) {
            return $this->jsonError($exception->getMessage());
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
