<?php

namespace Thenbsp\ResourceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CNMobile extends Constraint
{
    public $lengthMessage   = '手机号长度只能为 %length% 个字符';
    public $invalidMessage  = '字符 “%string%” 不是一个有效的手机号';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
