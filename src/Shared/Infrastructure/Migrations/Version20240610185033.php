<?php

declare(strict_types=1);

namespace Finizens\Shared\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240610185033 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE finance_allocations (shares INT NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8');
        $this->addSql('CREATE TABLE finance_orders (portfolio INT NOT NULL, allocation INT NOT NULL, shares INT NOT NULL, type VARCHAR(255) NOT NULL, completed TINYINT(1) NOT NULL, id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8');
        $this->addSql('CREATE TABLE finance_portfolio_allocation_collection (portfolio_id INT NOT NULL, PRIMARY KEY(portfolio_id)) DEFAULT CHARACTER SET UTF8');
        $this->addSql('CREATE TABLE finance_portfolio_allocation_collection_join (portfolio_id INT NOT NULL, allocation_id INT NOT NULL, INDEX IDX_D003D9C2B96B5643 (portfolio_id), UNIQUE INDEX UNIQ_D003D9C29C83F4B2 (allocation_id), PRIMARY KEY(portfolio_id, allocation_id)) DEFAULT CHARACTER SET UTF8');
        $this->addSql('CREATE TABLE finance_portfolios (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8');
        $this->addSql('ALTER TABLE finance_portfolio_allocation_collection_join ADD CONSTRAINT FK_D003D9C2B96B5643 FOREIGN KEY (portfolio_id) REFERENCES finance_portfolio_allocation_collection (portfolio_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE finance_portfolio_allocation_collection_join ADD CONSTRAINT FK_D003D9C29C83F4B2 FOREIGN KEY (allocation_id) REFERENCES finance_allocations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE finance_portfolios ADD CONSTRAINT FK_8AA099B6BF396750 FOREIGN KEY (id) REFERENCES finance_portfolio_allocation_collection (portfolio_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE finance_portfolio_allocation_collection_join DROP FOREIGN KEY FK_D003D9C2B96B5643');
        $this->addSql('ALTER TABLE finance_portfolio_allocation_collection_join DROP FOREIGN KEY FK_D003D9C29C83F4B2');
        $this->addSql('ALTER TABLE finance_portfolios DROP FOREIGN KEY FK_8AA099B6BF396750');
        $this->addSql('DROP TABLE finance_allocations');
        $this->addSql('DROP TABLE finance_orders');
        $this->addSql('DROP TABLE finance_portfolio_allocation_collection');
        $this->addSql('DROP TABLE finance_portfolio_allocation_collection_join');
        $this->addSql('DROP TABLE finance_portfolios');
    }
}
