<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509202947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency_currencies (uuid CHAR(36) NOT NULL, value VARCHAR(255) NOT NULL, code VARCHAR(5) NOT NULL, symbol VARCHAR(5) NOT NULL, description VARCHAR(255) DEFAULT NULL, is_main TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_D423C3A877153098 (code), UNIQUE INDEX UNIQ_D423C3A8ECC836F9 (symbol), PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD price_currency_uuid VARCHAR(255) DEFAULT NULL, ADD price VARCHAR(10) DEFAULT NULL, CHANGE description description text DEFAULT NULL');
        $this->addSql('ALTER TABLE university_departments ADD CONSTRAINT FK_6F54A23383AAC67 FOREIGN KEY (price_currency_uuid) REFERENCES currency_currencies (uuid) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6F54A23383AAC67 ON university_departments (price_currency_uuid)');
        $this->addSql('ALTER TABLE university_universities CHANGE description description text DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE university_departments DROP FOREIGN KEY FK_6F54A23383AAC67');
        $this->addSql('DROP TABLE currency_currencies');
        $this->addSql('ALTER TABLE faculty_faculties CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_6F54A23383AAC67 ON university_departments');
        $this->addSql('ALTER TABLE university_departments DROP price_currency_uuid, DROP price, CHANGE description description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE university_universities CHANGE description description TEXT DEFAULT NULL');
    }
}
