<?php
/**
 *
 * Profile Flair. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, Steve Guidetti, https://github.com/stevotvr
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace stevotvr\flair\entity;

use phpbb\db\driver\driver_interface;
use stevotvr\flair\exception\out_of_bounds;
use stevotvr\flair\exception\unexpected_value;

/**
 * Profile Flair flair category entity.
 */
class category extends entity implements category_interface
{
	protected $columns = array(
		'cat_id'				=> 'integer',
		'cat_name'				=> 'set_name',
		'cat_order'				=> 'set_order',
		'cat_display_profile'	=> 'set_show_on_profile',
		'cat_display_posts'		=> 'set_show_on_posts',
	);

	protected $id_column = 'cat_id';

	public function get_name()
	{
		return isset($this->data['cat_name']) ? (string) $this->data['cat_name'] : '';
	}

	public function set_name($name)
	{
		$name = (string) $name;

		if ($name === '')
		{
			throw new unexpected_value(array('cat_name', 'FIELD_MISSING'));
		}

		if (truncate_string($name, 255) !== $name)
		{
			throw new unexpected_value(array('cat_name', 'TOO_LONG'));
		}

		$this->data['cat_name'] = $name;

		return $this;
	}

	public function get_order()
	{
		return isset($this->data['cat_order']) ? (int) $this->data['cat_order'] : 0;
	}

	public function set_order($order)
	{
		$order = (int) $order;

		if ($order < 0 || $order > 16777215)
		{
			throw new out_of_bounds('cat_order');
		}

		$this->data['cat_order'] = $order;

		return $this;
	}

	public function show_on_profile()
	{
		return (bool) $this->data['cat_display_profile'];
	}

	public function set_show_on_profile($show_on_profile)
	{
		$show_on_profile = (bool) $show_on_profile;

		$this->data['cat_display_profile'] = (int) $show_on_profile;

		return $this;
	}

	public function show_on_posts()
	{
		return (bool) $this->data['cat_display_posts'];
	}

	public function set_show_on_posts($show_on_posts)
	{
		$show_on_posts = (bool) $show_on_posts;

		$this->data['cat_display_posts'] = (int) $show_on_posts;

		return $this;
	}
}