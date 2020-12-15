<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Contracts;

use DateTimeInterface;

interface SequenceRepositoryInterface
{
    public function save(SequenceInterface $sequence): bool;

    public function increment(SequenceInterface $sequence): bool;

    public function findOneUsingCode(string $code, ?DateTimeInterface $date): ?SequenceInterface;

    public function findOneOrCreateUsingCode(string $code, ?DateTimeInterface $date): SequenceInterface;
}
