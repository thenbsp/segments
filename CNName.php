<?php

namespace Thenbsp\ResourceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CNName extends Constraint
{
    public $invalidMessage = '字符 “%string%” 不是一个有效的中文名';
    public $lengthMessage = '中文名长度只能为 %min%-%max% 个字符';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
