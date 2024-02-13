<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240211180203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE university_application_statuses_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE university_application_biometric_photos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_biometric_photos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_biometric_photos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_equivalence_documents (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_equivalence_documents.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_equivalence_documents.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_passport_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_passport_translations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_passport_translations.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_passports (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_passports.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_passports.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_school_attestat_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_school_attestat_translations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_school_attestat_translations.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_school_attestats (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_school_attestats.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_school_attestats.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_statuses (id INT NOT NULL, application_uuid VARCHAR(255) NOT NULL, value VARCHAR(20) NOT NULL, note TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9916C3B02693382E ON university_application_statuses (application_uuid)');
        $this->addSql('COMMENT ON COLUMN university_application_statuses.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_statuses.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_transcript_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_transcript_translations.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_transcript_translations.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_transcripts (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_application_transcripts.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_transcripts.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_applications (uuid VARCHAR(255) NOT NULL, passport_uuid VARCHAR(255) NOT NULL, school_attestat_uuid VARCHAR(255) NOT NULL, equivalence_document_uuid VARCHAR(255) NOT NULL, passport_translation_uuid VARCHAR(255) NOT NULL, transcript_uuid VARCHAR(255) NOT NULL, school_attestat_translation_uuid VARCHAR(255) NOT NULL, biometric_photo_uuid VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_D4005ABD249D38BF ON university_applications (passport_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDB84402F5 ON university_applications (school_attestat_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDAC402B00 ON university_applications (equivalence_document_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD688D08B4 ON university_applications (passport_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD38B6E413 ON university_applications (transcript_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDF7B95114 ON university_applications (school_attestat_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD652ED7E7 ON university_applications (biometric_photo_uuid)');
        $this->addSql('COMMENT ON COLUMN university_applications.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_applications.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE university_application_statuses ADD CONSTRAINT FK_9916C3B02693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD249D38BF FOREIGN KEY (passport_uuid) REFERENCES university_application_passports (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDB84402F5 FOREIGN KEY (school_attestat_uuid) REFERENCES university_application_school_attestats (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDAC402B00 FOREIGN KEY (equivalence_document_uuid) REFERENCES university_application_equivalence_documents (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD688D08B4 FOREIGN KEY (passport_translation_uuid) REFERENCES university_application_passport_translations (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD38B6E413 FOREIGN KEY (transcript_uuid) REFERENCES university_application_transcripts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDF7B95114 FOREIGN KEY (school_attestat_translation_uuid) REFERENCES university_application_school_attestat_translations (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD652ED7E7 FOREIGN KEY (biometric_photo_uuid) REFERENCES university_application_biometric_photos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_department_translations ALTER department_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER youtube_video_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE university_application_statuses_id_seq CASCADE');
        $this->addSql('ALTER TABLE university_application_statuses DROP CONSTRAINT FK_9916C3B02693382E');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD249D38BF');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDB84402F5');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDAC402B00');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD688D08B4');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD38B6E413');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDF7B95114');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD652ED7E7');
        $this->addSql('DROP TABLE university_application_biometric_photos');
        $this->addSql('DROP TABLE university_application_equivalence_documents');
        $this->addSql('DROP TABLE university_application_passport_translations');
        $this->addSql('DROP TABLE university_application_passports');
        $this->addSql('DROP TABLE university_application_school_attestat_translations');
        $this->addSql('DROP TABLE university_application_school_attestats');
        $this->addSql('DROP TABLE university_application_statuses');
        $this->addSql('DROP TABLE university_application_transcript_translations');
        $this->addSql('DROP TABLE university_application_transcripts');
        $this->addSql('DROP TABLE university_applications');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_department_translations ALTER department_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER youtube_video_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
    }
}
