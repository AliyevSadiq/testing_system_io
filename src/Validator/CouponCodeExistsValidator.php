<?php

namespace App\Validator;

use App\Repository\CouponRepository;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CouponCodeExistsValidator extends ConstraintValidator
{
    public function __construct(private CouponRepository $couponRepository)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var CouponCodeExists $constraint */
        if (!$constraint instanceof CouponCodeExists) {
            throw new UnexpectedTypeException($constraint, CouponCodeExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $entity = $this->couponRepository->findBy(['code' => $value, 'is_used' => false]);

        if (!$entity) {
            // TODO: implement the validation here
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}
