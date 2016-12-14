<?php

namespace COE;

class College {

	const TITLE = 'College';
	const PLURAL = 'Colleges';
	const POST_TYPE = 'coe_college';

	const META_ADDRESS = 'address';
	const META_CITY = 'city';
	const META_STATE = 'state';
	const META_ZIP = 'zip';
	const META_LAT = 'lat';
	const META_LNG = 'lng';

	private $id;
	private $title;
	private $address;
	private $city;
	private $state;
	private $zip;
	private $lat;
	private $lng;

	/**
	 * College constructor.
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
	 * @return College
	 */
	public function loadFromPost( \WP_Post $post )
	{
		$meta = get_post_meta( $post->ID );

		$this
			->setId( $post->ID )
			->setTitle( $post->post_title )
			->setAddress( isset( $meta[ self::META_ADDRESS ][ 0 ] ) ? $meta[ self::META_ADDRESS ][ 0 ] : NULL )
			->setCity( isset( $meta[ self::META_CITY ][ 0 ] ) ? $meta[ self::META_CITY ][ 0 ] : NULL )
			->setState( isset( $meta[ self::META_STATE ][ 0 ] ) ? $meta[ self::META_STATE ][ 0 ] : NULL )
			->setZip( isset( $meta[ self::META_ZIP ][ 0 ] ) ? $meta[ self::META_ZIP ][ 0 ] : NULL )
			->setLat( isset( $meta[ self::META_LAT ][ 0 ] ) ? $meta[ self::META_LAT ][ 0 ] : NULL )
			->setLng( isset( $meta[ self::META_LNG ][ 0 ] ) ? $meta[ self::META_LNG ][ 0 ] : NULL );

		return $this;
	}

	/**
	 *
	 */
	public function update()
	{
		if ( $this->id !== NULL )
		{
			update_post_meta( $this->id, self::META_ADDRESS, $this->getAddress() );
			update_post_meta( $this->id, self::META_CITY, $this->getCity() );
			update_post_meta( $this->id, self::META_STATE, $this->getState() );
			update_post_meta( $this->id, self::META_ZIP, $this->getZip() );
			update_post_meta( $this->id, self::META_LAT, $this->getLat() );
			update_post_meta( $this->id, self::META_LNG, $this->getLng() );
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
	 *
	 */
	public function delete()
	{
		if ( $this->id !== NULL )
		{
			delete_post_meta( $this->id, self::META_ADDRESS );
			delete_post_meta( $this->id, self::META_CITY );
			delete_post_meta( $this->id, self::META_STATE );
			delete_post_meta( $this->id, self::META_ZIP );
			delete_post_meta( $this->id, self::META_LAT );
			delete_post_meta( $this->id, self::META_LNG );
		}
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
	 * @return College
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
	 * @return College
	 */
	public function setTitle( $title )
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAddress()
	{
		return ( $this->address === NULL ) ? '' : $this->address;
	}

	/**
	 * @param mixed $address
	 *
	 * @return College
	 */
	public function setAddress( $address )
	{
		$this->address = $address;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCity()
	{
		return ( $this->city === NULL ) ? '' : $this->city;
	}

	/**
	 * @param mixed $city
	 *
	 * @return College
	 */
	public function setCity( $city )
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getState()
	{
		return ( $this->state === NULL ) ? '' : $this->state;
	}

	/**
	 * @param mixed $state
	 *
	 * @return College
	 */
	public function setState( $state )
	{
		$this->state = $state;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getZip()
	{
		return ( $this->zip === NULL ) ? '' : $this->zip;
	}

	/**
	 * @param mixed $zip
	 *
	 * @return College
	 */
	public function setZip( $zip )
	{
		$this->zip = $zip;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLat()
	{
		return ( strlen( $this->lat ) == 0 ) ? '' : $this->lat;
	}

	/**
	 * @param mixed $lat
	 *
	 * @return College
	 */
	public function setLat( $lat )
	{
		$this->lat = ( is_numeric( $lat ) ) ? $lat : NULL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getLng()
	{
		return ( strlen( $this->lng ) == 0 ) ? '' : $this->lng;
	}

	/**
	 * @param mixed $lng
	 *
	 * @return College
	 */
	public function setLng( $lng )
	{
		$this->lng = ( is_numeric( $lng ) ) ? $lng : NULL;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function hasAddress()
	{
		return ( $this->getAddress() != '' && $this->getCity() != '' && $this->getState() != '' & $this->getZip() != '' );
	}

	/**
	 * @return bool
	 */
	public function hasLatLng()
	{
		return ( is_numeric( $this->getLat() ) && is_numeric( $this->getLng() ) );
	}

	/**
	 * @return string
	 */
	public function getAddressString()
	{
		return $this->getAddress() . ' ' . $this->getCity() . ', ' . $this->getState() . ' ' . $this->getZip();
	}
}