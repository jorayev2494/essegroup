<?php

declare(strict_types=1);

namespace Project\Domains\Admin\Authentication\Infrastructure\Repositories\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240107213445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE auth_members ALTER uuid TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE auth_members ALTER password TYPE VARCHAR(255)');
    }
}
