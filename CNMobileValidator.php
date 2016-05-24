<?php

namespace Thenbsp\ResourceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CNMobileValidator extends ConstraintValidator
{
    const LENGTH = 11;
    const STARTWITH = [
        130, 131, 132, 133, 134, 135, 136, 137, 138, 139,
        145, 147,
        150, 151, 152, 153, 154, 155, 156, 157, 158, 159,
        176, 177, 178,
        180, 181, 182, 183, 184, 185, 186, 187, 188, 189
    ];

    public function validate($value, Constraint $constraint)
    {
        if (mb_strlen($value) !== self::LENGTH) {
            $this->context->buildViolation($constraint->lengthMessage)
                ->setParameter('%length%', self::LENGTH)
                ->addViolation();
        }

        if (!preg_match('/^[0-9]+$/', $value)) {
            $this->context->buildViolation($constraint->invalidMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }

        if (!in_array(mb_substr($value, 0, 3), self::STARTWITH)) {
            $this->context->buildViolation($constraint->invalidMessage)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}
