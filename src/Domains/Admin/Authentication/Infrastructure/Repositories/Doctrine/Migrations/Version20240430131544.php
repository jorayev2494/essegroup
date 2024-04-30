<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430131544 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement_announcement_translations (id INT AUTO_INCREMENT NOT NULL, announcement_uuid CHAR(36) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_8A88EC7AFD4E58FA (announcement_uuid), UNIQUE INDEX announcement_announcement_translation_idx (locale, announcement_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE announcement_announcements (uuid CHAR(36) NOT NULL, author_uuid VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, content VARCHAR(255) DEFAULT NULL, start_time DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_time DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', for_item VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_36BBE8E13590D879 (author_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_manager_avatars (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement_announcement_translations ADD CONSTRAINT FK_8A88EC7AFD4E58FA FOREIGN KEY (announcement_uuid) REFERENCES announcement_announcements (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement_announcements ADD CONSTRAINT FK_36BBE8E13590D879 FOREIGN KEY (author_uuid) REFERENCES auth_members (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE auth_members ADD avatar_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE auth_members ADD CONSTRAINT FK_B84F20C43DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES company_manager_avatars (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B84F20C43DB3B7D ON auth_members (avatar_uuid)');
        $this->addSql('ALTER TABLE employee_auth_codes ADD CONSTRAINT FK_B15820EC3590D879 FOREIGN KEY (author_uuid) REFERENCES company_employees (uuid)');
        $this->addSql('ALTER TABLE employee_auth_devices ADD CONSTRAINT FK_711645293590D879 FOREIGN KEY (author_uuid) REFERENCES company_employees (uuid)');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_department_name_translations CHANGE department_name_uuid department_name_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_members DROP FOREIGN KEY FK_B84F20C43DB3B7D');
        $this->addSql('ALTER TABLE announcement_announcement_translations DROP FOREIGN KEY FK_8A88EC7AFD4E58FA');
        $this->addSql('ALTER TABLE announcement_announcements DROP FOREIGN KEY FK_36BBE8E13590D879');
        $this->addSql('DROP TABLE announcement_announcement_translations');
        $this->addSql('DROP TABLE announcement_announcements');
        $this->addSql('DROP TABLE company_manager_avatars');
        $this->addSql('DROP INDEX UNIQ_B84F20C43DB3B7D ON auth_members');
        $this->addSql('ALTER TABLE auth_members DROP avatar_uuid, DROP first_name, DROP last_name');
        $this->addSql('ALTER TABLE employee_auth_codes DROP FOREIGN KEY FK_B15820EC3590D879');
        $this->addSql('ALTER TABLE employee_auth_devices DROP FOREIGN KEY FK_711645293590D879');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_department_name_translations CHANGE department_name_uuid department_name_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
