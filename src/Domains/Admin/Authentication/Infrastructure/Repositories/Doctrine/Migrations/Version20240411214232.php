<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240411214232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_companies DROP FOREIGN KEY FK_B15F20CAA85ECC4D');
        $this->addSql('DROP INDEX UNIQ_B15F20CAA85ECC4D ON company_companies');
        $this->addSql('ALTER TABLE company_companies DROP logo_uuid');
        $this->addSql('ALTER TABLE company_logos ADD company_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company_logos ADD CONSTRAINT FK_D8A5A22A92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8A5A22A92124A48 ON company_logos (company_uuid)');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE company_companies ADD logo_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company_companies ADD CONSTRAINT FK_B15F20CAA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES company_logos (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B15F20CAA85ECC4D ON company_companies (logo_uuid)');
        $this->addSql('ALTER TABLE company_logos DROP FOREIGN KEY FK_D8A5A22A92124A48');
        $this->addSql('DROP INDEX UNIQ_D8A5A22A92124A48 ON company_logos');
        $this->addSql('ALTER TABLE company_logos DROP company_uuid');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
