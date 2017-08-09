<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_all()
	{
		$this->_db_select_products();
		$this->_db_left_join_product_categories();

		$product_list = $this->db->get()->result();

		// foreach ($product_list as $product)
		// {
		// 	$this->_include_product_image_urls($product);
		// }

        return $product_list;
	}

	public function get($id)
	{
		$this->_db_select_products();
		$this->_db_left_join_product_categories();
		$this->db->where('products.id', $id);

		$product = $this->db->get()->row();

		// if (!is_null($product))
		// {
		// 	$this->_include_product_image_urls($product);
		// }

		return $product;
	}

	public function insert($data)
	{
		$this->db->insert('products', $data);
	}

	public function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('products', $data);
	}

	private function _db_select_products()
	{
		$this->db->select('products.*');
		$this->db->from('products');
	}

	private function _db_left_join_product_categories()
	{
		$this->db->select('product_categories.name AS category');
		$this->db->join('product_categories', 'products.product_category_id = product_categories.id', 'left');
	}

	private function _include_product_image_urls($product)
	{
		$image_url_prefix = '';

		$product->image_urls = array();

		$this->db->select('name');
		$this->db->from('product_images');
		$this->db->where('product_id', $product->id);

		$product_images = $this->db->get()->result();

		foreach ($product_images as $image)
		{
			array_push($product->image_urls, $image_url_prefix . $image->name);
		}
	}
}