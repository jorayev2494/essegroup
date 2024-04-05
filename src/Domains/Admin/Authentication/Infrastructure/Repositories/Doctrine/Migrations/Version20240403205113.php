<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403205113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD university_uuid VARCHAR(255) DEFAULT NULL, ADD faculty_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A234C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A235432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F54A234C981D05 ON university_departments (university_uuid)');
        $this->addSql('CREATE INDEX IDX_6F54A235432B5F3 ON university_departments (faculty_uuid)');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A234C981D05');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A235432B5F3');
        $this->addSql('DROP INDEX IDX_6F54A234C981D05 ON university_departments');
        $this->addSql('DROP INDEX IDX_6F54A235432B5F3 ON university_departments');
        $this->addSql('ALTER TABLE university_departments DROP university_uuid, DROP faculty_uuid, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
