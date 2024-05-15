<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240510202159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contest_contest_translations (id INT AUTO_INCREMENT NOT NULL, contest_uuid CHAR(36) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_2FA22B5C1A14406D (contest_uuid), UNIQUE INDEX contest_contest_translation_idx (locale, contest_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contest_contests (uuid CHAR(36) NOT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, startTime DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', endTime DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contest_contests_university_application_statuses (contest_uuid CHAR(36) NOT NULL, application_status_uuid VARCHAR(255) NOT NULL, INDEX IDX_DE66068C1A14406D (contest_uuid), INDEX IDX_DE66068C40B2D050 (application_status_uuid), PRIMARY KEY(contest_uuid, application_status_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contest_contests_university_country_countries (contest_uuid CHAR(36) NOT NULL, country_country_uuid VARCHAR(255) NOT NULL, INDEX IDX_63F99AED1A14406D (contest_uuid), INDEX IDX_63F99AED5AEF5750 (country_country_uuid), PRIMARY KEY(contest_uuid, country_country_uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contest_contest_translations ADD CONSTRAINT FK_2FA22B5C1A14406D FOREIGN KEY (contest_uuid) REFERENCES contest_contests (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contest_contests_university_application_statuses ADD CONSTRAINT FK_DE66068C1A14406D FOREIGN KEY (contest_uuid) REFERENCES contest_contests (uuid)');
        $this->addSql('ALTER TABLE contest_contests_university_application_statuses ADD CONSTRAINT FK_DE66068C40B2D050 FOREIGN KEY (application_status_uuid) REFERENCES university_application_status_values (uuid)');
        $this->addSql('ALTER TABLE contest_contests_university_country_countries ADD CONSTRAINT FK_63F99AED1A14406D FOREIGN KEY (contest_uuid) REFERENCES contest_contests (uuid)');
        $this->addSql('ALTER TABLE contest_contests_university_country_countries ADD CONSTRAINT FK_63F99AED5AEF5750 FOREIGN KEY (country_country_uuid) REFERENCES country_countries (uuid)');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contest_contest_translations DROP FOREIGN KEY FK_2FA22B5C1A14406D');
        $this->addSql('ALTER TABLE contest_contests_university_application_statuses DROP FOREIGN KEY FK_DE66068C1A14406D');
        $this->addSql('ALTER TABLE contest_contests_university_application_statuses DROP FOREIGN KEY FK_DE66068C40B2D050');
        $this->addSql('ALTER TABLE contest_contests_university_country_countries DROP FOREIGN KEY FK_63F99AED1A14406D');
        $this->addSql('ALTER TABLE contest_contests_university_country_countries DROP FOREIGN KEY FK_63F99AED5AEF5750');
        $this->addSql('DROP TABLE contest_contest_translations');
        $this->addSql('DROP TABLE contest_contests');
        $this->addSql('DROP TABLE contest_contests_university_application_statuses');
        $this->addSql('DROP TABLE contest_contests_university_country_countries');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
