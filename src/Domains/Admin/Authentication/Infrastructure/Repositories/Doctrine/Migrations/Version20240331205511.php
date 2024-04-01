<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240331205511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country_cities DROP company_uuid');
        $this->addSql('ALTER TABLE country_countries DROP company_uuid');
        $this->addSql('ALTER TABLE faculty_faculties DROP FOREIGN KEY FK_357BE7CF4C981D05');
        $this->addSql('ALTER TABLE faculty_faculties DROP FOREIGN KEY FK_357BE7CF92124A48');
        $this->addSql('DROP INDEX IDX_357BE7CF4C981D05 ON faculty_faculties');
        $this->addSql('DROP INDEX IDX_357BE7CF92124A48 ON faculty_faculties');
        $this->addSql('ALTER TABLE faculty_faculties DROP company_uuid, DROP university_uuid, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_degrees DROP FOREIGN KEY FK_6F95F9B392124A48');
        $this->addSql('DROP INDEX IDX_6F95F9B392124A48 ON university_degrees');
        $this->addSql('ALTER TABLE university_degrees DROP company_uuid');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A2392124A48');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A234C981D05');
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A235432B5F3');
        $this->addSql('DROP INDEX IDX_6F54A235432B5F3 ON university_departments');
        $this->addSql('DROP INDEX IDX_6F54A234C981D05 ON university_departments');
        $this->addSql('DROP INDEX IDX_6F54A2392124A48 ON university_departments');
        $this->addSql('ALTER TABLE university_departments DROP company_uuid, DROP university_uuid, DROP faculty_uuid, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities DROP FOREIGN KEY FK_C0A9599392124A48');
        $this->addSql('DROP INDEX IDX_C0A9599392124A48 ON university_universities');
        $this->addSql('ALTER TABLE university_universities DROP company_uuid, CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country_cities ADD company_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE country_countries ADD company_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE faculty_faculties ADD company_uuid VARCHAR(255) DEFAULT NULL, ADD university_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF4C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE faculty_faculties ADD CONSTRAINT FK_357BE7CF92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_357BE7CF4C981D05 ON faculty_faculties (university_uuid)');
        $this->addSql('CREATE INDEX IDX_357BE7CF92124A48 ON faculty_faculties (company_uuid)');
        $this->addSql('ALTER TABLE university_degrees ADD company_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE university_degrees ADD CONSTRAINT FK_6F95F9B392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F95F9B392124A48 ON university_degrees (company_uuid)');
        $this->addSql('ALTER TABLE university_departments ADD company_uuid VARCHAR(255) DEFAULT NULL, ADD university_uuid VARCHAR(255) DEFAULT NULL, ADD faculty_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A2392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A234C981D05 FOREIGN KEY (university_uuid) REFERENCES university_universities (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A235432B5F3 FOREIGN KEY (faculty_uuid) REFERENCES faculty_faculties (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F54A235432B5F3 ON university_departments (faculty_uuid)');
        $this->addSql('CREATE INDEX IDX_6F54A234C981D05 ON university_departments (university_uuid)');
        $this->addSql('CREATE INDEX IDX_6F54A2392124A48 ON university_departments (company_uuid)');
        $this->addSql('ALTER TABLE university_universities ADD company_uuid VARCHAR(255) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities ADD CONSTRAINT FK_C0A9599392124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_C0A9599392124A48 ON university_universities (company_uuid)');
    }
}
