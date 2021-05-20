<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Contracts;

interface GenerateSequenceCodeInterface
{
    public function generateCode(string $code): string;
}
