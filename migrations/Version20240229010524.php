<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240229010524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cows (id INT AUTO_INCREMENT NOT NULL, farm_id INT DEFAULT NULL, leite INT NOT NULL, racao DOUBLE PRECISION NOT NULL, peso DOUBLE PRECISION NOT NULL, nascimento DATETIME NOT NULL, INDEX IDX_E22EC45B65FCFA0D (farm_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE farms (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, tamanho INT NOT NULL, responsavel VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1DE06CC454BD530C (nome), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinarios_fazendas (farm_id INT NOT NULL, veterinarian_id INT NOT NULL, INDEX IDX_1EC99D0265FCFA0D (farm_id), INDEX IDX_1EC99D02804C8213 (veterinarian_id), PRIMARY KEY(farm_id, veterinarian_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE veterinarians (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, crmv INT NOT NULL, UNIQUE INDEX UNIQ_6B2A679C3697FA2C (crmv), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cows ADD CONSTRAINT FK_E22EC45B65FCFA0D FOREIGN KEY (farm_id) REFERENCES farms (id)');
        $this->addSql('ALTER TABLE veterinarios_fazendas ADD CONSTRAINT FK_1EC99D0265FCFA0D FOREIGN KEY (farm_id) REFERENCES farms (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE veterinarios_fazendas ADD CONSTRAINT FK_1EC99D02804C8213 FOREIGN KEY (veterinarian_id) REFERENCES veterinarians (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cows DROP FOREIGN KEY FK_E22EC45B65FCFA0D');
        $this->addSql('ALTER TABLE veterinarios_fazendas DROP FOREIGN KEY FK_1EC99D0265FCFA0D');
        $this->addSql('ALTER TABLE veterinarios_fazendas DROP FOREIGN KEY FK_1EC99D02804C8213');
        $this->addSql('DROP TABLE cows');
        $this->addSql('DROP TABLE farms');
        $this->addSql('DROP TABLE veterinarios_fazendas');
        $this->addSql('DROP TABLE veterinarians');
    }
}
