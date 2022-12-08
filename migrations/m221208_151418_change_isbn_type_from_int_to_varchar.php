<?php

use yii\db\Migration;

/**
 * Class m221208_151418_change_isbn_type_from_int_to_varchar
 */
class m221208_151418_change_isbn_type_from_int_to_varchar extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('book', 'isbn', $this->string()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('book', 'isbn', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221208_151418_change_isbn_type_from_int_to_varchar cannot be reverted.\n";

        return false;
    }
    */
}
