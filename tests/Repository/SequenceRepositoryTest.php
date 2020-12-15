<?php

declare(strict_types=1);

namespace Inisiatif\Package\Sequence\Tests\Repository;

use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Schema\Blueprint;
use Inisiatif\Package\Sequence\Model\Sequence;
use Inisiatif\Package\Sequence\Contracts\SequenceInterface;
use Inisiatif\Package\Sequence\Repository\SequenceRepository;

final class SequenceRepositoryTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        $capsule = new Manager();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->bootEloquent();
        $capsule->setAsGlobal();

        $schema = $capsule->schema();
        $schema->dropIfExists('sequences');
        $schema->create('sequences', function (Blueprint $table): void {
            $table->increments('id');
            $table->string('code');
            $table->date('date');
            $table->unsignedInteger('sequence');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Manager::table('sequences')->truncate();
    }

    public function testItReturnNull(): void
    {
        $repository = new SequenceRepository(new Sequence());
        $sequence = $repository->findOneUsingCode('code');

        $this->assertNull($sequence);
    }

    public function testItReturnNotNull(): void
    {
        $repository = new SequenceRepository(new Sequence());
        $sequence = $repository->findOneOrCreateUsingCode('code');

        $this->assertInstanceOf(Sequence::class, $sequence);
        $this->assertInstanceOf(SequenceInterface::class, $sequence);
        $this->assertSame($sequence->getLastSequence(), 0);
    }

    public function testItCanIncrement(): void
    {
        $repository = new SequenceRepository(new Sequence());
        /** @var Sequence $sequence */
        $sequence = $repository->findOneOrCreateUsingCode('code');

        $repository->increment($sequence);

        $this->assertInstanceOf(Sequence::class, $sequence);
        $this->assertInstanceOf(SequenceInterface::class, $sequence);
        $this->assertSame($sequence->refresh()->getLastSequence(), 1);
    }
}
