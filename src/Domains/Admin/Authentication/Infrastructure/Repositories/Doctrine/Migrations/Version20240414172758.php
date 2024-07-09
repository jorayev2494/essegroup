<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414172758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE university_application_status_value_translations (id INT AUTO_INCREMENT NOT NULL, status_value_uuid VARCHAR(255) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_54E1D71D79C3EFF9 (status_value_uuid), UNIQUE INDEX university_application_status_value_translation_idx (locale, field, status_value_uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE university_application_status_values (uuid VARCHAR(255) NOT NULL, value VARCHAR(20) DEFAULT NULL, textColor VARCHAR(10) NOT NULL, backgroundColor VARCHAR(10) NOT NULL, is_first TINYINT(1) DEFAULT 0 NOT NULL, description VARCHAR(255) DEFAULT NULL, is_required_note TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE university_application_status_value_translations ADD CONSTRAINT FK_54E1D71D79C3EFF9 FOREIGN KEY (status_value_uuid) REFERENCES university_application_status_values (uuid)');
        $this->addSql('ALTER TABLE company_companies ADD logo_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company_companies ADD CONSTRAINT FK_B15F20CAA85ECC4D FOREIGN KEY (logo_uuid) REFERENCES company_logos (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B15F20CAA85ECC4D ON company_companies (logo_uuid)');
        $this->addSql('ALTER TABLE company_logos DROP FOREIGN KEY FK_D8A5A22A92124A48');
        $this->addSql('DROP INDEX UNIQ_D8A5A22A92124A48 ON company_logos');
        $this->addSql('ALTER TABLE company_logos DROP company_uuid');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE student_avatars DROP FOREIGN KEY FK_5DFF30D8EE5C2B7E');
        $this->addSql('DROP INDEX UNIQ_5DFF30D8EE5C2B7E ON student_avatars');
        $this->addSql('ALTER TABLE student_avatars DROP student_uuid');
        $this->addSql('ALTER TABLE student_students ADD avatar_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE student_students ADD CONSTRAINT FK_17E2C12943DB3B7D FOREIGN KEY (avatar_uuid) REFERENCES student_avatars (uuid)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17E2C12943DB3B7D ON student_students (avatar_uuid)');
        $this->addSql('ALTER TABLE university_application_statuses ADD status_value_uuid VARCHAR(255) NOT NULL, DROP value');
        $this->addSql('ALTER TABLE university_application_statuses ADD CONSTRAINT FK_9916C3B079C3EFF9 FOREIGN KEY (status_value_uuid) REFERENCES university_application_status_values (uuid)');
        $this->addSql('CREATE INDEX IDX_9916C3B079C3EFF9 ON university_application_statuses (status_value_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE university_application_statuses DROP FOREIGN KEY FK_9916C3B079C3EFF9');
        $this->addSql('ALTER TABLE university_application_status_value_translations DROP FOREIGN KEY FK_54E1D71D79C3EFF9');
        $this->addSql('DROP TABLE university_application_status_value_translations');
        $this->addSql('DROP TABLE university_application_status_values');
        $this->addSql('ALTER TABLE company_companies DROP FOREIGN KEY FK_B15F20CAA85ECC4D');
        $this->addSql('DROP INDEX UNIQ_B15F20CAA85ECC4D ON company_companies');
        $this->addSql('ALTER TABLE company_companies DROP logo_uuid');
        $this->addSql('ALTER TABLE company_logos ADD company_uuid VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE company_logos ADD CONSTRAINT FK_D8A5A22A92124A48 FOREIGN KEY (company_uuid) REFERENCES company_companies (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8A5A22A92124A48 ON company_logos (company_uuid)');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE student_avatars ADD student_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE student_avatars ADD CONSTRAINT FK_5DFF30D8EE5C2B7E FOREIGN KEY (student_uuid) REFERENCES student_students (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5DFF30D8EE5C2B7E ON student_avatars (student_uuid)');
        $this->addSql('ALTER TABLE student_students DROP FOREIGN KEY FK_17E2C12943DB3B7D');
        $this->addSql('DROP INDEX UNIQ_17E2C12943DB3B7D ON student_students');
        $this->addSql('ALTER TABLE student_students DROP avatar_uuid');
        $this->addSql('DROP INDEX IDX_9916C3B079C3EFF9 ON university_application_statuses');
        $this->addSql('ALTER TABLE university_application_statuses ADD value VARCHAR(20) NOT NULL, DROP status_value_uuid');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
