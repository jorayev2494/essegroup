<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240327172452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE auth_codes (id INT AUTO_INCREMENT NOT NULL, author_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, expired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_298F90381D775834 (value), UNIQUE INDEX UNIQ_298F90383590D879 (author_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_devices (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_5F236E69C74F2195 (refresh_token), INDEX IDX_5F236E693590D879 (author_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE auth_members (uuid VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B84F20CE7927C74 (email), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_companies (uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_B15F20CAA85ECC4D (logo_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_statuses (id INT AUTO_INCREMENT NOT NULL, company_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, note VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_53670B7C92124A48 (company_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_cities (uuid VARCHAR(255) NOT NULL, country_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, company_uuid VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_99255A18564CDB42 (country_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_city_translations (id INT AUTO_INCREMENT NOT NULL, city_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_9C0F125C32316DCE (city_uuid), UNIQUE INDEX country_city_translation_idx (locale, city_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_countries (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, iso VARCHAR(3) NOT NULL, company_uuid VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculty_faculties (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, university_uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description text DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_357BE7CFA85ECC4D (logo_uuid), INDEX IDX_357BE7CF92124A48 (company_uuid), INDEX IDX_357BE7CF4C981D05 (university_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculty_faculty_translations (id INT AUTO_INCREMENT NOT NULL, faculty_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_861187CA5432B5F3 (faculty_uuid), UNIQUE INDEX faculty_faculty_translation_idx (locale, field, faculty_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculty_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_additional_documents (uuid VARCHAR(255) NOT NULL, application_uuid VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EA2F9D972693382E (application_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_biometric_photos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_equivalence_documents (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_passport_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_passports (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_school_attestat_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_school_attestats (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_status_note_translations (id INT AUTO_INCREMENT NOT NULL, status_uuid INT DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_1D35AD50E979FD32 (status_uuid), UNIQUE INDEX university_application_status_note_translation_idx (locale, field, status_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_statuses (id INT AUTO_INCREMENT NOT NULL, application_uuid VARCHAR(255) NOT NULL, value VARCHAR(20) NOT NULL, note LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9916C3B02693382E (application_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_transcript_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_transcripts (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_applications (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, university_uuid VARCHAR(255) NOT NULL, country_uuid VARCHAR(255) NOT NULL, passport_uuid VARCHAR(255) NOT NULL, school_attestat_uuid VARCHAR(255) NOT NULL, equivalence_document_uuid VARCHAR(255) NOT NULL, passport_translation_uuid VARCHAR(255) NOT NULL, transcript_uuid VARCHAR(255) NOT NULL, transcript_translation_uuid VARCHAR(255) NOT NULL, school_attestat_translation_uuid VARCHAR(255) NOT NULL, biometric_photo_uuid VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', father_name VARCHAR(255) DEFAULT NULL, mother_name VARCHAR(255) DEFAULT NULL, passport_number VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, friend_phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL, home_address VARCHAR(255) DEFAULT NULL, creator_role VARCHAR(255) NOT NULL, is_agreed_to_share_data TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D4005ABD92124A48 (company_uuid), INDEX IDX_D4005ABD4C981D05 (university_uuid), INDEX IDX_D4005ABD249D38BF (passport_uuid), INDEX IDX_D4005ABDB84402F5 (school_attestat_uuid), INDEX IDX_D4005ABDAC402B00 (equivalence_document_uuid), INDEX IDX_D4005ABD688D08B4 (passport_translation_uuid), INDEX IDX_D4005ABD38B6E413 (transcript_uuid), INDEX IDX_D4005ABDED7DC213 (transcript_translation_uuid), INDEX IDX_D4005ABDF7B95114 (school_attestat_translation_uuid), INDEX IDX_D4005ABD652ED7E7 (biometric_photo_uuid), INDEX IDX_D4005ABD564CDB42 (country_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_applications_departments (application_uuid VARCHAR(255) NOT NULL, department_uuid VARCHAR(255) NOT NULL, INDEX IDX_71A8C7B52693382E (application_uuid), INDEX IDX_71A8C7B5736537F3 (department_uuid), PRIMARY KEY(application_uuid, department_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_covers (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_degree_translations (id INT AUTO_INCREMENT NOT NULL, degree_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_BAD5F7ACA1FCCBE9 (degree_uuid), UNIQUE INDEX university_degree_translation_idx (locale, field, degree_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_degrees (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, INDEX IDX_6F95F9B392124A48 (company_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_department_translations (id INT AUTO_INCREMENT NOT NULL, department_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_31445EBD736537F3 (department_uuid), UNIQUE INDEX university_department_translation_idx (locale, field, department_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_departments (uuid VARCHAR(255) NOT NULL, university_uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, faculty_uuid VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description text DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, INDEX IDX_6F54A234C981D05 (university_uuid), INDEX IDX_6F54A2392124A48 (company_uuid), INDEX IDX_6F54A235432B5F3 (faculty_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_departments_degrees (department_uuid VARCHAR(255) NOT NULL, degree_uuid VARCHAR(255) NOT NULL, INDEX IDX_E6C78F71736537F3 (department_uuid), INDEX IDX_E6C78F71A1FCCBE9 (degree_uuid), PRIMARY KEY(department_uuid, degree_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_logos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_universities (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) NOT NULL, country_uuid VARCHAR(255) NOT NULL, city_uuid VARCHAR(255) NOT NULL, logo_uuid VARCHAR(255) DEFAULT NULL, cover_uuid VARCHAR(255) DEFAULT NULL, youtube_video_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, description text DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_C0A95993A85ECC4D (logo_uuid), UNIQUE INDEX UNIQ_C0A95993E5A3194F (cover_uuid), INDEX IDX_C0A9599392124A48 (company_uuid), INDEX IDX_C0A95993564CDB42 (country_uuid), INDEX IDX_C0A9599332316DCE (city_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_university_translations (id INT AUTO_INCREMENT NOT NULL, university_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_E9F000324C981D05 (university_uuid), UNIQUE INDEX university_university_translation_idx (locale, university_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE auth_codes ADD CONSTRAINT FK_298F90383590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid)');
        $this->addSql('ALTER TABLE auth_devices ADD CONSTRAINT FK_5F236E693590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid)');
        $this->addSql('ALTER TABLE company_companies ADD CONSTRAINT FK_B15F20CAA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES company_logos (uuid)');
        $this->addSql('ALTER TABLE company_statuses ADD CONSTRAINT FK_53670B7C92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('ALTER TABLE country_cities ADD CONSTRAINT FK_99255A18564CDB42 FOREIGN KEY (country_uuid) REFERENCES country_countries (uuid)');
        $this->addSql('ALTER TABLE country_city_translations ADD CONSTRAINT FK_9C0F125C32316DCE FOREIGN KEY (city_uuid) REFERENCES country_cities (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CFA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES faculty_logos (uuid)');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ADD CONSTRAINT FK_861187CA5432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE university_application_additional_documents ADD CONSTRAINT FK_EA2F9D972693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid)');
        $this->addSql('ALTER TABLE university_application_status_note_translations ADD CONSTRAINT FK_1D35AD50E979FD32 FOREIGN KEY (status_uuid) REFERENCES university_application_statuses (id)');
        $this->addSql('ALTER TABLE university_application_statuses ADD CONSTRAINT FK_9916C3B02693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD249D38BF FOREIGN KEY (passport_uuid) REFERENCES university_application_passports (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDB84402F5 FOREIGN KEY (school_attestat_uuid) REFERENCES university_application_school_attestats (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDAC402B00 FOREIGN KEY (equivalence_document_uuid) REFERENCES university_application_equivalence_documents (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD688D08B4 FOREIGN KEY (passport_translation_uuid) REFERENCES university_application_passport_translations (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD38B6E413 FOREIGN KEY (transcript_uuid) REFERENCES university_application_transcripts (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDED7DC213 FOREIGN KEY (transcript_translation_uuid) REFERENCES university_application_transcript_translations (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDF7B95114 FOREIGN KEY (school_attestat_translation_uuid) REFERENCES university_application_school_attestat_translations (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD652ED7E7 FOREIGN KEY (biometric_photo_uuid) REFERENCES university_application_biometric_photos (uuid)');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD564CDB42 FOREIGN KEY (country_uuid) REFERENCES country_countries (uuid)');
        $this->addSql('ALTER TABLE university_applications_departments ADD CONSTRAINT FK_71A8C7B52693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid)');
        $this->addSql('ALTER TABLE university_applications_departments ADD CONSTRAINT FK_71A8C7B5736537F3 FOREIGN KEY (department_uuid) REFERENCES university_departments (uuid)');
        $this->addSql('ALTER TABLE university_degree_translations ADD CONSTRAINT FK_BAD5F7ACA1FCCBE9 FOREIGN KEY (degree_uuid) REFERENCES university_degrees (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE university_degrees ADD CONSTRAINT FK_6F95F9B392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('ALTER TABLE university_department_translations ADD CONSTRAINT FK_31445EBD736537F3 FOREIGN KEY (department_uuid) REFERENCES university_departments (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A234C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid)');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A2392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A235432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid)');
        $this->addSql('ALTER TABLE university_departments_degrees ADD CONSTRAINT FK_E6C78F71736537F3 FOREIGN KEY (department_uuid) REFERENCES university_departments (uuid)');
        $this->addSql('ALTER TABLE university_departments_degrees ADD CONSTRAINT FK_E6C78F71A1FCCBE9 FOREIGN KEY (degree_uuid) REFERENCES university_degrees (uuid)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993A85ECC4D FOREIGN KEY (logo_uuid) REFERENCES university_logos (uuid)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993E5A3194F FOREIGN KEY (cover_uuid) REFERENCES university_covers (uuid)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993564CDB42 FOREIGN KEY (country_uuid) REFERENCES country_countries (uuid)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599332316DCE FOREIGN KEY (city_uuid) REFERENCES country_cities (uuid)');
        $this->addSql('ALTER TABLE university_university_translations ADD CONSTRAINT FK_E9F000324C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_codes DROP FOREIGN KEY FK_298F90383590D879');
        $this->addSql('ALTER TABLE auth_devices DROP FOREIGN KEY FK_5F236E693590D879');
        $this->addSql('ALTER TABLE company_companies DROP FOREIGN KEY FK_B15F20CAA85ECC4D');
        $this->addSql('ALTER TABLE company_statuses DROP FOREIGN KEY FK_53670B7C92124A48');
        $this->addSql('ALTER TABLE country_cities DROP FOREIGN KEY FK_99255A18564CDB42');
        $this->addSql('ALTER TABLE country_city_translations DROP FOREIGN KEY FK_9C0F125C32316DCE');
        $this->addSql('ALTER TABLE faculty_faculties DROP FOREIGN KEY FK_357BE7CFA85ECC4D');
        $this->addSql('ALTER TABLE faculty_faculties DROP FOREIGN KEY FK_357BE7CF92124A48');
        $this->addSql('ALTER TABLE faculty_faculties DROP FOREIGN KEY FK_357BE7CF4C981D05');
        $this->addSql('ALTER TABLE faculty_faculty_translations DROP FOREIGN KEY FK_861187CA5432B5F3');
        $this->addSql('ALTER TABLE university_application_additional_documents DROP FOREIGN KEY FK_EA2F9D972693382E');
        $this->addSql('ALTER TABLE university_application_status_note_translations DROP FOREIGN KEY FK_1D35AD50E979FD32');
        $this->addSql('ALTER TABLE university_application_statuses DROP FOREIGN KEY FK_9916C3B02693382E');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD92124A48');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD4C981D05');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD249D38BF');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDB84402F5');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDAC402B00');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD688D08B4');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD38B6E413');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDED7DC213');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDF7B95114');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD652ED7E7');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD564CDB42');
        $this->addSql('ALTER TABLE university_applications_departments DROP FOREIGN KEY FK_71A8C7B52693382E');
        $this->addSql('ALTER TABLE university_applications_departments DROP FOREIGN KEY FK_71A8C7B5736537F3');
        $this->addSql('ALTER TABLE university_degree_translations DROP FOREIGN KEY FK_BAD5F7ACA1FCCBE9');
        $this->addSql('ALTER TABLE university_degrees DROP FOREIGN KEY FK_6F95F9B392124A48');
        $this->addSql('ALTER TABLE university_department_translations DROP FOREIGN KEY FK_31445EBD736537F3');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A234C981D05');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A2392124A48');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A235432B5F3');
        $this->addSql('ALTER TABLE university_departments_degrees DROP FOREIGN KEY FK_E6C78F71736537F3');
        $this->addSql('ALTER TABLE university_departments_degrees DROP FOREIGN KEY FK_E6C78F71A1FCCBE9');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A95993A85ECC4D');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A95993E5A3194F');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A9599392124A48');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A95993564CDB42');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A9599332316DCE');
        $this->addSql('ALTER TABLE university_university_translations DROP FOREIGN KEY FK_E9F000324C981D05');
        $this->addSql('DROP TABLE auth_codes');
        $this->addSql('DROP TABLE auth_devices');
        $this->addSql('DROP TABLE auth_members');
        $this->addSql('DROP TABLE company_companies');
        $this->addSql('DROP TABLE company_logos');
        $this->addSql('DROP TABLE company_statuses');
        $this->addSql('DROP TABLE country_cities');
        $this->addSql('DROP TABLE country_city_translations');
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
        $this->addSql('DROP TABLE university_application_status_note_translations');
        $this->addSql('DROP TABLE university_application_statuses');
        $this->addSql('DROP TABLE university_application_transcript_translations');
        $this->addSql('DROP TABLE university_application_transcripts');
        $this->addSql('DROP TABLE university_applications');
        $this->addSql('DROP TABLE university_applications_departments');
        $this->addSql('DROP TABLE university_covers');
        $this->addSql('DROP TABLE university_degree_translations');
        $this->addSql('DROP TABLE university_degrees');
        $this->addSql('DROP TABLE university_department_translations');
        $this->addSql('DROP TABLE university_departments');
        $this->addSql('DROP TABLE university_departments_degrees');
        $this->addSql('DROP TABLE university_logos');
        $this->addSql('DROP TABLE university_universities');
        $this->addSql('DROP TABLE university_university_translations');
    }
}
