<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416232600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE company_employee_avatars (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company_employees (uuid CHAR(36) NOT NULL, avatar_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', company_uuid CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', email VARCHAR(50) NOT NULL, password VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_899949F043DB3B7D (avatar_uuid), INDEX IDX_899949F092124A48 (company_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_auth_codes (id INT AUTO_INCREMENT NOT NULL, author_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', value VARCHAR(255) NOT NULL, expired_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_B15820EC1D775834 (value), UNIQUE INDEX UNIQ_B15820EC3590D879 (author_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee_auth_devices (uuid VARCHAR(255) NOT NULL, author_uuid VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, os VARCHAR(255) DEFAULT NULL, os_version VARCHAR(255) DEFAULT NULL, app_version VARCHAR(255) DEFAULT NULL, ip_address VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_71164529C74F2195 (refresh_token), INDEX IDX_711645293590D879 (author_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE company_employees ADD CONSTRAINT FK_899949F043DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES company_employee_avatars (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE company_employees ADD CONSTRAINT FK_899949F092124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE employee_auth_codes ADD CONSTRAINT FK_B15820EC3590D879 FOREIGN KEY (author_uuid) REFERENCES company_employees (uuid)');
        $this->addSql('ALTER TABLE employee_auth_devices ADD CONSTRAINT FK_711645293590D879 FOREIGN KEY (author_uuid) REFERENCES company_employees (uuid)');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_employees DROP FOREIGN KEY FK_899949F043DB3B7D');
        $this->addSql('ALTER TABLE company_employees DROP FOREIGN KEY FK_899949F092124A48');
        $this->addSql('ALTER TABLE employee_auth_codes DROP FOREIGN KEY FK_B15820EC3590D879');
        $this->addSql('ALTER TABLE employee_auth_devices DROP FOREIGN KEY FK_711645293590D879');
        $this->addSql('DROP TABLE company_employee_avatars');
        $this->addSql('DROP TABLE company_employees');
        $this->addSql('DROP TABLE employee_auth_codes');
        $this->addSql('DROP TABLE employee_auth_devices');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
