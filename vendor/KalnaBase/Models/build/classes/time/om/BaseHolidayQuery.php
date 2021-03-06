<?php


/**
 * Base class that represents a query for the 'holidays' table.
 *
 *
 *
 * @method HolidayQuery orderByDato($order = Criteria::ASC) Order by the dato column
 * @method HolidayQuery orderByNavn($order = Criteria::ASC) Order by the navn column
 *
 * @method HolidayQuery groupByDato() Group by the dato column
 * @method HolidayQuery groupByNavn() Group by the navn column
 *
 * @method HolidayQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method HolidayQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method HolidayQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Holiday findOne(PropelPDO $con = null) Return the first Holiday matching the query
 * @method Holiday findOneOrCreate(PropelPDO $con = null) Return the first Holiday matching the query, or a new Holiday object populated from the query conditions when no match is found
 *
 * @method Holiday findOneByNavn(string $navn) Return the first Holiday filtered by the navn column
 *
 * @method array findByDato(string $dato) Return Holiday objects filtered by the dato column
 * @method array findByNavn(string $navn) Return Holiday objects filtered by the navn column
 *
 * @package    propel.generator.time.om
 */
abstract class BaseHolidayQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseHolidayQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'time';
        }
        if (null === $modelName) {
            $modelName = 'Holiday';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new HolidayQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   HolidayQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return HolidayQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof HolidayQuery) {
            return $criteria;
        }
        $query = new HolidayQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Holiday|Holiday[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = HolidayPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(HolidayPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Holiday A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByDato($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Holiday A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `dato`, `navn` FROM `holidays` WHERE `dato` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Holiday();
            $obj->hydrate($row);
            HolidayPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Holiday|Holiday[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Holiday[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return HolidayQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(HolidayPeer::DATO, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return HolidayQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(HolidayPeer::DATO, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the dato column
     *
     * Example usage:
     * <code>
     * $query->filterByDato('2011-03-14'); // WHERE dato = '2011-03-14'
     * $query->filterByDato('now'); // WHERE dato = '2011-03-14'
     * $query->filterByDato(array('max' => 'yesterday')); // WHERE dato < '2011-03-13'
     * </code>
     *
     * @param     mixed $dato The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return HolidayQuery The current query, for fluid interface
     */
    public function filterByDato($dato = null, $comparison = null)
    {
        if (is_array($dato)) {
            $useMinMax = false;
            if (isset($dato['min'])) {
                $this->addUsingAlias(HolidayPeer::DATO, $dato['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dato['max'])) {
                $this->addUsingAlias(HolidayPeer::DATO, $dato['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(HolidayPeer::DATO, $dato, $comparison);
    }

    /**
     * Filter the query on the navn column
     *
     * Example usage:
     * <code>
     * $query->filterByNavn('fooValue');   // WHERE navn = 'fooValue'
     * $query->filterByNavn('%fooValue%'); // WHERE navn LIKE '%fooValue%'
     * </code>
     *
     * @param     string $navn The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return HolidayQuery The current query, for fluid interface
     */
    public function filterByNavn($navn = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($navn)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $navn)) {
                $navn = str_replace('*', '%', $navn);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(HolidayPeer::NAVN, $navn, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Holiday $holiday Object to remove from the list of results
     *
     * @return HolidayQuery The current query, for fluid interface
     */
    public function prune($holiday = null)
    {
        if ($holiday) {
            $this->addUsingAlias(HolidayPeer::DATO, $holiday->getDato(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
