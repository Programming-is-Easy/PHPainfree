<?php
/**
 * @package MySQLiHelpers 
 * Creates a singleton object for $App that gives you several useful 
 * query functions and error collection for your database usage.
 *
 * @property ?\mysqli $db=null 
 * @property private $errors=array() 
 */
class MySQLiHelpers {
	private ?\mysqli $db = null;
	private $errors = array();

	/**
	 * Primary query helper function for MySQLi.
	 *
	 * @param string $query
	 * @param string|null $types
	 * @param array|null $params
	 * @param string|null $assoc_key
	 * @param bool $single
	 * @return mixed an associative array of results for selects, insert_id for inserts,
	 * 	array with Rows matched for updates, affected rows for deletes, and null on any error
	 */
	public function query(
		string $query, ?string $types=null, ?array $params=null,
		?string $assoc_key=null, bool $single=false,
	) : mixed {
		$query = trim($query);

		try {
			$data = null;

			if (!$this->db) {
				$this->errors[] = 'No database connection established';
				throw new \Exception('no database connection established');
			}

			$params_count = $params ? count($params) : null;
			$types = $types ? str_replace(' ', '', $types) : null;
			$types_len = $types ? strlen($types) : null;
			if (($types || $params) && $types_len !== $params_count) {
				$this->errors[] = "db query error: type/param mismatch: (Types: {$types}, Length:{$types_len}), Params: {$params_count}";
				throw new \Exception('db query error: type/param mismatch');
			}

			$stmt = $this->db->prepare($query);
			if (!$stmt) {
				$this->errors[] = "Statement Error: {$this->db->error}";
				throw new \Exception($this->db->error);
			}

			if (!empty($types) && !empty($params)) {
				$stmt->bind_param($types, ...$params);
			}
		
			$stmt->execute();

			if (preg_match('/^INSERT/i', $query)) {
				$data = $stmt->insert_id;
			} else if (preg_match('/^SELECT/i', $query)) {
				$result = $stmt->get_result();

				if ($single) {
					$data = $result->fetch_array(MYSQLI_ASSOC);
				} else if (!empty($assoc_key)) {
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						if (!array_key_exists($assoc_key, $row)) {
							$this->errors[] = "db query error: invalid assoc_key, key name '{$assoc_key}' must exist in the result set.";
							throw new \Exception('db query error: invalid assoc_key, key name must exist in the result set');
						}

						$data[$row[$assoc_key]] = $row;
					}
				} else {
					$data = $result->fetch_all(MYSQLI_ASSOC);
				}
			} else if (preg_match('/^UPDATE/i', $query)) {
				preg_match_all ('/(\S[^:]+): (\d+)/', $this->db->info, $matches);

				// Covert info string into associative array
				$result = array_combine (str_replace(' ', '_', $matches[1]), $matches[2]);
				$data = !empty($result) ? $result['Rows_matched'] : 0;
			} else {
				$data = $stmt->affected_rows;
			}

			$stmt->close();
			return $data;
		} catch (\Exception $e) {
			$nice_query = str_replace("\n", ' ', str_replace("\t", ' ', $query));
			$output_query = dedent($query);
			$this->errors[] = array(
				'error'  => $e->getMessage(),
				'query'  => $output_query,
			);
			if ( $_ENV['ENVIRONMENT'] === 'development' ) {
				$this->errors[] = array(
					'error' => 'development params',
					'query' => print_r($params, true),
				);
				bigmurder('database-errors', $this->errors());
			}

			error_log($e->getMessage() . " -- " . $nice_query . " -- ");
		}
		return null;
	}

	/**
	 * Get a single SELECT result as an associative array with column names as keys
	 *
	 * @param string $query
	 * @param string|null $types
	 * @param array|null $params
	 * @return array|null an associative array or null on any error
	 */
	public function queryOne(string $query, string $types = null, array $params = null) {
		return $this->query($query, $types, $params, null, true);
	}

	/**
	 * Get a SELECT result as a multi dimenstional associative array with specified column name as key
	 * and the value as an associative array with column names as keys
	 *
	 * @param string $query
	 * @param string|null $types
	 * @param array|null $params
	 * @param string|null $key_name the column name to use as the key, default is "id"
	 * @return array|null an associative array or null on any error
	 */
	public function queryWithAssocKey(string $query, string $types = null, array $params = null, $key_name = 'id') {
		return $this->query($query, $types, $params, $key_name, false);
	}
	
	/**
	 * Get a SELECT result as a multi dimenstional associative array with specified column name as key
	 * and the value as an associative array with column names as keys
	 *
	 * @param string $query
	 * @param string|null $types
	 * @param array|null $params
	 * @param string|null $key_name the column name to use as the key, default is "id"
	 * @param string|null $assoc_key the column name to use as the of each row inside your grouped array
	 * @return array|null an associative array or null on any error
	 */
	public function queryGroupWithKey(
		string $query,
		string $types=null,
		array $params=null,
		$key_name='id',
		$assoc_key=null,
	) {
		$results = $this->query($query, $types, $params, null, false);
		$rows = array();
		if ( $results ) {
			foreach ( $results as $row ) {
				if ( ! isset($row[$key_name]) ){
					bigmurder(
						"queryGroupWithKey() called with key {$key_name} which was not present in the result set.",
						$query, $key_name, $assoc_key
					);
				}
				if ( $assoc_key && ! isset($row[$assoc_key]) ) {
					bigmurder(
						"queryGroupWithKey() called with key {$key_name} and assoc_key {$assoc_key}. {$assoc_key} was not found in the result set and cannot be used as the array key for each row.",
						$query, $key_name, $assoc_key,
					);
				}

				if ( ! isset($rows[$row[$key_name]]) ) {
					$rows[$row[$key_name]] = array();
				}

				if ( $assoc_key ) {
					$rows[$row[$key_name]][$row[$assoc_key]] = $row;
				} else {
					$rows[$row[$key_name]][] = $row;
				}
			}
		}

		return $rows;
	}

	/**
	 * This function returns false if there are no errors in your query, 
	 * or returns the errors array if there are.
	 *
	 * @return bool|array $errors
	 */
	public function errors() : bool|array {
		if ( ! $this->errors ) {
			return false;
		}

		return $this->errors;
	}

	/** 
	 * The constructor takes a valid \mysqli connection 
	 * and stores that handle in $this->db.
	 */
	public function __construct(\mysqli $conn) {
		$this->db = $conn;
	}
}

