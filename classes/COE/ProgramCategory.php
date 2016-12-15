<?php

namespace COE;

class ProgramCategory {

	const TITLE = 'Program Category';
	const PLURAL = 'Program Categories';
	const POST_TYPE = 'coe_program_category';

	private $id;
	private $title;

	/**
	 * ProgramCategory constructor.
	 *
	 * @param null $id
	 */
	public function __construct( $id = NULL )
	{
		$this
			->setId( $id )
			->read();
	}

	/**
	 *
	 */
	public function read()
	{
		if ( $this->id !== NULL )
		{
			if ( $post = get_post( $this->id ) )
			{
				$this->loadFromPost( $post );
			}
			else
			{
				$this->id = NULL;
			}
		}
	}

	/**
	 * @param \WP_Post $post
	 *
	 * @return ProgramCategory
	 */
	public function loadFromPost( \WP_Post $post )
	{
		$this
			->setId( $post->ID )
			->setTitle( $post->post_title );

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 *
	 * @return ProgramCategory
	 */
	public function setId( $id )
	{
		$this->id = ( is_numeric( $id ) ) ? intval( $id ) : NULL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return ( $this->title === NULL ) ? '' : $this->title;
	}

	/**
	 * @param mixed $title
	 *
	 * @return ProgramCategory
	 */
	public function setTitle( $title )
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return ProgramCategory[]
	 */
	public static function getAllPublishedCategories()
	{
		/** @var \WP_Post $post */
		global $post;

		$categories = array();

		$query = new \WP_Query( array(
			'post_type' => self::POST_TYPE,
			'post_status' => 'publish'
		));


		while ( $query->have_posts() )
		{
			$query->the_post();
			$category = new ProgramCategory;
			$category->loadFromPost( $post );
			$categories[ $category->getId() ] = $category;
		}

		return $categories;
	}
}