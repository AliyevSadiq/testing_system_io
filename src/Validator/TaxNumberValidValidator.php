<?php

namespace App\Validator;

use App\Utils\Calculator\TaxesCalculator;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidValidator extends ConstraintValidator
{

    public function __construct(private TaxesCalculator $taxesHandler)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var TaxNumberValid $constraint */
        if (!$constraint instanceof TaxNumberValid) {
            throw new UnexpectedTypeException($constraint, TaxNumberValid::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->taxesHandler->setTaxNumber($value)->taxNumberIsValid()){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
