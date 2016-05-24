<?php

namespace Thenbsp\ResourceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CNNameValidator extends ConstraintValidator
{
    const MIN = 2;
    const MAX = 4;

    public function validate($value, Constraint $constraint)
    {
        if (!preg_match("/^\p{Han}+$/u", $value)) {
            $this->context->buildViolation($constraint->invalidMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }

        $strlen = mb_strlen($value);
        if (($strlen < self::MIN) || ($strlen > self::MAX)) {
            $this->context->buildViolation($constraint->lengthMessage)
                ->setParameter('%min%', self::MIN)
                ->setParameter('%max%', self::MAX)
                ->addViolation();
        }
    }
}
