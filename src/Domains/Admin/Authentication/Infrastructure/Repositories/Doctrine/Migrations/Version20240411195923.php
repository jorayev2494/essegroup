<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411195923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD652ED7E7');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDAC402B00');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD688D08B4');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD249D38BF');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDF7B95114');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDB84402F5');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDED7DC213');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD38B6E413');
        $this->addSql('CREATE TABLE student_avatars (uuid VARCHAR(255) NOT NULL, student_uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_5DFF30D8EE5C2B7E (student_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_additional_documents (uuid VARCHAR(255) NOT NULL, student_uuid VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F475557BEE5C2B7E (student_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_biometric_photos (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_equivalence_documents (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_passport_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_passports (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_school_attestat_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_school_attestats (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_transcript_translations (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_student_transcripts (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_students (uuid VARCHAR(255) NOT NULL, company_uuid VARCHAR(255) DEFAULT NULL, nationality_uuid VARCHAR(255) DEFAULT NULL, country_of_residence_uuid VARCHAR(255) DEFAULT NULL, high_school_country_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', passport_uuid VARCHAR(255) NOT NULL, passport_translation_uuid VARCHAR(255) NOT NULL, school_attestat_uuid VARCHAR(255) NOT NULL, transcript_uuid VARCHAR(255) NOT NULL, equivalence_document_uuid VARCHAR(255) NOT NULL, school_attestat_translation_uuid VARCHAR(255) NOT NULL, biometric_photo_uuid VARCHAR(255) NOT NULL, transcript_translation_uuid VARCHAR(255) NOT NULL, birthday DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', gender VARCHAR(10) DEFAULT NULL, marital_type VARCHAR(10) DEFAULT NULL, phone VARCHAR(50) NOT NULL, friend_phone VARCHAR(50) DEFAULT NULL, email VARCHAR(75) NOT NULL, home_address VARCHAR(255) DEFAULT NULL, creator_role VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, father_name VARCHAR(255) DEFAULT NULL, mother_name VARCHAR(255) DEFAULT NULL, passport_number VARCHAR(50) NOT NULL, passport_date_of_issue DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', passport_date_of_expiry DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', high_school_name VARCHAR(255) NOT NULL, high_school_grade_average VARCHAR(5) DEFAULT NULL, INDEX IDX_17E2C12992124A48 (company_uuid), INDEX IDX_17E2C12919D8D522 (nationality_uuid), INDEX IDX_17E2C129C57B1FBB (country_of_residence_uuid), INDEX IDX_17E2C129BA277C91 (high_school_country_uuid), INDEX IDX_17E2C129249D38BF (passport_uuid), INDEX IDX_17E2C129688D08B4 (passport_translation_uuid), INDEX IDX_17E2C129B84402F5 (school_attestat_uuid), INDEX IDX_17E2C12938B6E413 (transcript_uuid), INDEX IDX_17E2C129AC402B00 (equivalence_document_uuid), INDEX IDX_17E2C129F7B95114 (school_attestat_translation_uuid), INDEX IDX_17E2C129652ED7E7 (biometric_photo_uuid), INDEX IDX_17E2C129ED7DC213 (transcript_translation_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student_avatars ADD CONSTRAINT FK_5DFF30D8EE5C2B7E FOREIGN KEY (student_uuid) REFERENCES student_students (uuid)');
        $this->addSql('ALTER TABLE student_student_additional_documents ADD CONSTRAINT FK_F475557BEE5C2B7E FOREIGN KEY (student_uuid) REFERENCES student_students (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C12992124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C12919D8D522 FOREIGN KEY (nationality_uuid) REFERENCES country_countries (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129C57B1FBB FOREIGN KEY (country_of_residence_uuid) REFERENCES country_countries (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129BA277C91 FOREIGN KEY (high_school_country_uuid) REFERENCES country_countries (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129249D38BF FOREIGN KEY (passport_uuid) REFERENCES student_student_passports (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129688D08B4 FOREIGN KEY (passport_translation_uuid) REFERENCES student_student_passport_translations (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129B84402F5 FOREIGN KEY (school_attestat_uuid) REFERENCES student_student_school_attestats (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C12938B6E413 FOREIGN KEY (transcript_uuid) REFERENCES student_student_transcripts (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129AC402B00 FOREIGN KEY (equivalence_document_uuid) REFERENCES student_student_equivalence_documents (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129F7B95114 FOREIGN KEY (school_attestat_translation_uuid) REFERENCES student_student_school_attestat_translations (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129652ED7E7 FOREIGN KEY (biometric_photo_uuid) REFERENCES student_student_biometric_photos (uuid)');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C129ED7DC213 FOREIGN KEY (transcript_translation_uuid) REFERENCES student_student_transcript_translations (uuid)');
        $this->addSql('ALTER TABLE university_application_additional_documents DROP FOREIGN KEY FK_EA2F9D972693382E');
        $this->addSql('DROP TABLE university_application_additional_documents');
        $this->addSql('DROP TABLE university_application_biometric_photos');
        $this->addSql('DROP TABLE university_application_equivalence_documents');
        $this->addSql('DROP TABLE university_application_passport_translations');
        $this->addSql('DROP TABLE university_application_passports');
        $this->addSql('DROP TABLE university_application_school_attestat_translations');
        $this->addSql('DROP TABLE university_application_school_attestats');
        $this->addSql('DROP TABLE university_application_transcript_translations');
        $this->addSql('DROP TABLE university_application_transcripts');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE language_languages ADD iso VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD92124A48');
        $this->addSql('DROP INDEX IDX_D4005ABD249D38BF ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABD38B6E413 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABD652ED7E7 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABD688D08B4 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABD92124A48 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABDAC402B00 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABDB84402F5 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABDED7DC213 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABDF7B95114 ON university_applications');
        $this->addSql('ALTER TABLE university_applications ADD student_uuid VARCHAR(255) DEFAULT NULL, ADD alias_uuid VARCHAR(255) DEFAULT NULL, ADD language_uuid VARCHAR(255) DEFAULT NULL, ADD degree_uuid VARCHAR(255) DEFAULT NULL, DROP company_uuid, DROP passport_uuid, DROP school_attestat_uuid, DROP equivalence_document_uuid, DROP passport_translation_uuid, DROP transcript_uuid, DROP transcript_translation_uuid, DROP school_attestat_translation_uuid, DROP biometric_photo_uuid, DROP full_name, DROP birthday, DROP father_name, DROP mother_name, DROP passport_number, DROP phone, DROP friend_phone, DROP email, DROP home_address');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDEE5C2B7E FOREIGN KEY (student_uuid) REFERENCES student_students (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD42532186 FOREIGN KEY (alias_uuid) REFERENCES university_aliases (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDE376BAEA FOREIGN KEY (language_uuid) REFERENCES language_languages (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDA1FCCBE9 FOREIGN KEY (degree_uuid) REFERENCES university_degrees (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D4005ABDEE5C2B7E ON university_applications (student_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD42532186 ON university_applications (alias_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDE376BAEA ON university_applications (language_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDA1FCCBE9 ON university_applications (degree_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDEE5C2B7E');
        $this->addSql('CREATE TABLE university_application_additional_documents (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, application_uuid VARCHAR(255) CHARACTER SET utf8mb3 DEFAULT NULL COLLATE `utf8mb3_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_EA2F9D972693382E (application_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_biometric_photos (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_equivalence_documents (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_passport_translations (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_passports (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_school_attestat_translations (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_school_attestats (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_transcript_translations (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE university_application_transcripts (uuid VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, extension VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, size INT NOT NULL, path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, full_path VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, file_original_name VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, url_pattern VARCHAR(255) CHARACTER SET utf8mb3 NOT NULL COLLATE `utf8mb3_unicode_ci`, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE university_application_additional_documents ADD CONSTRAINT FK_EA2F9D972693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE student_avatars DROP FOREIGN KEY FK_5DFF30D8EE5C2B7E');
        $this->addSql('ALTER TABLE student_student_additional_documents DROP FOREIGN KEY FK_F475557BEE5C2B7E');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C12992124A48');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C12919D8D522');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129C57B1FBB');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129BA277C91');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129249D38BF');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129688D08B4');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129B84402F5');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C12938B6E413');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129AC402B00');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129F7B95114');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129652ED7E7');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C129ED7DC213');
        $this->addSql('DROP TABLE student_avatars');
        $this->addSql('DROP TABLE student_student_additional_documents');
        $this->addSql('DROP TABLE student_student_biometric_photos');
        $this->addSql('DROP TABLE student_student_equivalence_documents');
        $this->addSql('DROP TABLE student_student_passport_translations');
        $this->addSql('DROP TABLE student_student_passports');
        $this->addSql('DROP TABLE student_student_school_attestat_translations');
        $this->addSql('DROP TABLE student_student_school_attestats');
        $this->addSql('DROP TABLE student_student_transcript_translations');
        $this->addSql('DROP TABLE student_student_transcripts');
        $this->addSql('DROP TABLE student_students');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE language_languages DROP iso');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABD42532186');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDE376BAEA');
        $this->addSql('ALTER TABLE university_applications DROP FOREIGN KEY FK_D4005ABDA1FCCBE9');
        $this->addSql('DROP INDEX IDX_D4005ABDEE5C2B7E ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABD42532186 ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABDE376BAEA ON university_applications');
        $this->addSql('DROP INDEX IDX_D4005ABDA1FCCBE9 ON university_applications');
        $this->addSql('ALTER TABLE university_applications ADD company_uuid VARCHAR(255) DEFAULT NULL, ADD passport_uuid VARCHAR(255) NOT NULL, ADD school_attestat_uuid VARCHAR(255) NOT NULL, ADD equivalence_document_uuid VARCHAR(255) NOT NULL, ADD passport_translation_uuid VARCHAR(255) NOT NULL, ADD transcript_uuid VARCHAR(255) NOT NULL, ADD transcript_translation_uuid VARCHAR(255) NOT NULL, ADD school_attestat_translation_uuid VARCHAR(255) NOT NULL, ADD biometric_photo_uuid VARCHAR(255) NOT NULL, ADD full_name VARCHAR(255) NOT NULL, ADD birthday DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD father_name VARCHAR(255) DEFAULT NULL, ADD mother_name VARCHAR(255) DEFAULT NULL, ADD passport_number VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD friend_phone VARCHAR(255) DEFAULT NULL, ADD email VARCHAR(255) NOT NULL, ADD home_address VARCHAR(255) DEFAULT NULL, DROP student_uuid, DROP alias_uuid, DROP language_uuid, DROP degree_uuid');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD652ED7E7 FOREIGN KEY (biometric_photo_uuid) REFERENCES university_application_biometric_photos (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD249D38BF FOREIGN KEY (passport_uuid) REFERENCES university_application_passports (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD38B6E413 FOREIGN KEY (transcript_uuid) REFERENCES university_application_transcripts (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD688D08B4 FOREIGN KEY (passport_translation_uuid) REFERENCES university_application_passport_translations (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDAC402B00 FOREIGN KEY (equivalence_document_uuid) REFERENCES university_application_equivalence_documents (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDB84402F5 FOREIGN KEY (school_attestat_uuid) REFERENCES university_application_school_attestats (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDED7DC213 FOREIGN KEY (transcript_translation_uuid) REFERENCES university_application_transcript_translations (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABDF7B95114 FOREIGN KEY (school_attestat_translation_uuid) REFERENCES university_application_school_attestat_translations (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D4005ABD249D38BF ON university_applications (passport_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD38B6E413 ON university_applications (transcript_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD652ED7E7 ON university_applications (biometric_photo_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD688D08B4 ON university_applications (passport_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD92124A48 ON university_applications (company_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDAC402B00 ON university_applications (equivalence_document_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDB84402F5 ON university_applications (school_attestat_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDED7DC213 ON university_applications (transcript_translation_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABDF7B95114 ON university_applications (school_attestat_translation_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}