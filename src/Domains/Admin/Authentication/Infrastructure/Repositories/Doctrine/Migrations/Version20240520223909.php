<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520223909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document_document_covers (uuid VARCHAR(255) NOT NULL, width INT DEFAULT NULL, height INT DEFAULT NULL, mime_type VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, full_path VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, file_original_name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, url_pattern VARCHAR(255) NOT NULL, downloaded_count INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_document_translations (id INT AUTO_INCREMENT NOT NULL, document_uuid CHAR(36) DEFAULT NULL, locale VARCHAR(8) NOT NULL, field VARCHAR(32) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX IDX_4D4CC52876CBDC35 (document_uuid), UNIQUE INDEX document_document_translation_idx (locale, document_uuid, field), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_documents (uuid CHAR(36) NOT NULL, file_uuid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', title VARCHAR(255) DEFAULT NULL, type VARCHAR(10) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_B0885A29588338C8 (file_uuid), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document_document_translations ADD CONSTRAINT FK_4D4CC52876CBDC35 FOREIGN KEY (document_uuid) REFERENCES document_documents (uuid) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document_documents ADD CONSTRAINT FK_B0885A29588338C8 FOREIGN KEY (file_uuid) REFERENCES document_document_covers (uuid)');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note text DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document_document_translations DROP FOREIGN KEY FK_4D4CC52876CBDC35');
        $this->addSql('ALTER TABLE document_documents DROP FOREIGN KEY FK_B0885A29588338C8');
        $this->addSql('DROP TABLE document_document_covers');
        $this->addSql('DROP TABLE document_document_translations');
        $this->addSql('DROP TABLE document_documents');
        $this->addSql('ALTER TABLE contest_won_students CHANGE note note TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
