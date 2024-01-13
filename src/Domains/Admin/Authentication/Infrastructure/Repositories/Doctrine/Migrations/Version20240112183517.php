<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240112183517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE company_statuses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company_companies (uuid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B15F20CA5E237E06 ON company_companies (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B15F20CAA7A91E0B ON company_companies (domain)');
        $this->addSql('CREATE TABLE company_statuses (id INT NOT NULL, company_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53670B7C92124A48 ON company_statuses (company_uuid)');
        $this->addSql('ALTER TABLE company_statuses ADD CONSTRAINT FK_53670B7C92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE company_statuses_id_seq CASCADE');
        $this->addSql('ALTER TABLE company_statuses DROP CONSTRAINT FK_53670B7C92124A48');
        $this->addSql('DROP TABLE company_companies');
        $this->addSql('DROP TABLE company_statuses');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
    }
}
