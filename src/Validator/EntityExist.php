<?php

namespace App\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class EntityExist extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'The data with id: "{{ value }}" is not exists.';
    public string $className;

    #[HasNamedArguments]
    public function __construct(string $className,array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
        $this->className = $className;
    }
}
