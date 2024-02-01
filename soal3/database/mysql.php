<?php
class DatabasePool
{
    private $db_host = "localhost";
    private $db_user = "test_user";
    private $db_pass = "test_user123";
    private $db_name = "soal3";
    private $pool = [];
    private $max_conn = 10;
    private $conn_count = 0;
    private $conn_id = 0;

    public function __construct($max_conn)
    {
        $this->max_conn = $max_conn;
    }
    public function getConnection(){
        if ($this->conn_count < $this->max_conn) {
            $this->conn_count++;
            $this->conn_id++;
            $this->pool[$this->conn_id] = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            return $this->pool[$this->conn_id];
        } else {
            foreach ($this->pool as $conn_id => $conn) {
                if ($conn->ping()) {
                    $this->conn_id = $conn_id;
                    return $conn;
                }
            }
            $this->conn_id++;
            $this->pool[$this->conn_id] = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            return $this->pool[$this->conn_id];
        }
    }

    public function releaseConnection($conn_id){
        $this->pool[$conn_id]->close();
        unset($this->pool[$conn_id]);
        $this->conn_count--;
    }

    public function closeAllConnections(){
        foreach ($this->pool as $conn_id => $conn) {
            $conn->close();
        }
        unset($this->pool);
        $this->conn_count = 0;
    }
}
