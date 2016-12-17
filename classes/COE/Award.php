<?php

namespace COE;

class Award {

	const TITLE = 'Degree/Certificate';
	const PLURAL = 'Degrees/Certificates';
	const POST_TYPE = 'coe_award';

	const META_TYPE = 'award_type';
	const TYPE_DEGREE = 'Degree';
	const TYPE_CERTIFICATE = 'Certificate';

	private $id;
	private $title;
	private $type;

	/**
	 * Award constructor.
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
	 * @return Award
	 */
	public function loadFromPost( \WP_Post $post )
	{
		$meta = get_post_meta( $post->ID );

		$this
			->setId( $post->ID )
			->setTitle( $post->post_title )
			->setType( isset( $meta[ self::META_TYPE ][ 0 ] ) ? $meta[ self::META_TYPE ][ 0 ] : NULL );

		return $this;
	}

	/**
	 *
	 */
	public function update()
	{
		if ( $this->id !== NULL )
		{
			update_post_meta( $this->id, self::META_TYPE, $this->getType() );
		}
	}

	/**
	 *
	 */
	public function create()
	{
		$this->update();
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
	 * @return Award
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
	 * @return Award
	 */
	public function setTitle( $title )
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return ( $this->type === NULL ) ? '' : $this->type;
	}

	/**
	 * @param mixed $type
	 *
	 * @return Award
	 */
	public function setType( $type )
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * @return array
	 */
	public static function getTypes()
	{
		return array( self::TYPE_DEGREE, self::TYPE_CERTIFICATE );
	}

	/**
	 * @return Award[]
	 */
	public static function getAllPublishedAwards()
	{
		/** @var \WP_Post $post */
		global $post;

		$awards = array();

		$query = new \WP_Query( array(
			'post_type' => self::POST_TYPE,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC'
		));


		while ( $query->have_posts() )
		{
			$query->the_post();
			$award = new Award;
			$award->loadFromPost( $post );
			$awards[ $award->getId() ] = $award;
		}

		return $awards;
	}

	/**
	 * This caches the awards for quick retrieval when printing award names in a loop
	 * @param int $id
	 *
	 * @return string
	 */
	public static function getAwardNameById( $id )
	{
		if ( ! isset( $GLOBALS['coe_award_names'] ) )
		{
			$GLOBALS['coe_award_names'] = array();
			$awards = self::getAllPublishedAwards();

			foreach ( $awards as $award )
			{
				$GLOBALS['coe_award_names'][ $award->getId() ] = $award->getTitle();
			}
		}

		return ( array_key_exists( $id, $GLOBALS['coe_award_names'] ) ? $GLOBALS['coe_award_names'][ $id ] : 'Unknown' );
	}
}