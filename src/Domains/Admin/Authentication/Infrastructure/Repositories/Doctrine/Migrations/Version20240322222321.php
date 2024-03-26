<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240322222321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities ADD country_uuid VARCHAR(255) DEFAULT NULL, ADD city_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A95993564CDB42 FOREIGN KEY (country_uuid) REFERENCES country_countries (uuid)');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599332316DCE FOREIGN KEY (city_uuid) REFERENCES country_cities (uuid)');
        $this->addSql('CREATE INDEX IDX_C0A95993564CDB42 ON university_universities (country_uuid)');
        $this->addSql('CREATE INDEX IDX_C0A9599332316DCE ON university_universities (city_uuid)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A95993564CDB42');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A9599332316DCE');
        $this->addSql('DROP INDEX IDX_C0A95993564CDB42 ON university_universities');
        $this->addSql('DROP INDEX IDX_C0A9599332316DCE ON university_universities');
        $this->addSql('ALTER TABLE university_universities DROP country_uuid, DROP city_uuid, CHANGE description description TEXT DEFAULT NULL');
    }
}
