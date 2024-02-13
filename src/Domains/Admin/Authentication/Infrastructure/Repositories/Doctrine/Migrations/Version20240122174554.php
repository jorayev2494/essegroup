<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122174554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT FK_1DADAF1043DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES company_university_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT FK_1DADAF1092124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_university_translations ADD CONSTRAINT FK_DA559DB34C981D05 FOREIGN KEY (university_uuid) REFERENCES company_universities (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid DROP NOT NULL');
        $this->addSql('ALTER TABLE university_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE company_universities DROP CONSTRAINT FK_1DADAF1043DB3B7D');
        $this->addSql('ALTER TABLE company_universities DROP CONSTRAINT FK_1DADAF1092124A48');
        $this->addSql('ALTER TABLE company_university_translations DROP CONSTRAINT FK_DA559DB34C981D05');
        $this->addSql('DROP TABLE company_universities');
        $this->addSql('DROP TABLE company_university_logos');
        $this->addSql('DROP TABLE company_university_translations');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid SET NOT NULL');
        $this->addSql('ALTER TABLE university_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
    }
}
