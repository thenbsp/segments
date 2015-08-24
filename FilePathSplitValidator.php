<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FilePathSplitValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof MultiplePath) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\MultiplePath');
        }

        // > $minCount
        if( $constraint->minCount && ($constraint->minCount > $this->getCountOfValue($value)) ) {
            $this->context->buildViolation($constraint->minCountMessage)
                ->setParameter('{{ minCount }}', $this->formatValue($constraint->minCount))
                ->addViolation();
        }

        // < $maxCount
        if( $constraint->maxCount && ($constraint->maxCount < $this->getCountOfValue($value)) ) {
            $this->context->buildViolation($constraint->maxCountMessage)
                ->setParameter('{{ maxCount }}', $this->formatValue($constraint->maxCount))
                ->addViolation();
        }

        // === $exactCount
        if( $constraint->exactCount && ($constraint->exactCount !== $this->getCountOfValue($value)) ) {
            $this->context->buildViolation($constraint->exactCountMessage)
                ->setParameter('{{ exactCount }}', $this->formatValue($constraint->exactCount))
                ->addViolation();
        }
    }

    private function getCountOfValue($value)
    {
        return is_null($value) ? 0 : count($value);
    }
}
