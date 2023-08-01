<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    private array $requestData;
    private array $errors=[];
    private $dto;
    private FormInterface $form;


    protected function setRequestData(Request $request)
    {
        $this->requestData = json_decode($request->getContent(), true);
        return $this;
    }

    protected function getRequestData():array
    {
        return $this->requestData;
    }

    protected function setDto(string $dtoClassName)
    {
        $this->dto = new $dtoClassName();
        return $this;
    }

    protected function setForm(string $formType)
    {
        $this->form = $this->createForm($formType, $this->dto);
        return $this;
    }

    protected function formHandler()
    {
        $form = $this->form;
        $form->submit($this->requestData);

        if (!$form->isValid()) {
            $errors = [];
            foreach ($form->getErrors(true, true) as $error) {
                $errors[$error->getOrigin()->getName()] = $error->getMessage();
            }

            $this->errors=$errors;
        }
    }

    protected function getErrors(){
        return $this->errors;
    }

    protected function errorExists(){
        return count($this->errors);
    }

    public function jsonError(\Exception $exception)
    {
        return new JsonResponse([
            'error' => json_decode($exception->getMessage(),true)
        ], 400);
    }
}
