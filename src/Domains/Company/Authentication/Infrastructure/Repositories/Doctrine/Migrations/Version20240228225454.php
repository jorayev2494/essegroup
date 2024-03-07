<?php

declare(strict_types=1);

namespace Project\Domains\Company\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240228225454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE auth_codes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auth_codes (id INT NOT NULL, author_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90381D775834 ON auth_codes (value)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90383590D879 ON auth_codes (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_codes.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_companies (uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE auth_devices (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F236E69C74F2195 ON auth_devices (refresh_token)');
        $this->addSql('CREATE INDEX IDX_5F236E693590D879 ON auth_devices (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_devices.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_devices.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_members (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B84F20CE7927C74 ON auth_members (email)');
        $this->addSql('CREATE INDEX IDX_B84F20C92124A48 ON auth_members (company_uuid)');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_devices ADD CONSTRAINT FK_5F236E693590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_members ADD CONSTRAINT FK_B84F20C92124A48 FOREIGN KEY (company_uuid) REFERENCES auth_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE auth_codes_id_seq CASCADE');
        $this->addSql('ALTER TABLE auth_codes DROP CONSTRAINT FK_298F90383590D879');
        $this->addSql('ALTER TABLE auth_devices DROP CONSTRAINT FK_5F236E693590D879');
        $this->addSql('ALTER TABLE auth_members DROP CONSTRAINT FK_B84F20C92124A48');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_companies');
        $this->addSql('DROP TABLE auth_devices');
        $this->addSql('DROP TABLE auth_members');
    }
}
