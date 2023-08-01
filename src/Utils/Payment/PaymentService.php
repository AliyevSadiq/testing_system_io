<?php


namespace App\Utils\Payment;


use App\Enums\PaymentType;
use App\Exception\PaymentException;

class PaymentService
{
    private string $paymentProcessor;

    public function setPaymentProcessor(string $paymentProcessor)
    {
        $this->paymentProcessor=$paymentProcessor;
        return $this;
    }

    public function makePayment(float $price)
    {
        try {
            $intPrice=(int)$price;
            switch ($this->paymentProcessor){
                case PaymentType::PAYPAL:
                    (new PaypalPaymentProcessor())->pay($intPrice);
                    $paymentProcessorResult=true;
                    break;
                case PaymentType::STRIPE:
                    $paymentProcessorResult=(new StripePaymentProcessor())->processPayment($intPrice);
                    break;
                default:
                    throw new \Exception('Payment method not found');
            }
        }catch (\Exception $exception){
            $paymentProcessorResult=false;
            throw new PaymentException($exception->getMessage());
        }finally{
            return $paymentProcessorResult;
        }


    }
    
}