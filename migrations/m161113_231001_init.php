<?php

use app\util\Migration;

class m161113_231001_init extends Migration
{
    public function up()
    {
        $isMySQL = $this->getDb()->getDriverName() === 'mysql';

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string(),
            'email_verified' => $this->boolean(),
            'github' => $this->string(),
            'avatar' => $this->string(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-user-username-unique', '{{%user}}', $isMySQL ? 'username(191)' : 'username', true);
        $this->createIndex('idx-user-email-unique', '{{%user}}', $isMySQL ? 'email(191)' : 'email', true);

        $this->createTable('{{%auth}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-auth-user_id-user-id', '{{%auth}}', 'user_id', '{{%user}}', 'id');

        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(10),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-post-slug', '{{%post}}', $isMySQL ? 'slug(191)' : 'slug', true);
        $this->addForeignKey('fk-post-user_id-user-id', '{{%post}}', 'user_id', '{{%user}}', 'id');

        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'post_id' => $this->integer()->notNull(),
            'text' => $this->text()->notNull(),
            'status' => $this->smallInteger(1)->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-comment-parent_id', '{{%comment}}', 'parent_id', '{{%comment}}', 'id', 'RESTRICT');
        $this->addForeignKey('fk-comment-user_id-user-id', '{{%comment}}', 'user_id', '{{%user}}', 'id', 'RESTRICT');
        $this->addForeignKey('fk-comment-post_id-news-id', '{{%comment}}', 'post_id', '{{%post}}', 'id', 'RESTRICT');

        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'frequency' => $this->integer()->notNull()->defaultValue(0),
            'description' => $this->text(),
        ]);

        $this->createTable('{{%post_tag}}', [
            'post_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
            'PRIMARY KEY (post_id, tag_id)'
        ]);

        $this->addForeignKey('fk-post_tag-post_id', '{{%post_tag}}', 'post_id', '{{%post}}', 'id', 'CASCADE');
        $this->addForeignKey('fk-post_tag-tag_id', '{{%post_tag}}', 'tag_id', '{{%tag}}', 'id', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%post_tag}}');
        $this->dropTable('{{%tag}}');
        $this->dropTable('{{%comment}}');
        $this->dropTable('{{%post}}');
        $this->dropTable('{{%user}}');
    }
}
