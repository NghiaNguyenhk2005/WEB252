<?php
class BaseModel {
    protected $conn;
    protected $table;

    // Query builder state
    protected $select = "*";
    protected $joins = [];
    protected $wheres = [];
    protected $bindings = [];
    protected $orderBy = "";
    protected $limit = "";
    protected $offset = "";

    public function __construct($conn, $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    // ======================
    // TYPE HANDLING
    // ======================
    private function getType($value) {
        if (is_int($value)) return "i";
        if (is_float($value)) return "d";
        return "s";
    }

    private function buildTypes($values) {
        $types = "";
        foreach ($values as $v) {
            $types .= $this->getType($v);
        }
        return $types;
    }

    // ======================
    // QUERY BUILDER
    // ======================

    public function select($fields = "*") {
        $this->select = $fields;
        return $this;
    }

    public function where($column, $value) {
        $this->wheres[] = "$column = ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function join($table, $condition, $type = "INNER") {
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }

    public function orderBy($column, $direction = "ASC") {
        $this->orderBy = "ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit, $offset = 0) {
        $this->limit = "LIMIT $limit";
        $this->offset = "OFFSET $offset";
        return $this;
    }

    // ======================
    // BUILD & EXECUTE
    // ======================

    private function buildQuery() {
        $sql = "SELECT {$this->select} FROM {$this->table}";

        if (!empty($this->joins)) {
            $sql .= " " . implode(" ", $this->joins);
        }

        if (!empty($this->wheres)) {
            $sql .= " WHERE " . implode(" AND ", $this->wheres);
        }

        if ($this->orderBy) {
            $sql .= " " . $this->orderBy;
        }

        if ($this->limit) {
            $sql .= " " . $this->limit . " " . $this->offset;
        }

        return $sql;
    }

    public function get() {
        $sql = $this->buildQuery();
        $stmt = $this->conn->prepare($sql);

        if (!empty($this->bindings)) {
            $types = $this->buildTypes($this->bindings);
            $stmt->bind_param($types, ...$this->bindings);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $this->reset(); // reset state

        return $result;
    }

    public function first() {
        $this->limit(1);
        $result = $this->get();
        return $result->fetch_assoc();
    }

    // ======================
    // CRUD
    // ======================

    public function create($data) {
        $columns = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        $types = $this->buildTypes($data);
        $values = array_values($data);

        $stmt->bind_param($types, ...$values);

        return $stmt->execute();
    }

    public function update($id, $data) {
        $fields = implode(",", array_map(fn($k) => "$k = ?", array_keys($data)));

        $sql = "UPDATE {$this->table} SET $fields WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $types = $this->buildTypes($data) . "i";
        $values = array_values($data);
        $values[] = $id;

        $stmt->bind_param($types, ...$values);

        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare(
            "DELETE FROM {$this->table} WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ======================
    // SOFT DELETE
    // ======================

    public function softDelete($id) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ?"
        );
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ======================
    // RESET QUERY
    // ======================

    private function reset() {
        $this->select = "*";
        $this->joins = [];
        $this->wheres = [];
        $this->bindings = [];
        $this->orderBy = "";
        $this->limit = "";
        $this->offset = "";
    }
}