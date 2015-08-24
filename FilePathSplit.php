<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
    Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 */
class FilePathSplit extends Constraint
{
    public $minCount;
    public $maxCount;
    public $exactCount;

    public $minCountMessage = '文件地址必城大于 {{ minCount }} 个';
    public $maxCountMessage = '文件地址必需小于 {{ maxCount }} 个';
    public $exactCountMessage = '文件地址必需等于 {{ exactCount }} 个';

    public function __construct($options = null)
    {
        parent::__construct($options);

        if (null === $this->minCount && null === $this->maxCount && null === $this->exactCount) {
            throw new MissingOptionsException(sprintf('Either option "minCount" or "maxCount" or "exactCount" must be given for constraint %s', __CLASS__), array('minCount', 'maxCount', 'exactCount'));
        }
    }

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
