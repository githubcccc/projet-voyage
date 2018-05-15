<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180515114729 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tag_voyage (tag_id INT NOT NULL, voyage_id INT NOT NULL, INDEX IDX_D6DCC079BAD26311 (tag_id), INDEX IDX_D6DCC07968C9E5AF (voyage_id), PRIMARY KEY(tag_id, voyage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_voyage ADD CONSTRAINT FK_D6DCC079BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_voyage ADD CONSTRAINT FK_D6DCC07968C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaire ADD voyage_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC68C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC68C9E5AF ON commentaire (voyage_id)');
        $this->addSql('ALTER TABLE identity_user ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE identity_user ADD CONSTRAINT FK_39E1FCDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_39E1FCDA76ED395 ON identity_user (user_id)');
        $this->addSql('ALTER TABLE voyage ADD user_id INT NOT NULL, ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D8955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voyage ADD CONSTRAINT FK_3F9D895512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3F9D8955A76ED395 ON voyage (user_id)');
        $this->addSql('CREATE INDEX IDX_3F9D895512469DE2 ON voyage (category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tag_voyage');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC68C9E5AF');
        $this->addSql('DROP INDEX IDX_67F068BC68C9E5AF ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP voyage_id');
        $this->addSql('ALTER TABLE identity_user DROP FOREIGN KEY FK_39E1FCDA76ED395');
        $this->addSql('DROP INDEX UNIQ_39E1FCDA76ED395 ON identity_user');
        $this->addSql('ALTER TABLE identity_user DROP user_id');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D8955A76ED395');
        $this->addSql('ALTER TABLE voyage DROP FOREIGN KEY FK_3F9D895512469DE2');
        $this->addSql('DROP INDEX IDX_3F9D8955A76ED395 ON voyage');
        $this->addSql('DROP INDEX IDX_3F9D895512469DE2 ON voyage');
        $this->addSql('ALTER TABLE voyage DROP user_id, DROP category_id');
    }
}
