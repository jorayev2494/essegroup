<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240202220421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
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
        $this->addSql('ALTER TABLE faculty_faculties ADD university_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_357BE7CF4C981D05 ON faculty_faculties (university_uuid)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
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
        $this->addSql('ALTER TABLE university_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER company_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER youtube_video_id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER label TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_universities ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculty_translations ALTER faculty_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_university_translations ALTER university_uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER domain TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_companies ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties DROP CONSTRAINT FK_357BE7CF4C981D05');
        $this->addSql('DROP INDEX IDX_357BE7CF4C981D05');
        $this->addSql('ALTER TABLE faculty_faculties DROP university_uuid');
        $this->addSql('ALTER TABLE faculty_faculties ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE faculty_faculties ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER slug TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_universities ALTER name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER value TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE company_statuses ALTER note TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE university_university_translations ALTER university_uuid TYPE VARCHAR(255)');
    }
}
