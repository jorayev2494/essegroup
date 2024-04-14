<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414095718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_application_status_values DROP FOREIGN KEY FK_F538462693382E');
        $this->addSql('DROP INDEX IDX_F538462693382E ON university_application_status_values');
        $this->addSql('ALTER TABLE university_application_status_values ADD backgroundColor VARCHAR(10) NOT NULL, DROP application_uuid, CHANGE color textColor VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE university_application_statuses ADD application_uuid VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE university_application_statuses ADD CONSTRAINT FK_9916C3B02693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid)');
        $this->addSql('CREATE INDEX IDX_9916C3B02693382E ON university_application_statuses (application_uuid)');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_application_status_values ADD application_uuid VARCHAR(255) NOT NULL, ADD color VARCHAR(10) NOT NULL, DROP textColor, DROP backgroundColor');
        $this->addSql('ALTER TABLE university_application_status_values ADD CONSTRAINT FK_F538462693382E FOREIGN KEY (application_uuid) REFERENCES university_applications (uuid) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_F538462693382E ON university_application_status_values (application_uuid)');
        $this->addSql('ALTER TABLE university_application_statuses DROP FOREIGN KEY FK_9916C3B02693382E');
        $this->addSql('DROP INDEX IDX_9916C3B02693382E ON university_application_statuses');
        $this->addSql('ALTER TABLE university_application_statuses DROP application_uuid');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
