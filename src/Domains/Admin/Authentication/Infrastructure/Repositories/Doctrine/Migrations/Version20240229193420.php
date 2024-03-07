<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229193420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_members DROP CONSTRAINT fk_b84f20c92124a48');
        $this->addSql('DROP TABLE auth_companies');
        $this->addSql('DROP INDEX idx_b84f20c92124a48');
        $this->addSql('ALTER TABLE auth_members DROP company_uuid');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER email TYPE VARCHAR(255)');
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
        $this->addSql('ALTER TABLE university_application_additional_documents ALTER application_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER application_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER value TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE university_applications ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER father_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER mother_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER passport_number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER friend_phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER home_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_department_translations ALTER department_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER youtube_video_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE auth_companies (uuid VARCHAR(255) NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER youtube_video_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER application_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_statuses ALTER value TYPE VARCHAR(20)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ADD company_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ADD CONSTRAINT fk_b84f20c92124a48 FOREIGN KEY (company_uuid) REFERENCES auth_companies (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b84f20c92124a48 ON auth_members (company_uuid)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_application_additional_documents ALTER application_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_department_translations ALTER department_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE country_countries ALTER iso TYPE VARCHAR(3)');
        $this->addSql('ALTER TABLE country_countries ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER father_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER mother_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER passport_number TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER friend_phone TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_applications ALTER home_address TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
    }
}
