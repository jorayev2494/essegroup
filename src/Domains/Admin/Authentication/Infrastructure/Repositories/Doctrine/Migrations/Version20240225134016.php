<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240225134016 extends AbstractMigration
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
        $this->addSql('CREATE TABLE country_countries (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, iso VARCHAR(3) NOT NULL, company_uuid VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN country_countries.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN country_countries.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE faculty_faculties (uuid VARCHAR(255) NOT NULL, university_uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_357BE7CFA85ECC4D ON faculty_faculties (logo_uuid)');
        $this->addSql('CREATE INDEX IDX_357BE7CF4C981D05 ON faculty_faculties (university_uuid)');
        $this->addSql('COMMENT ON COLUMN faculty_faculties.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN faculty_faculties.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE faculty_faculty_translations (id SERIAL NOT NULL, faculty_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_861187CA5432B5F3 ON faculty_faculty_translations (faculty_uuid)');
        $this->addSql('CREATE UNIQUE INDEX faculty_faculty_translation_idx ON faculty_faculty_translations (locale, field, faculty_uuid)');
        $this->addSql('CREATE TABLE faculty_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN faculty_logos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN faculty_logos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_application_additional_documents (uuid VARCHAR(255) NOT NULL, application_uuid VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_EA2F9D972693382E ON university_application_additional_documents (application_uuid)');
        $this->addSql('COMMENT ON COLUMN university_application_additional_documents.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_additional_documents.updated_at IS \'(DC2Type:datetime_immutable)\'');
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
        $this->addSql('CREATE TABLE university_applications (uuid VARCHAR(255) NOT NULL, university_uuid VARCHAR(255) NOT NULL, faculty_uuid VARCHAR(255) NOT NULL, passport_uuid VARCHAR(255) NOT NULL, school_attestat_uuid VARCHAR(255) NOT NULL, equivalence_document_uuid VARCHAR(255) NOT NULL, passport_translation_uuid VARCHAR(255) NOT NULL, transcript_uuid VARCHAR(255) NOT NULL, transcript_translation_uuid VARCHAR(255) NOT NULL, school_attestat_translation_uuid VARCHAR(255) NOT NULL, biometric_photo_uuid VARCHAR(255) NOT NULL, country_uuid VARCHAR(255) DEFAULT NULL, full_name VARCHAR(255) NOT NULL, birthday TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, father_name VARCHAR(255) DEFAULT NULL, mother_name VARCHAR(255) DEFAULT NULL, passport_number VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, friend_phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, home_address VARCHAR(255) DEFAULT NULL, is_agreed_to_share_data BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_D4005ABD4C981D05 ON university_applications (university_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD5432B5F3 ON university_applications (faculty_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD249D38BF ON university_applications (passport_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDB84402F5 ON university_applications (school_attestat_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDAC402B00 ON university_applications (equivalence_document_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD688D08B4 ON university_applications (passport_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD38B6E413 ON university_applications (transcript_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDED7DC213 ON university_applications (transcript_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDF7B95114 ON university_applications (school_attestat_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD652ED7E7 ON university_applications (biometric_photo_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD564CDB42 ON university_applications (country_uuid)');
        $this->addSql('COMMENT ON COLUMN university_applications.birthday IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_applications.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_applications.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_companies (uuid VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4FFFDEE5E237E06 ON university_companies (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B4FFFDEEA7A91E0B ON university_companies (domain)');
        $this->addSql('COMMENT ON COLUMN university_companies.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_companies.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_countries (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, iso VARCHAR(3) NOT NULL, company_uuid VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_countries.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_countries.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_covers (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_covers.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_covers.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_department_translations (id SERIAL NOT NULL, department_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_31445EBD736537F3 ON university_department_translations (department_uuid)');
        $this->addSql('CREATE UNIQUE INDEX university_department_translation_idx ON university_department_translations (locale, field, department_uuid)');
        $this->addSql('CREATE TABLE university_departments (uuid VARCHAR(255) NOT NULL, faculty_uuid VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, is_active BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_6F54A235432B5F3 ON university_departments (faculty_uuid)');
        $this->addSql('COMMENT ON COLUMN university_departments.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_departments.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('COMMENT ON COLUMN university_logos.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_logos.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_universities (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) DEFAULT NULL, cover_uuid VARCHAR(255) DEFAULT NULL, youtube_video_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0A95993A85ECC4D ON university_universities (logo_uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0A95993E5A3194F ON university_universities (cover_uuid)');
        $this->addSql('CREATE INDEX IDX_C0A9599392124A48 ON university_universities (company_uuid)');
        $this->addSql('COMMENT ON COLUMN university_universities.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_universities.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE university_university_translations (id SERIAL NOT NULL, university_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E9F000324C981D05 ON university_university_translations (university_uuid)');
        $this->addSql('CREATE UNIQUE INDEX university_university_translation_idx ON university_university_translations (locale, university_uuid, field)');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE auth_devices ADD CONSTRAINT FK_5F236E693590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_companies ADD CONSTRAINT FK_B15F20CAA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES company_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_statuses ADD CONSTRAINT FK_53670B7C92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT FK_1DADAF1043DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES company_university_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_universities ADD CONSTRAINT FK_1DADAF1092124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE company_university_translations ADD CONSTRAINT FK_DA559DB34C981D05 FOREIGN KEY (university_uuid) REFERENCES company_universities (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CFA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES faculty_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE faculty_faculty_translations ADD CONSTRAINT FK_861187CA5432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_application_additional_documents ADD CONSTRAINT FK_EA2F9D972693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_application_statuses ADD CONSTRAINT FK_9916C3B02693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD5432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD249D38BF FOREIGN KEY (passport_uuid) REFERENCES university_application_passports (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDB84402F5 FOREIGN KEY (school_attestat_uuid) REFERENCES university_application_school_attestats (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDAC402B00 FOREIGN KEY (equivalence_document_uuid) REFERENCES university_application_equivalence_documents (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD688D08B4 FOREIGN KEY (passport_translation_uuid) REFERENCES university_application_passport_translations (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD38B6E413 FOREIGN KEY (transcript_uuid) REFERENCES university_application_transcripts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDED7DC213 FOREIGN KEY (transcript_translation_uuid) REFERENCES university_application_transcript_translations (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDF7B95114 FOREIGN KEY (school_attestat_translation_uuid) REFERENCES university_application_school_attestat_translations (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD652ED7E7 FOREIGN KEY (biometric_photo_uuid) REFERENCES university_application_biometric_photos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD564CDB42 FOREIGN KEY (country_uuid) REFERENCES university_countries (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_department_translations ADD CONSTRAINT FK_31445EBD736537F3 FOREIGN KEY (department_uuid) REFERENCES university_departments (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A235432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993A85ECC4D FOREIGN KEY (logo_uuid) REFERENCES university_logos (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993E5A3194F FOREIGN KEY (cover_uuid) REFERENCES university_covers (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599392124A48 FOREIGN KEY (company_uuid) REFERENCES university_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_university_translations ADD CONSTRAINT FK_E9F000324C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE faculty_faculties DROP CONSTRAINT FK_357BE7CFA85ECC4D');
        $this->addSql('ALTER TABLE faculty_faculties DROP CONSTRAINT FK_357BE7CF4C981D05');
        $this->addSql('ALTER TABLE faculty_faculty_translations DROP CONSTRAINT FK_861187CA5432B5F3');
        $this->addSql('ALTER TABLE university_application_additional_documents DROP CONSTRAINT FK_EA2F9D972693382E');
        $this->addSql('ALTER TABLE university_application_statuses DROP CONSTRAINT FK_9916C3B02693382E');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD4C981D05');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD5432B5F3');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD249D38BF');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDB84402F5');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDAC402B00');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD688D08B4');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD38B6E413');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDED7DC213');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABDF7B95114');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD652ED7E7');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD564CDB42');
        $this->addSql('ALTER TABLE university_department_translations DROP CONSTRAINT FK_31445EBD736537F3');
        $this->addSql('ALTER TABLE university_departments DROP CONSTRAINT FK_6F54A235432B5F3');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A95993A85ECC4D');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A95993E5A3194F');
        $this->addSql('ALTER TABLE university_universities DROP CONSTRAINT FK_C0A9599392124A48');
        $this->addSql('ALTER TABLE university_university_translations DROP CONSTRAINT FK_E9F000324C981D05');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_devices');
        $this->addSql('DROP TABLE auth_members');
        $this->addSql('DROP TABLE company_companies');
        $this->addSql('DROP TABLE company_logos');
        $this->addSql('DROP TABLE company_statuses');
        $this->addSql('DROP TABLE company_universities');
        $this->addSql('DROP TABLE company_university_logos');
        $this->addSql('DROP TABLE company_university_translations');
        $this->addSql('DROP TABLE country_countries');
        $this->addSql('DROP TABLE faculty_faculties');
        $this->addSql('DROP TABLE faculty_faculty_translations');
        $this->addSql('DROP TABLE faculty_logos');
        $this->addSql('DROP TABLE university_application_additional_documents');
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
        $this->addSql('DROP TABLE university_companies');
        $this->addSql('DROP TABLE university_countries');
        $this->addSql('DROP TABLE university_covers');
        $this->addSql('DROP TABLE university_department_translations');
        $this->addSql('DROP TABLE university_departments');
        $this->addSql('DROP TABLE university_logos');
        $this->addSql('DROP TABLE university_universities');
        $this->addSql('DROP TABLE university_university_translations');
    }
}