<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122185645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE university_companies (uuid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4FFFDEE5E237E06 ON university_companies (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4FFFDEEA7A91E0B ON university_companies (domain)');
        $this->addSql('COMMENT ON COLUMN university_companies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_companies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A9599392124A48');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599392124A48 FOREIGN KEY (company_uuid) REFERENCES university_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A9599392124A48');
        $this->addSql('DROP TABLE university_companies');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT fk_c0a9599392124a48');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT fk_c0a9599392124a48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }
}
