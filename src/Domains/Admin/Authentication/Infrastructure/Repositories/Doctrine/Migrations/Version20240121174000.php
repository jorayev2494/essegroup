<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121174000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auth_codes (id INT NOT NULL, author_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, expired_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90381D775834 ON auth_codes (value)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_298F90383590D879 ON auth_codes (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_codes.expired_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_codes.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_devices (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5F236E69C74F2195 ON auth_devices (refresh_token)');
        $this->addSql('CREATE INDEX IDX_5F236E693590D879 ON auth_devices (author_uuid)');
        $this->addSql('COMMENT ON COLUMN auth_devices.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN auth_devices.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE auth_members (uuid VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B84F20CE7927C74 ON auth_members (email)');
        $this->addSql('CREATE TABLE company_companies (uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B15F20CAA85ECC4D ON company_companies (logo_uuid)');
        $this->addSql('COMMENT ON COLUMN company_companies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_companies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN company_logos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_logos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_statuses (id INT NOT NULL, company_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53670B7C92124A48 ON company_statuses (company_uuid)');
        $this->addSql('COMMENT ON COLUMN company_statuses.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_statuses.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_universities (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, avatar_uuid VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DADAF10989D9B62 ON company_universities (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1DADAF1043DB3B7D ON company_universities (avatar_uuid)');
        $this->addSql('CREATE INDEX IDX_1DADAF1092124A48 ON company_universities (company_uuid)');
        $this->addSql('COMMENT ON COLUMN company_universities.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_universities.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_university_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN company_university_logos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_university_logos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_university_translations (id SERIAL NOT NULL, university_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DA559DB34C981D05 ON company_university_translations (university_uuid)');
        $this->addSql('CREATE UNIQUE INDEX company_university_translation_idx ON company_university_translations (locale, university_uuid, field)');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_devices ADD CONSTRAINT FK_5F236E693590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_companies ADD CONSTRAINT FK_B15F20CAA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES company_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_statuses ADD CONSTRAINT FK_53670B7C92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT FK_1DADAF1043DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES company_university_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT FK_1DADAF1092124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_university_translations ADD CONSTRAINT FK_DA559DB34C981D05 FOREIGN KEY (university_uuid) REFERENCES company_universities (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE auth_codes DROP CONSTRAINT FK_298F90383590D879');
        $this->addSql('ALTER TABLE auth_devices DROP CONSTRAINT FK_5F236E693590D879');
        $this->addSql('ALTER TABLE company_companies DROP CONSTRAINT FK_B15F20CAA85ECC4D');
        $this->addSql('ALTER TABLE company_statuses DROP CONSTRAINT FK_53670B7C92124A48');
        $this->addSql('ALTER TABLE company_universities DROP CONSTRAINT FK_1DADAF1043DB3B7D');
        $this->addSql('ALTER TABLE company_universities DROP CONSTRAINT FK_1DADAF1092124A48');
        $this->addSql('ALTER TABLE company_university_translations DROP CONSTRAINT FK_DA559DB34C981D05');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_devices');
        $this->addSql('DROP TABLE auth_members');
        $this->addSql('DROP TABLE company_companies');
        $this->addSql('DROP TABLE company_logos');
        $this->addSql('DROP TABLE company_statuses');
        $this->addSql('DROP TABLE company_universities');
        $this->addSql('DROP TABLE company_university_logos');
        $this->addSql('DROP TABLE company_university_translations');
    }
}
