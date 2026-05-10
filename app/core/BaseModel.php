<?php
class BaseModel {
    protected $conn;
    protected $table;
    protected $select   = "*";
    protected $joins    = [];
    protected $wheres   = [];
    protected $bindings = [];
    protected $orderBy  = "";
    protected $limitVal = "";
    protected $offsetVal = "";

    public function __construct($conn, $table) {
        $this->conn  = $conn;
        $this->table = $table;
    }

    public function getConn() {
        return $this->conn;
    }

    // ── Type helpers ─────────────────────────────────────────
    private function getType($value) {
        if (is_int($value))   return "i";
        if (is_float($value)) return "d";
        return "s";
    }

    private function buildTypes($values) {
        $types = "";
        foreach ($values as $v) $types .= $this->getType($v);
        return $types;
    }

    // ── Query builder ────────────────────────────────────────
    public function select($fields = "*") {
        $this->select = $fields;
        return $this;
    }

    public function where($column, $value) {
        $this->wheres[]   = "$column = ?";
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
        $this->limitVal  = "LIMIT $limit";
        $this->offsetVal = "OFFSET $offset";
        return $this;
    }

    // ── Count (for pagination) ───────────────────────────────
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        if (!empty($this->wheres)) $sql .= " WHERE " . implode(" AND ", $this->wheres);
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) { $this->reset(); return 0; }
        if (!empty($this->bindings)) {
            $types = $this->buildTypes($this->bindings);
            $stmt->bind_param($types, ...$this->bindings);
        }
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $this->reset();
        return $row ? (int)$row['total'] : 0;
    }

    // ── Execute ──────────────────────────────────────────────
    private function buildQuery() {
        $sql = "SELECT {$this->select} FROM {$this->table}";
        if (!empty($this->joins))  $sql .= " " . implode(" ", $this->joins);
        if (!empty($this->wheres)) $sql .= " WHERE " . implode(" AND ", $this->wheres);
        if ($this->orderBy)        $sql .= " " . $this->orderBy;
        if ($this->limitVal)       $sql .= " " . $this->limitVal . " " . $this->offsetVal;
        return $sql;
    }

    public function get() {
        $sql  = $this->buildQuery();
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) { $this->reset(); return null; }
        if (!empty($this->bindings)) {
            $types = $this->buildTypes($this->bindings);
            $stmt->bind_param($types, ...$this->bindings);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $this->reset();
        return $result;
    }

    public function first() {
        $this->limit(1);
        $result = $this->get();
        return $result ? $result->fetch_assoc() : null;
    }

    // ── CRUD ─────────────────────────────────────────────────
    public function create($data) {
        $columns      = implode(",", array_keys($data));
        $placeholders = implode(",", array_fill(0, count($data), "?"));
        $sql          = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt         = $this->conn->prepare($sql);
        $types        = $this->buildTypes($data);
        $values       = array_values($data);
        $stmt->bind_param($types, ...$values);
        if ($stmt->execute()) return $this->conn->insert_id;
        return false;
    }

    public function update($id, $data) {
        $fields = implode(",", array_map(fn($k) => "$k = ?", array_keys($data)));
        $sql    = "UPDATE {$this->table} SET $fields WHERE id = ?";
        $stmt   = $this->conn->prepare($sql);
        $types  = $this->buildTypes($data) . "i";
        $values = array_values($data);
        $values[] = $id;
        $stmt->bind_param($types, ...$values);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function softDelete($id) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET deleted_at = NOW() WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ── Reset state ──────────────────────────────────────────
    private function reset() {
        $this->select    = "*";
        $this->joins     = [];
        $this->wheres    = [];
        $this->bindings  = [];
        $this->orderBy   = "";
        $this->limitVal  = "";
        $this->offsetVal = "";
    }
}
