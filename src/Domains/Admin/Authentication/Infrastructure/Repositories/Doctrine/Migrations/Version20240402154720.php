<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402154720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE faculty_faculty_name_translations (id INT AUTO_INCREMENT NOT NULL, faculty_name_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_FD594F64B92D09FD (faculty_name_uuid), UNIQUE INDEX faculty_faculty_name_translation_idx (locale, field, faculty_name_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculty_faculty_names (uuid VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faculty_faculty_name_translations ADD CONSTRAINT FK_FD594F64B92D09FD FOREIGN KEY (faculty_name_uuid) REFERENCES faculty_faculty_names (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL, CHANGE name name_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF96C98AD1 FOREIGN KEY (name_uuid) REFERENCES faculty_faculty_names (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_357BE7CF96C98AD1 ON faculty_faculties (name_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties DROP FOREIGN KEY FK_357BE7CF96C98AD1');
        $this->addSql('ALTER TABLE faculty_faculty_name_translations DROP FOREIGN KEY FK_FD594F64B92D09FD');
        $this->addSql('DROP TABLE faculty_faculty_name_translations');
        $this->addSql('DROP TABLE faculty_faculty_names');
        $this->addSql('DROP INDEX IDX_357BE7CF96C98AD1 ON faculty_faculties');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL, CHANGE name_uuid name VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
