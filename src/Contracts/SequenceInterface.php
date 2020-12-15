<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Contracts;

use DateTimeInterface;

interface SequenceInterface
{
    /**
     * @return integer|string
     */
    public function getId();

    /**
     * @param integer|string $id
     * @return mixed
     */
    public function setId($id);

    public function getCode(): ?string;

    /**
     * @return mixed
     */
    public function setCode(?string $value);

    public function getDate(): ?DateTimeInterface;

    /**
     * @return mixed
     */
    public function setDate(?DateTimeInterface $value);

    public function getLastSequence(): int;

    /**
     * @return mixed
     */
    public function setLastSequence(int $value);
}
