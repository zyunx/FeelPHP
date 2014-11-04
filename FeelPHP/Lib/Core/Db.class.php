<?php

class Db {

    private $_tablePrefix = 'bl_';
    private $_tables;
    private $_cond = TRUE;
    private $_selectFields;
    private $_updateFields;
    private $_insertFields;
    private $_customQuery;

    const QUERY_TYPE_SELECT = 'select';
    const QUERY_TYPE_UPDATE = 'update';
    const QUERY_TYPE_DELETE = 'delete';
    const QUERY_TYPE_INSERT = 'insert';
    const QUERY_TYPE_CUSTOM = 'custom';

    private $_queryType;

    // specify tables
    public function tables($tables) {
        $this->_tables = $tables;
        return $this;
    }

    public function from($tables) {
        return $this->tables($tables);
    }

    public function update($tables) {
        return $this->tables($tables);
    }

    public function into($tables) {
        return $this->tables($tables);
    }

    public function join($db) {
        
    }

    // specify condition
    public function where($cond) {
        is_array($cond) && $this->_escapeStringRecursive($cond);
        $this->_cond = $cond;
        return $this;
    }

    // specify fields;
    public function select($fields = '*') {
        $this->_queryType = self::QUERY_TYPE_SELECT;
        $this->_selectFields = $fields;
        return $this;
    }

    public function set($updateFields) {
        $this->_queryType = self::QUERY_TYPE_UPDATE;
        $this->_updateFields = $updateFields;
        return $this;
    }

    public function insert($insertFields) {
        $this->_queryType = self::QUERY_TYPE_INSERT;
        $this->_insertFields = $insertFields;
        return $this;
    }

    public function delete() {
        $this->_queryType = self::QUERY_TYPE_DELETE;
        return $this;
    }

    public function query() {
        $this->queryType = self::QUERY_TYPE_CUSTOM;
        return $this;
    }

    public function go() {
        if ($this->_queryType === self::QUERY_TYPE_SELECT) {
            $sql = 'SELECT ';
            $sql .= $this->_parsetSelectFields();

            $sql .= ' FROM ' . $this->_parseTables();

            $sql .= $this->_parseWhere();

            //echo $sql;
            $result = $this->_execute($sql);
            $ret = array();

            while ($row = $result->fetch_assoc()) {
                $ret[] = $row;
            }
            return $ret;
        } else if ($this->_queryType === self::QUERY_TYPE_UPDATE) {
            $sql = 'UPDATE ';
            $sql .= $this->_parseTables();
            $sql .= $this->_parseUpdateFields();
            $sql .= $this->_parseWhere();

            return $this->_execute($sql);
        } else if ($this->_queryType === self::QUERY_TYPE_DELETE) {
            $sql = 'DELETE FROM ';
            $sql .= $this->_parseTables();
            $sql .= $this->_parseWhere();

            return $this->_execute($sql);
        } else if ($this->_queryType === self::QUERY_TYPE_INSERT) {
            $sql = 'INSERT INTO ';
            $sql .= $this->_parseTables();
            $sql .= $this->_parseInsertFields();

            return $this->_execute($sql) ? FeelMySQLi::getInstance()->insert_id : FALSE;
        } else if ($this->_queryType === self::QUERY_TYPE_CUSTOM) {
            return $this->_execute($this->_customQuery);
        } else {
            trigger_error("Invalid query type.", E_USER_ERROR);
        }


        return FALSE;
    }

    private function _execute($sql) {
        $ret = FeelMySQLi::getInstance()->query($sql);
        if ($ret) {
            return $ret;
        } else {
            trigger_error(FeelMySQLi::getInstance()->error, E_USER_ERROR);
            return FALSE;
        }
    }

    private function _parsetSelectFields() {
        // select field        
        if (is_array($this->_selectFields)) {
            $sql = implode(',', $this->_selectFields);
        } else if (is_string($this->_selectFields)) {
            $sql = $this->_selectFields;
        }
        return " $sql ";
    }

    private function _parseUpdateFields() {
        if (is_array($this->_updateFields)) {
            $ss = array();
            foreach ($this->_updateFields as $k => $v) {
                if (is_string($v)) {
                    // [foo] means the value of the record's foo field
                    if ((substr($v, 0, 1) === '[' && ']' === substr($v, -1))) {
                        $v = substr($v, 1, strlen($v) - 2);
                    } else {
                        $v = "'$v'";
                    }
                }
                $ss[] = "$k = $v";
            }
            $sql = implode(',', $ss);
        } else if (is_string($this->_updateFields)) {
            $sql = $this->_updateFields;
        }

        return " SET $sql ";
    }

    private function _parseInsertFields() {
        if (is_array($this->_insertFields)) {
            foreach ($this->_insertFields as &$v) {
                    if (is_string($v))
                        $v = "'$v'";
            }
            $f = '(' . implode(',', array_keys($this->_insertFields)) . ')';
            $vs = 'VALUES (' . implode(',', array_values($this->_insertFields)) . ')';
            return "$f $vs ";
        } else {
            return FALSE;
        }
    }

    private function _parseTables() {
        if (empty($this->_tables)) {
            return trigger_error('No tables');
        }

        return " $this->_tablePrefix$this->_tables ";
    }

    private function _parseWhere() {
        if (!empty($this->_cond)) {
            $where = array();
            if (is_array($this->_cond)) {
                foreach ($this->_cond as $k => $v) {
                    if (is_string($v))
                        $v = "'$v'";
                    $where[] = "$k = $v";
                }
                $where = implode(' AND ', $where);
            } else if (is_string($this->_cond)) {
                $where = $this->_cond;
            }
            $sql = " WHERE $where ";
        } else {
            $sql = ' ';
        }

        return $sql;
    }

    private function _escapeStringRecursive(&$s) {
        if (is_array($s)) {
            foreach ($s as &$v) {
                $this->_escapeStringRecursive($v);
            }
        } else if (is_string($s)) {
            // [foo] means the value of the record's foo field
            if ((substr($s, 0, 1) === '[' && ']' === substr($s, -1))) {
                $s = substr($s, 1, strlen($s) - 2);
            } else {
                $s = FeelMySQLi::getInstance()->escape_string($s);
            }
        }
    }

}
