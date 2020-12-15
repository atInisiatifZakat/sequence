<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Repository;

use DateTime;
use DateTimeInterface;
use Webmozart\Assert\Assert;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Inisiatif\Package\Sequence\Contracts\SequenceInterface;
use Inisiatif\Package\Sequence\Contracts\SequenceRepositoryInterface;

final class SequenceRepository implements SequenceRepositoryInterface
{
    private Builder $builder;

    public function __construct(SequenceInterface $sequence)
    {
        Assert::isInstanceOf($sequence, Model::class);

        /** @noinspection PhpUndefinedMethodInspection */
        $this->builder = $sequence->newQuery();
    }

    public function save(SequenceInterface $sequence): bool
    {
        Assert::isInstanceOf($sequence, Model::class);

        /** @noinspection PhpUndefinedMethodInspection */
        return $sequence->save();
    }

    public function increment(SequenceInterface $sequence): bool
    {
        $model = clone $sequence;

        $model->setLastSequence($sequence->getLastSequence() + 1);

        return $this->save($model);
    }

    public function findOneUsingCode(string $code, ?DateTimeInterface $date = null): ?SequenceInterface
    {
        $model = $this->builder->where('code', $code)
            ->when($date, function (Builder $builder) use ($date) {
                return $builder->whereDate('date', $date);
            })->first();

        Assert::nullOrIsInstanceOf($model, SequenceInterface::class);

        return $model;
    }

    public function findOneOrCreateUsingCode(string $code, ?DateTimeInterface $date = null): SequenceInterface
    {
        $model = $this->findOneUsingCode($code, $date);

        return $model ?: $this->initiation($code, $date);
    }

    private function initiation(string $code, ?DateTimeInterface $date = null): SequenceInterface
    {
        /** @var SequenceInterface $model */
        $model = $this->builder->forceCreate([
            'code' => $code,
            'date' => $date ?: new DateTime(),
            'sequence' => 0,
        ]);

        Assert::nullOrIsInstanceOf($model, SequenceInterface::class);

        return $model;
    }
}
