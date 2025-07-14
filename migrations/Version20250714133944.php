<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250714133944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE product_brand (product_id INT NOT NULL, brand_id INT NOT NULL, INDEX IDX_BD0E82044584665A (product_id), INDEX IDX_BD0E820444F5D008 (brand_id), PRIMARY KEY(product_id, brand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_brand ADD CONSTRAINT FK_BD0E82044584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_brand ADD CONSTRAINT FK_BD0E820444F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE product_brand DROP FOREIGN KEY FK_BD0E82044584665A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE product_brand DROP FOREIGN KEY FK_BD0E820444F5D008
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE product_brand
        SQL);
    }
}
