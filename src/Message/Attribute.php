<?php

namespace Trademachines\Riemann\Message;

use DrSlump\Protobuf\AnnotatedMessage;

/**
 * Class Attribute
 */
class Attribute extends AnnotatedMessage
{
    /** @protobuf(tag=1, type=string, required) */
    public $key;

    /** @protobuf(tag=2, type=string, optional) */
    public $value;
}
