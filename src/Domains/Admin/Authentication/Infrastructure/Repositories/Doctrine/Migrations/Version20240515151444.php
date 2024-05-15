<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515151444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contest_won_students (code INT AUTO_INCREMENT NOT NULL, contest_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', student_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', gift_given_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', note text DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F741C5A91A14406D (contest_uuid), INDEX IDX_F741C5A9EE5C2B7E (student_uuid), PRIMARY KEY(code)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB AUTO_INCREMENT = 100000');
        $this->addSql('ALTER TABLE contest_won_students ADD CONSTRAINT FK_F741C5A91A14406D FOREIGN KEY (contest_uuid) REFERENCES contest_contests (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contest_won_students ADD CONSTRAINT FK_F741C5A9EE5C2B7E FOREIGN KEY (student_uuid) REFERENCES student_students (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contest_contests ADD participants_number INT NOT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contest_won_students DROP FOREIGN KEY FK_F741C5A91A14406D');
        $this->addSql('ALTER TABLE contest_won_students DROP FOREIGN KEY FK_F741C5A9EE5C2B7E');
        $this->addSql('DROP TABLE contest_won_students');
        $this->addSql('ALTER TABLE contest_contests DROP participants_number');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
