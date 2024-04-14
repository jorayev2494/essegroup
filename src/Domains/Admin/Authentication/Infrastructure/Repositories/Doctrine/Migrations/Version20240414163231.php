<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414163231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE student_avatars DROP FOREIGN KEY FK_5DFF30D8EE5C2B7E');
        $this->addSql('DROP INDEX UNIQ_5DFF30D8EE5C2B7E ON student_avatars');
        $this->addSql('ALTER TABLE student_avatars DROP student_uuid');
        $this->addSql('ALTER TABLE student_students ADD avatar_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C12943DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES student_avatars (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17E2C12943DB3B7D ON student_students (avatar_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_avatars ADD student_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE student_avatars ADD CONSTRAINT FK_5DFF30D8EE5C2B7E FOREIGN KEY (student_uuid) REFERENCES student_students (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DFF30D8EE5C2B7E ON student_avatars (student_uuid)');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C12943DB3B7D');
        $this->addSql('DROP INDEX UNIQ_17E2C12943DB3B7D ON student_students');
        $this->addSql('ALTER TABLE student_students DROP avatar_uuid');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
