<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209194501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE university_department_translations (id SERIAL NOT NULL, department_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_31445EBD736537F3 ON university_department_translations (department_uuid)');
        $this->addSql('CREATE UNIQUE INDEX university_department_translation_idx ON university_department_translations (locale, field, department_uuid)');
        $this->addSql('ALTER TABLE university_department_translations ADD CONSTRAINT FK_31445EBD736537F3 FOREIGN KEY (department_uuid) REFERENCES university_departments (uuid) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
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
        $this->addSql('ALTER TABLE faculty_faculties ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER INDEX idx_4c954c105432b5f3 RENAME TO IDX_6F54A235432B5F3');
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
        $this->addSql('ALTER TABLE university_department_translations DROP CONSTRAINT FK_31445EBD736537F3');
        $this->addSql('DROP TABLE university_department_translations');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
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
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_departments ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER INDEX idx_6f54a235432b5f3 RENAME TO idx_4c954c105432b5f3');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }
}
