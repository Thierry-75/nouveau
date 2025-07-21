<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721143020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD contenu LONGTEXT DEFAULT NULL, DROP introduction, DROP developpement, DROP conclusion');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD developpement LONGTEXT NOT NULL, ADD conclusion LONGTEXT DEFAULT NULL, CHANGE contenu introduction LONGTEXT DEFAULT NULL');
    }
}
