<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial extends CI_Migration {

	public function up()
	{
		$default_primary_key_int_length = '9';

		$product_category_fields = array(
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20'
			)
		);
		$this->create_table('product_categories', $product_category_fields);

		$product_fields = array(
			'product_category_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length,
				'null' => true
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
			),
			'code' => array(
				'type' => 'VARCHAR',
				'constraint' => '10',
				'null' => true
			),
			'barcode' => array(
				'type' => 'VARCHAR',
				'constraint' => '15',
				'null' => true
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true
			),
			'quantity' => array(
				'type' => 'INT',
				'default' => '0'
			),
			'base_price' => array(
				'type' => 'INT'
			),
			'sell_price' => array(
				'type' => 'INT'
			),
			'deleted' => array(
				'type' => 'INT',
				'constraint' => '1',
				'default' => '0'
			),
			'CONSTRAINT FOREIGN KEY (`product_category_id`) REFERENCES `product_categories`(`id`)'
		);
		$this->create_table('products', $product_fields);

		$product_image_fields = array(
			'product_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '10'
			),
			'CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)'
		);
		$this->dbforge->add_key('product_id', TRUE);
		$this->dbforge->add_key('name', TRUE);
		$this->create_table('product_images', $product_image_fields, false);

		$supplier_fields = array(
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20'
			),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => true
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '15',
				'null' => true
			)
		);
		$this->create_table('suppliers', $supplier_fields);

		$supplier_product_fields = array(
			'supplier_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length
			),
			'CONSTRAINT FOREIGN KEY (`supplier_id`) REFERENCES `suppliers`(`id`)',
			'CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)'
		);
		$this->dbforge->add_key('supplier_id', TRUE);
		$this->dbforge->add_key('product_id', TRUE);
		$this->create_table('supplier_products', $supplier_product_fields, false);

		$customer_fields = array(
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20'
			),
			'address' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => true
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '15',
				'null' => true
			)
		);
		$this->create_table('customers', $customer_fields);

		$transaction_fields = array(
			'customer_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length,
				'null' => true
			),
			'timestamp DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'CONSTRAINT FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`)'
		);
		$this->create_table('transactions', $transaction_fields);

		$transaction_detail_fields = array(
			'transaction_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length
			),
			'product_id' => array(
				'type' => 'INT',
				'constraint' => $default_primary_key_int_length
			),
			'quantity' => array(
				'type' => 'INT'
			),
			'each_price' => array(
				'type' => 'INT'
			),
			'CONSTRAINT FOREIGN KEY (`transaction_id`) REFERENCES `transactions`(`id`)',
			'CONSTRAINT FOREIGN KEY (`product_id`) REFERENCES `products`(`id`)'
		);
		$this->dbforge->add_key('transaction_id', TRUE);
		$this->dbforge->add_key('product_id', TRUE);
		$this->create_table('transaction_details', $transaction_detail_fields, false);
	}

	public function down() {
		$this->dbforge->drop_table('transaction_details');
		$this->dbforge->drop_table('transactions');
		$this->dbforge->drop_table('customers');
		$this->dbforge->drop_table('supplier_products');
		$this->dbforge->drop_table('suppliers');
		$this->dbforge->drop_table('product_images');
		$this->dbforge->drop_table('products');
		$this->dbforge->drop_table('product_categories');
	}

	private function create_table($table_name, $table_fields, $has_primary_key_id = true) {
		if ($has_primary_key_id)
		{
			$this->dbforge->add_field('id');
		}
		$this->dbforge->add_field($table_fields);
		$this->dbforge->create_table($table_name);
	}
}