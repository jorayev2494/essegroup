<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240504182059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_companies ADD is_main TINYINT(1) DEFAULT 0 NOT NULL, DROP domain');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE student_students CHANGE passport_date_of_issue passport_date_of_issue DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE passport_date_of_expiry passport_date_of_expiry DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE high_school_name high_school_name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_companies ADD domain VARCHAR(255) NOT NULL, DROP is_main');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_students CHANGE passport_date_of_issue passport_date_of_issue DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE passport_date_of_expiry passport_date_of_expiry DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE high_school_name high_school_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
