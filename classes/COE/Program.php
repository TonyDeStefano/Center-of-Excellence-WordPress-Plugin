<?php

namespace COE;

class Program {

	const TITLE = 'Program';
	const PLURAL = 'Programs';
	const POST_TYPE = 'coe_program';

	const META_CONTACT_NAME = 'contact_name';
	const META_CONTACT_PHONE = 'contact_phone';
	const META_CONTACT_EMAIL = 'contact_email';
	const META_CREDITS = 'credits';
	const META_STARTS_AT = 'starts_at';
	const META_ENDS_AT = 'ends_at';
	const META_GRADUATES = 'graduates';
	const META_SKILL_SETS = 'skill_sets';
	const META_COLLEGE_ID = 'college_id';
	const META_AWARD_ID = 'award_id';
	const META_CATEGORY_IDS = 'category_ids';

	private $id;
	private $title;
	private $description;
	private $contact_name;
	private $contact_phone;
	private $contact_email;
	private $credits;
	private $starts_at;
	private $ends_at;
	private $anticipated_graduates;
	private $skill_sets;
	private $college_id;
	private $award_id;
	private $program_category_ids = [];

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
	 * @return Program
	 */
	public function loadFromPost( \WP_Post $post )
	{
		$meta = get_post_meta( $post->ID );

		$this
			->setId( $post->ID )
			->setTitle( $post->post_title )
			->setDescription( $post->post_content )
			->setContactName( isset( $meta[ self::META_CONTACT_NAME ][ 0 ] ) ? $meta[ self::META_CONTACT_NAME ][ 0 ] : NULL )
			->setContactEmail( isset( $meta[ self::META_CONTACT_EMAIL ][ 0 ] ) ? $meta[ self::META_CONTACT_EMAIL ][ 0 ] : NULL )
			->setContactPhone( isset( $meta[ self::META_CONTACT_PHONE ][ 0 ] ) ? $meta[ self::META_CONTACT_PHONE ][ 0 ] : NULL )
			->setCredits( isset( $meta[ self::META_CREDITS ][ 0 ] ) ? $meta[ self::META_CREDITS ][ 0 ] : NULL )
			->setStartsAt( isset( $meta[ self::META_STARTS_AT ][ 0 ] ) ? $meta[ self::META_STARTS_AT ][ 0 ] : NULL )
			->setEndsAt( isset( $meta[ self::META_ENDS_AT ][ 0 ] ) ? $meta[ self::META_ENDS_AT ][ 0 ] : NULL )
			->setAnticipatedGraduates( isset( $meta[ self::META_GRADUATES ][ 0 ] ) ? $meta[ self::META_GRADUATES ][ 0 ] : NULL )
			->setSkillSets( isset( $meta[ self::META_SKILL_SETS ][ 0 ] ) ? $meta[ self::META_SKILL_SETS ][ 0 ] : NULL )
			->setAwardId( isset( $meta[ self::META_AWARD_ID ][ 0 ] ) ? $meta[ self::META_AWARD_ID ][ 0 ] : NULL )
			->setCollegeId( isset( $meta[ self::META_COLLEGE_ID ][ 0 ] ) ? $meta[ self::META_COLLEGE_ID ][ 0 ] : NULL )
			->setProgramCategoryIds( isset( $meta[ self::META_CATEGORY_IDS ][ 0 ] ) ? $meta[ self::META_CATEGORY_IDS ][ 0 ] : NULL );

		return $this;
	}

	/**
	 *
	 */
	public function update()
	{
		if ( $this->id !== NULL )
		{
			update_post_meta( $this->id, self::META_CONTACT_NAME, $this->getContactName() );
			update_post_meta( $this->id, self::META_CONTACT_EMAIL, $this->getContactEmail() );
			update_post_meta( $this->id, self::META_CONTACT_PHONE, $this->getContactPhone() );
			update_post_meta( $this->id, self::META_CREDITS, $this->getCredits() );
			update_post_meta( $this->id, self::META_STARTS_AT, $this->getStartsAt() );
			update_post_meta( $this->id, self::META_ENDS_AT, $this->getEndsAt() );
			update_post_meta( $this->id, self::META_GRADUATES, $this->getAnticipatedGraduates() );
			update_post_meta( $this->id, self::META_SKILL_SETS, $this->getSkillSets() );
			update_post_meta( $this->id, self::META_AWARD_ID, $this->getAwardId() );
			update_post_meta( $this->id, self::META_COLLEGE_ID, $this->getCollegeId() );
			update_post_meta( $this->id, self::META_CATEGORY_IDS, $this->getProgramCategoryIds( TRUE ) );
		}
	}

	/**
	 *
	 */
	public function create()
	{
		$this->update();
	}

	/** @var College $college */
	private $college;

	/** @var Award $award */
	private $award;

	/** @var ProgramCategory[] $program_categories */
	private $program_categories = [];

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
	 * @return Program
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
	 * @return Program
	 */
	public function setTitle( $title )
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return ( $this->description === NULL ) ? '' : $this->description;
	}

	/**
	 * @param mixed $description
	 *
	 * @return Program
	 */
	public function setDescription( $description )
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContactName()
	{
		return ( $this->contact_name === NULL ) ? '' : $this->contact_name;
	}

	/**
	 * @param mixed $contact_name
	 *
	 * @return Program
	 */
	public function setContactName( $contact_name )
	{
		$this->contact_name = $contact_name;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContactPhone()
	{
		return ( $this->contact_phone === NULL ) ? '' : $this->contact_phone;
	}

	/**
	 * @param mixed $contact_phone
	 *
	 * @return Program
	 */
	public function setContactPhone( $contact_phone )
	{
		$this->contact_phone = $contact_phone;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getContactEmail()
	{
		return ( $this->contact_email === NULL ) ? '' : $this->contact_email;
	}

	/**
	 * @param mixed $contact_email
	 *
	 * @return Program
	 */
	public function setContactEmail( $contact_email )
	{
		$this->contact_email = $contact_email;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCredits()
	{
		return ( $this->credits === NULL ) ? 0 : $this->credits;
	}

	/**
	 * @param mixed $credits
	 *
	 * @return Program
	 */
	public function setCredits( $credits )
	{
		$this->credits = ( is_numeric( $credits ) ) ? abs( $credits ) : NULL;

		return $this;
	}

	/**
	 * @param string $format
	 *
	 * @return mixed
	 */
	public function getStartsAt( $format='Y-m-d' )
	{
		return ( $this->starts_at === NULL ) ? NULL : date( $format, strtotime( $this->starts_at ) );
	}

	/**
	 * @param mixed $starts_at
	 *
	 * @return Program
	 */
	public function setStartsAt( $starts_at )
	{
		if ( strlen( $starts_at ) > 0 )
		{
			$this->starts_at = ( is_numeric( $starts_at ) ) ? date( 'Y-m-d', $starts_at ) : date( 'Y-m-d', strtotime( $starts_at ) );
		}

		return $this;
	}

	/**
	 * @param string $format
	 *
	 * @return mixed
	 */
	public function getEndsAt( $format='Y-m-d' )
	{
		return ( $this->ends_at === NULL ) ? NULL : date( $format, strtotime( $this->ends_at ) );
	}

	/**
	 * @param mixed $ends_at
	 *
	 * @return Program
	 */
	public function setEndsAt( $ends_at )
	{
		if ( strlen( $ends_at ) > 0 )
		{
			$this->ends_at = ( is_numeric( $ends_at ) ) ? date( 'Y-m-d', $ends_at ) : date( 'Y-m-d', strtotime( $ends_at ) );
		}

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAnticipatedGraduates()
	{
		return ( $this->anticipated_graduates === NULL ) ? 0 : $this->anticipated_graduates;
	}

	/**
	 * @param mixed $anticipated_graduates
	 *
	 * @return Program
	 */
	public function setAnticipatedGraduates( $anticipated_graduates )
	{
		$this->anticipated_graduates = ( is_numeric( $anticipated_graduates ) ) ? intval( $anticipated_graduates ) : NULL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getSkillSets()
	{
		return ( $this->skill_sets === NULL ) ? '' : $this->skill_sets;
	}

	/**
	 * @param mixed $skill_sets
	 *
	 * @return Program
	 */
	public function setSkillSets( $skill_sets )
	{
		$this->skill_sets = $skill_sets;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCollegeId()
	{
		return $this->college_id;
	}

	/**
	 * @param mixed $college_id
	 *
	 * @return Program
	 */
	public function setCollegeId( $college_id )
	{
		$this->college_id = ( is_numeric( $college_id ) ) ? intval( $college_id ) : NULL;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getAwardId()
	{
		return $this->award_id;
	}

	/**
	 * @param mixed $award_id
	 *
	 * @return Program
	 */
	public function setAwardId( $award_id )
	{
		$this->award_id = ( is_numeric( $award_id ) ) ? intval( $award_id ) : NULL;

		return $this;
	}

	/**
	 * @param bool $as_json
	 *
	 * @return array|string
	 */
	public function getProgramCategoryIds( $as_json = FALSE )
	{
		if ( $as_json )
		{
			return ( count( $this->program_category_ids ) == 0 ) ? '' : json_encode( $this->program_category_ids );
		}

		return $this->program_category_ids;
	}

	/**
	 * @param string|array $program_category_ids
	 *
	 * @return Program
	 */
	public function setProgramCategoryIds( $program_category_ids )
	{
		if ( is_array( $program_category_ids ) )
		{
			$this->program_category_ids = $program_category_ids;
		}
		elseif ( strlen( $program_category_ids ) > 0 )
		{
			$json = json_decode( $program_category_ids, TRUE );
			if ( json_last_error() == JSON_ERROR_NONE )
			{
				$this->program_category_ids = $json;
			}
		}

		return $this;
	}

	/**
	 * @param int $program_category_id
	 *
	 * @return $this
	 */
	public function addProgramCategoryId( $program_category_id )
	{
		if ( is_numeric( $program_category_id ) && ! in_array( $program_category_id, $this->program_category_ids ) )
		{
			$this->program_category_ids[] = intval( $program_category_id );
		}

		return $this;
	}

	/**
	 * @return College
	 */
	public function getCollege()
	{
		return $this->college;
	}

	/**
	 * @param College $college
	 *
	 * @return Program
	 */
	public function setCollege( $college )
	{
		$this->college = $college;

		return $this;
	}

	/**
	 * @return Award
	 */
	public function getAward()
	{
		return $this->award;
	}

	/**
	 * @param Award $award
	 *
	 * @return Program
	 */
	public function setAward( $award )
	{
		$this->award = $award;

		return $this;
	}

	/**
	 * @return ProgramCategory[]
	 */
	public function getProgramCategories()
	{
		return $this->program_categories;
	}

	/**
	 * @param ProgramCategory[] $program_categories
	 *
	 * @return Program
	 */
	public function setProgramCategories( $program_categories )
	{
		$this->program_categories = $program_categories;

		return $this;
	}

	/**
	 * @param ProgramCategory $program_category
	 *
	 * @return Program
	 */
	public function addProgramCategory( $program_category )
	{
		$this->program_categories[ $program_category->getId() ] = $program_category;
		$this->addProgramCategoryId( $program_category->getId() );

		return $this;
	}
	/**
	 * @return Program[]
	 */
	public static function getAllPublishedPrograms()
	{
		/** @var \WP_Post $post */
		global $post;

		$programs = array();

		$query = new \WP_Query( array(
			'post_type' => self::POST_TYPE,
			'post_status' => 'publish'
		));


		while ( $query->have_posts() )
		{
			$query->the_post();
			$program = new Program();
			$program->loadFromPost( $post );
			$programs[ $program->getId() ] = $program;
		}

		return $programs;
	}
}