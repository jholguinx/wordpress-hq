<?php

namespace HQRentalsPlugin\HQRentalsDb;

class HQRentalsDbManager
{
    protected $db;
    protected $charset;
    protected $dbPrefix;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->charset = $wpdb->get_charset_collate();
        $this->dbPrefix = $wpdb->get_blog_prefix();
    }

    public function createTable($tableName, $tableContent): \stdClass
    {
        $sqlQuery = $this->resolveCreateStatementString($tableName, $tableContent);
        return $this->query($sqlQuery);
    }

    public function selectFromTable($tableName, $columns, $where): \stdClass
    {
        $sqlQuery = $this->resolveSelectStatementString($tableName, $columns, $where);
        return $this->getResults($sqlQuery);
    }

    public function insertIntoTable($tableName, $columnData) : \stdClass
    {
        return $this->insert($tableName,$columnData);
    }

    public function updateIntoTable($tableName, $columnData, $where) : \stdClass
    {
        return $this->update($tableName,$columnData, $where);
    }

    private function resolveCreateStatementString($tableName, $tableContent): string
    {
        $columns = $this->resolveTableContentForQuery($tableContent);
        return $this->db->prepare(
            'CREATE TABLE IF NOT EXISTS ' . $this->dbPrefix . $tableName . ' (
                  ' . $columns . '
                ) ' . $this->charset . ';'
        );
    }

    private function resolveSelectStatementString($tableName, $tableColumns, $where): string
    {
        return $this->db->prepare(
            'SELECT ' . $tableColumns . ' FROM ' . $this->dbPrefix . $tableName . ' WHERE ' . $where . ';'
        );
    }

    private function resolveTableContentForQuery($arrayWithColumns): string
    {
        $sqlString = '';
        if (is_array($arrayWithColumns)) {
            foreach ($arrayWithColumns as $key => $column) {
                $sqlString .= $column['column_name'] . ' ' . $column['column_data_type'] . ((count($arrayWithColumns) - 1 === $key) ? '' : ',');
            }
        }
        return $sqlString;
    }

    public function dropTable($tableName)
    {
        $sql = `DROP TABLE {$tableName}`;
        return $this->db->query($sql);
    }

    public function insert($tableName, $data) : \stdClass
    {
        $results = $this->db->insert($this->dbPrefix . $tableName, $data);
        if($results){
            return $this->resolveQuery(true,$results,null);
        }else{
            return $this->resolveQuery(false,null,'ERROR');
        }
    }
    public function update($tableName, $data, $where) : \stdClass
    {
        $results = $this->db->update($tableName, $data, $where);
        if($results){
            return $this->resolveQuery(true,$results,null);
        }else{
            return $this->resolveQuery(false,null,'ERROR');
        }
    }

    public function remove()
    {

    }



    public function getTablesPrefix(): string
    {
        return $this->dbPrefix;
    }

    public function getResults($query): \stdClass
    {
        $result = $this->db->get_results($query, OBJECT);
        if ($result) {
            $data = $this->resolveQuery(true, $result, null, $query);
        } else {
            $data = $this->resolveQuery(false, $result, 'ERROR', $query);
        }
        return $data;
    }

    private function query($query)
    {
        $queryResult = $this->db->query($query);
        if($queryResult){
            $data = $this->resolveQuery(
                true,
                null,
                null,
                $query
            );
        }else{
            $data = $this->resolveQuery(
                false,
                null,
                'Error on Query',
                $query
            );
        }
        return $data;
    }
    private function resolveQuery($success, $dataToReturn, $errors, $query = null) : \stdClass
    {
        $data = new \stdClass();
        $data->success = $success;
        $data->data = $dataToReturn;
        $data->errors = $errors;
        $data->query = $query;
        return $data;
    }
}