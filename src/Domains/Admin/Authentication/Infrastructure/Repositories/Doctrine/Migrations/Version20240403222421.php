<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403222421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD alias_uuid VARCHAR(255) DEFAULT NULL, ADD language_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A2342532186 FOREIGN KEY (alias_uuid) REFERENCES university_aliases (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A23E376BAEA FOREIGN KEY (language_uuid) REFERENCES language_languages (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F54A2342532186 ON university_departments (alias_uuid)');
        $this->addSql('CREATE INDEX IDX_6F54A23E376BAEA ON university_departments (language_uuid)');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A2342532186');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A23E376BAEA');
        $this->addSql('DROP INDEX IDX_6F54A2342532186 ON university_departments');
        $this->addSql('DROP INDEX IDX_6F54A23E376BAEA ON university_departments');
        $this->addSql('ALTER TABLE university_departments DROP alias_uuid, DROP language_uuid, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
