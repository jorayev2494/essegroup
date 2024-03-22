<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318225717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country_cities (uuid VARCHAR(255) NOT NULL, country_uuid VARCHAR(255) DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, company_uuid VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_99255A18564CDB42 (country_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country_city_translations (id INT AUTO_INCREMENT NOT NULL, city_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_9C0F125C32316DCE (city_uuid), UNIQUE INDEX country_city_translation_idx (locale, city_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country_cities ADD CONSTRAINT FK_99255A18564CDB42 FOREIGN KEY (country_uuid) REFERENCES country_countries (uuid)');
        $this->addSql('ALTER TABLE country_city_translations ADD CONSTRAINT FK_9C0F125C32316DCE FOREIGN KEY (city_uuid) REFERENCES country_cities (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country_cities DROP FOREIGN KEY FK_99255A18564CDB42');
        $this->addSql('ALTER TABLE country_city_translations DROP FOREIGN KEY FK_9C0F125C32316DCE');
        $this->addSql('DROP TABLE country_cities');
        $this->addSql('DROP TABLE country_city_translations');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
