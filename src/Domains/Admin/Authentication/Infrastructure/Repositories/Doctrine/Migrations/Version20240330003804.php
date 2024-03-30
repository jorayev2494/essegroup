<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240330003804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A234C981D05');
        $this->addSql('ALTER TABLE university_departments CHANGE university_uuid university_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A234C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A234C981D05');
        $this->addSql('ALTER TABLE university_departments CHANGE university_uuid university_uuid VARCHAR(255) NOT NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A234C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
