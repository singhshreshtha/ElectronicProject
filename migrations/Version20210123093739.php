<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210123093739 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, manage_id INT NOT NULL, category_type_id INT NOT NULL, product_name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, power_consumption VARCHAR(255) NOT NULL, material_type VARCHAR(255) NOT NULL, height VARCHAR(255) NOT NULL, width VARCHAR(255) NOT NULL, weight VARCHAR(255) NOT NULL, current_type ENUM(\'AC\', \'DC\'), warranty VARCHAR(255) NOT NULL, star_ratings ENUM(\'1\', \'2\', \'3\', \'4\', \'5\'), model_no VARCHAR(255) NOT NULL, status ENUM(\'new\', \'review\', \'publish\'), image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_B3BA5A5AF1AF8971 (manage_id), INDEX IDX_B3BA5A5A294CCED (category_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AF1AF8971 FOREIGN KEY (manage_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A294CCED FOREIGN KEY (category_type_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A294CCED');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE products');
    }
}
