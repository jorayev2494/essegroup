<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240629010339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129249D38BF, ADD UNIQUE INDEX UNIQ_17E2C129249D38BF (passport_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129688D08B4, ADD UNIQUE INDEX UNIQ_17E2C129688D08B4 (passport_translation_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129B84402F5, ADD UNIQUE INDEX UNIQ_17E2C129B84402F5 (school_attestat_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C12938B6E413, ADD UNIQUE INDEX UNIQ_17E2C12938B6E413 (transcript_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129AC402B00, ADD UNIQUE INDEX UNIQ_17E2C129AC402B00 (equivalence_document_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129F7B95114, ADD UNIQUE INDEX UNIQ_17E2C129F7B95114 (school_attestat_translation_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129652ED7E7, ADD UNIQUE INDEX UNIQ_17E2C129652ED7E7 (biometric_photo_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX IDX_17E2C129ED7DC213, ADD UNIQUE INDEX UNIQ_17E2C129ED7DC213 (transcript_translation_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129249D38BF, ADD INDEX IDX_17E2C129249D38BF (passport_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129688D08B4, ADD INDEX IDX_17E2C129688D08B4 (passport_translation_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129B84402F5, ADD INDEX IDX_17E2C129B84402F5 (school_attestat_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C12938B6E413, ADD INDEX IDX_17E2C12938B6E413 (transcript_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129AC402B00, ADD INDEX IDX_17E2C129AC402B00 (equivalence_document_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129F7B95114, ADD INDEX IDX_17E2C129F7B95114 (school_attestat_translation_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129652ED7E7, ADD INDEX IDX_17E2C129652ED7E7 (biometric_photo_uuid)');
        $this->addSql('ALTER TABLE student_students DROP INDEX UNIQ_17E2C129ED7DC213, ADD INDEX IDX_17E2C129ED7DC213 (transcript_translation_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
