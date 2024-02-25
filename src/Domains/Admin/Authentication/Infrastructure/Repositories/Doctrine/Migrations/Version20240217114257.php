<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240217114257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE university_application_additional_documents (uuid VARCHAR(255) NOT NULL, application_uuid VARCHAR(255) DEFAULT NULL, description VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_EA2F9D972693382E ON university_application_additional_documents (application_uuid)');
        $this->addSql('COMMENT ON COLUMN university_application_additional_documents.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN university_application_additional_documents.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE university_application_additional_documents ADD CONSTRAINT FK_EA2F9D972693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE country_countries ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER application_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER value TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE university_applications ADD university_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_applications ADD faculty_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_applications ADD full_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_applications ADD birthday TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE university_applications ADD father_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_applications ADD mother_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_applications ADD passport_number VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_applications ADD friend_phone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_applications ADD home_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_applications ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER phone TYPE VARCHAR(255)');
        $this->addSql('COMMENT ON COLUMN university_applications.birthday IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE university_applications ADD CONSTRAINT FK_D4005ABD5432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_D4005ABD4C981D05 ON university_applications (university_uuid)');
        $this->addSql('CREATE INDEX IDX_D4005ABD5432B5F3 ON university_applications (faculty_uuid)');
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
        $this->addSql('ALTER TABLE university_application_additional_documents DROP CONSTRAINT FK_EA2F9D972693382E');
        $this->addSql('DROP TABLE university_application_additional_documents');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD4C981D05');
        $this->addSql('ALTER TABLE university_applications DROP CONSTRAINT FK_D4005ABD5432B5F3');
        $this->addSql('DROP INDEX IDX_D4005ABD4C981D05');
        $this->addSql('DROP INDEX IDX_D4005ABD5432B5F3');
        $this->addSql('ALTER TABLE university_applications DROP university_uuid');
        $this->addSql('ALTER TABLE university_applications DROP faculty_uuid');
        $this->addSql('ALTER TABLE university_applications DROP full_name');
        $this->addSql('ALTER TABLE university_applications DROP birthday');
        $this->addSql('ALTER TABLE university_applications DROP father_name');
        $this->addSql('ALTER TABLE university_applications DROP mother_name');
        $this->addSql('ALTER TABLE university_applications DROP passport_number');
        $this->addSql('ALTER TABLE university_applications DROP friend_phone');
        $this->addSql('ALTER TABLE university_applications DROP home_address');
        $this->addSql('ALTER TABLE university_applications ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER application_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER value TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE country_countries ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER youtube_video_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_department_translations ALTER department_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
    }
}
