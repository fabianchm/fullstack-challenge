<?php

declare(strict_types=1);

namespace Tests\Shared\Integration\Persistence\Doctrine;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class DoctrineRepositoryTest extends KernelTestCase 
{
    private DoctrineRepositoryTestAggregateRootRepository $doctrineRepository;

    protected function setUp(): void
    {
        $this->doctrineRepository = $this->getContainer()->get(DoctrineRepositoryTestAggregateRootRepository::class);

        parent::setUp();

        self::bootKernel(['environment' => 'test']);
    }

    public function test_new_exists_after_persist(): void
    {
        $aggregateRoot = new DoctrineRepositoryTestAggregateRoot(1);

        $this->doctrineRepository->persist($aggregateRoot);

        self::assertEquals($aggregateRoot, $this->doctrineRepository->search(1));
    }

    public function test_existing_is_updated_after_persist(): void
    {
        $aggregateRoot = new DoctrineRepositoryTestAggregateRoot(2);

        $this->doctrineRepository->persist($aggregateRoot);

        $aggregateRoot->changeId(3);
        $this->doctrineRepository->persist($aggregateRoot);

        self::assertEquals($aggregateRoot, $this->doctrineRepository->search(3));
    }

    public function test_existing_is_removed_after_remove(): void
    {
        $aggregateRoot = new DoctrineRepositoryTestAggregateRoot(4);

        $this->doctrineRepository->persist($aggregateRoot);

        $this->doctrineRepository->remove($aggregateRoot);

        self::assertNull($this->doctrineRepository->search(4));
    }
}
