<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112183723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE company_companies ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN company_companies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_companies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE company_statuses ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE company_statuses ADD updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN company_statuses.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_statuses.updated_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company_companies DROP created_at');
        $this->addSql('ALTER TABLE company_companies DROP updated_at');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses DROP created_at');
        $this->addSql('ALTER TABLE company_statuses DROP updated_at');
    }
}
