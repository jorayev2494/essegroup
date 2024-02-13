<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121212755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE company_university_translations_id_seq CASCADE');
        $this->addSql('CREATE TABLE university_covers (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_covers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_covers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_logos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_logos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_universities (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) DEFAULT NULL, cover_uuid VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0A95993989D9B62 ON university_universities (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0A95993A85ECC4D ON university_universities (logo_uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0A95993E5A3194F ON university_universities (cover_uuid)');
        $this->addSql('CREATE INDEX IDX_C0A9599392124A48 ON university_universities (company_uuid)');
        $this->addSql('COMMENT ON COLUMN university_universities.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_universities.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_university_translations (id SERIAL NOT NULL, university_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E9F000324C981D05 ON university_university_translations (university_uuid)');
        $this->addSql('CREATE UNIQUE INDEX university_university_translation_idx ON university_university_translations (locale, university_uuid, field)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993A85ECC4D FOREIGN KEY (logo_uuid) REFERENCES university_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993E5A3194F FOREIGN KEY (cover_uuid) REFERENCES university_covers (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_university_translations ADD CONSTRAINT FK_E9F000324C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_university_translations DROP CONSTRAINT fk_da559db34c981d05');
        $this->addSql('ALTER TABLE company_universities DROP CONSTRAINT fk_1dadaf1043db3b7d');
        $this->addSql('ALTER TABLE company_universities DROP CONSTRAINT fk_1dadaf1092124a48');
        $this->addSql('DROP TABLE company_university_translations');
        $this->addSql('DROP TABLE company_universities');
        $this->addSql('DROP TABLE company_university_logos');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE company_university_translations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE company_university_translations (id SERIAL NOT NULL, university_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX company_university_translation_idx ON company_university_translations (locale, university_uuid, field)');
        $this->addSql('CREATE INDEX idx_da559db34c981d05 ON company_university_translations (university_uuid)');
        $this->addSql('CREATE TABLE company_universities (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, avatar_uuid VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX idx_1dadaf1092124a48 ON company_universities (company_uuid)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1dadaf1043db3b7d ON company_universities (avatar_uuid)');
        $this->addSql('CREATE UNIQUE INDEX uniq_1dadaf10989d9b62 ON company_universities (slug)');
        $this->addSql('COMMENT ON COLUMN company_universities.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_universities.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE company_university_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN company_university_logos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN company_university_logos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE company_university_translations ADD CONSTRAINT fk_da559db34c981d05 FOREIGN KEY (university_uuid) REFERENCES company_universities (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT fk_1dadaf1043db3b7d FOREIGN KEY (avatar_uuid) REFERENCES company_university_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT fk_1dadaf1092124a48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A95993A85ECC4D');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A95993E5A3194F');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A9599392124A48');
        $this->addSql('ALTER TABLE university_university_translations DROP CONSTRAINT FK_E9F000324C981D05');
        $this->addSql('DROP TABLE university_covers');
        $this->addSql('DROP TABLE university_logos');
        $this->addSql('DROP TABLE university_universities');
        $this->addSql('DROP TABLE university_university_translations');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
    }
}
