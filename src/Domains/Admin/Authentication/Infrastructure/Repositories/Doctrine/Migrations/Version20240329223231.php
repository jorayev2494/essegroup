<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240329223231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_degrees DROP FOREIGN KEY FK_6F95F9B392124A48');
        $this->addSql('ALTER TABLE university_degrees CHANGE company_uuid company_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_degrees ADD CONSTRAINT FK_6F95F9B392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_degrees DROP FOREIGN KEY FK_6F95F9B392124A48');
        $this->addSql('ALTER TABLE university_degrees CHANGE company_uuid company_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_degrees ADD CONSTRAINT FK_6F95F9B392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
