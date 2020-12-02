<?php

use chipmob\user\migrations\Migration;
use mdm\admin\components\Configs;

/**
 * Migration table of table_menu
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class m140602_111327_create_menu_table extends Migration
{
    /** @inheritdoc */
    public function up()
    {
        $menuTable = Configs::instance()->menuTable;

        $this->createTable($menuTable, [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'parent' => $this->integer(),
            'route' => $this->string(),
            'order' => $this->integer(),
            'data' => $this->binary(),
            "FOREIGN KEY ([[parent]]) REFERENCES {$menuTable}([[id]]) ON DELETE SET NULL ON UPDATE CASCADE",
        ], $this->tableOptions);
    }

    /** @inheritdoc */
    public function down()
    {
        $this->dropTable(Configs::instance()->menuTable);
    }
}
