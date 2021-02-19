<?php

namespace HQRentalsPlugin\HQRentalsDb;

class HQRentalsDbManager{
    protected $db;
    protected $charset;
    protected $dbPrefix;
    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->charset = $wpdb->get_charset_collate();
        $this->dbPrefix = $wpdb->get_blog_prefix();
    }
    public function createTable($tableName, $tableContent)
    {
        $sqlQuery = $this->resolveCreateStatementString($tableName, $tableContent);
        return $this->query($sqlQuery);
    }
    private function resolveCreateStatementString($tableName, $tableContent) : string
    {
        $columns = $this->resolveTableContentForQuery($tableContent);
        return $this->db->prepare(
            'CREATE TABLE IF NOT EXISTS ' . $this->dbPrefix . $tableName . ' (
                  '. $columns .'
                ) ' . $this->charset . ';'
        );
    }
    private function resolveTableContentForQuery($arrayWithColumns) : string
    {
        $sqlString = '';
        if(is_array($arrayWithColumns)){
            foreach ($arrayWithColumns as $key => $column){
                $sqlString .= $column['column_name'] . ' ' . $column['column_data_type'] . ((count($arrayWithColumns) - 1 === $key) ? '' : ',');
            }
        }
        return $sqlString;
    }
    public function dropTable($tableName){
        $sql = `DROP TABLE {$tableName}`;
        return $this->db->query($sql);
    }
    public function insert($tableName, $data, $format = null)
    {
        try {
            return $this->db->insert( (strpos($tableName, $this->dbPrefix) !== false) ? ($tableName) : ($this->dbPrefix . $tableName) , $data, $format);
        }catch (\Exception $e){
            return $this->db->update( (strpos($tableName, $this->dbPrefix) !== false) ? ($tableName) : ($this->dbPrefix . $tableName) , $data , $data);
        }
    }
    public function remove(){

    }
    public function update(){

    }
    public function getTablesPrefix()
    {
        return $this->dbPrefix;
    }
    public function getResults($query)
    {
        return $this->db->get_results($query, OBJECT);
    }
    private function query($query)
    {
        $queryResult = $this->db->query($query);
        if($queryResult){
            $data = $this->resolveQuery(
                true,
                null,
                null
            );
        }else{
            $data = $this->resolveQuery(
                false,
                null,
                'Error on Query'
            );
        }
        return $data;
    }
    private function resolveQuery($success, $data, $errors) : \stdClass
    {
        $data = new \stdClass();
        $data->success = $success;
        $data->data = $data;
        $data->errors = $errors;
        return $data;
    }
}