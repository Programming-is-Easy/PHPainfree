<?php

class MySQLiHelpers {
	private $db = null;

	public function __construct(\mysqli $conn) {
		$this->db = $conn;
	}

	/**
	 * helper function for MySQLi db queries
	 *
	 * @param string $query
	 * @param string|null $types
	 * @param array|null $params
	 * @param string|null $assoc_key
	 * @param bool $one
	 * @return mixed an associative array of results for selects, affected rows for updates, insert_id for inserts and null on any error
	 */
	public function query(
		string $query,
		string $types = null,
		array $params = null,
		string $assoc_key = null,
		bool $single = false,
	) {
		$query = trim($query);
		try {
			$data = null;
			if (!$this->db) {
				throw new \Exception('no database connection established');
			}

			if (($types || $params) && strlen($types) !== count($params)) {
				throw new \Exception('db query error: type/param mismatch');
			}
			$stmt = $this->db->prepare($query);

			if (!$stmt) {
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

				$data = null;

				if ($single) {
					$data = $result->fetch_array(MYSQLI_ASSOC);
				} else if (!empty($assoc_key)) {
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						if (!array_key_exists($assoc_key, $row)) {
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
			error_log($e->getMessage() . $query);
		}
		return null;



		$query = trim($query);
		try {
			if (!$this->db) {
				throw new \Exception('no database connection established');
			}

			if (($types || $params) && strlen($types) !== count($params)) {
				throw new \Exception('db query error: type/param mismatch');
			}

			$stmt = $this->db->prepare($query);

			if (!$stmt) {
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

				$data = null;

				if ($single) {
					$data = $result->fetch_array(MYSQLI_ASSOC);
				} else if (!empty($assoc_key)) {
					while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
						if (!array_key_exists($assoc_key, $row)) {
							throw new \Exception('db query error: invalid assoc_key, key name must exist in the result set');
						}

						$data[$row[$assoc_key]] = $row;
					}
				} else {
					$data = $result->fetch_all(MYSQLI_ASSOC);
				}
			} else if (preg_match('/^UPDATE/i', $query)) {
				

				$data = $single
					? $stmt->get_result()->fetch_array(MYSQLI_ASSOC)
					: $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
			} else {
				$data = $stmt->affected_rows;
			}

			$stmt->close();
			return $data;
		} catch (\Exception $e) {
			error_log($e->getMessage() . $query);
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
	 * Get a SELECT result as a multi-dimensional associative array with
	 * specified column name as the key and the value as an associative array
	 * with column names as keys
	 *
	 * @param string $query
	 * @param string|null $types
	 * @param array|null $params
	 * @param string|null $key_name the column name to use as the key, default is "id"
	 * @return array|null an associative array of results or null on any error.
	 */
	public function queryWithAssocKey(string $query, string $types = null, array $params = null, $key_name = 'id') {
		return $this->query($query, $types, $params, $key_name, false);
	}

}
