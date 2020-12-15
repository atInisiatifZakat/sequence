<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Providers;

use Illuminate\Support\ServiceProvider;
use Inisiatif\Package\Sequence\Model\Sequence;
use Inisiatif\Package\Sequence\Contracts\SequenceInterface;
use Inisiatif\Package\Sequence\Repository\SequenceRepository;
use Inisiatif\Package\Sequence\Contracts\SequenceRepositoryInterface;

final class SequenceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(SequenceInterface::class, Sequence::class);
        $this->app->bind(SequenceRepositoryInterface::class, SequenceRepository::class);
    }
}
