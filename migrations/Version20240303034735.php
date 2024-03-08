<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303034735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cows ADD milk DOUBLE PRECISION NOT NULL, ADD portion DOUBLE PRECISION NOT NULL, ADD weigth DOUBLE PRECISION NOT NULL, DROP leite, DROP racao, DROP peso, CHANGE codigo code INT NOT NULL, CHANGE nascimento birth DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cows ADD leite DOUBLE PRECISION NOT NULL, ADD racao DOUBLE PRECISION NOT NULL, ADD peso DOUBLE PRECISION NOT NULL, DROP milk, DROP portion, DROP weigth, CHANGE birth nascimento DATETIME NOT NULL, CHANGE code codigo INT NOT NULL');
    }
}
