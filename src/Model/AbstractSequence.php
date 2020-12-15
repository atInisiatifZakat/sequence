<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Model;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Inisiatif\Package\Sequence\Contracts\SequenceInterface;

abstract class AbstractSequence extends Model implements SequenceInterface
{
    protected $casts = [
        'date' => 'datetime',
        'sequence' => 'int',
    ];

    public function getId()
    {
        return $this->getAttribute('id');
    }

    public function setId($id)
    {
        return $this->setAttribute('id', $id);
    }

    public function getCode(): ?string
    {
        return $this->getAttribute('code');
    }

    public function setCode(?string $value)
    {
        return $this->setAttribute('code', $value);
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->getAttribute('date');
    }

    public function setDate(?DateTimeInterface $value)
    {
        return $this->setAttribute('date', $value ? $value->format('Y-m-d') : null);
    }

    public function getLastSequence(): int
    {
        return $this->getAttribute('sequence');
    }

    public function setLastSequence(int $value): self
    {
        return $this->setAttribute('sequence', $value);
    }
}
