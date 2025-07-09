<?php
/**
 * Clase Database para manejar la conexión a la base de datos
 */
class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database = 'SunObra';
    private $connection;
    
    public function __construct() {
        $this->connect();
    }
    
    /**
     * Establecer conexión con la base de datos
     */
    private function connect() {
        try {
            // Configurar opciones de conexión para mejor rendimiento
            $options = [
                MYSQLI_OPT_CONNECT_TIMEOUT => 5,
                MYSQLI_OPT_READ_TIMEOUT => 30,
            ];
            
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->connection->connect_error) {
                throw new Exception("Conexión fallida: " . $this->connection->connect_error);
            }
            
            // Establecer charset
            $this->connection->set_charset("utf8mb4");
            
            // Configurar opciones de rendimiento
            $this->connection->query("SET SESSION sql_mode = ''");
            $this->connection->query("SET SESSION wait_timeout = 600");
            $this->connection->query("SET SESSION interactive_timeout = 600");
            
        } catch (Exception $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Preparar una consulta
     * @param string $sql Consulta SQL
     * @return mysqli_stmt
     */
    public function prepare($sql) {
        $stmt = $this->connection->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $this->connection->error);
        }
        
        return $stmt;
    }
    
    /**
     * Ejecutar una consulta
     * @param string $sql Consulta SQL
     * @return mysqli_result|bool
     */
    public function query($sql) {
        $result = $this->connection->query($sql);
        
        if ($result === false) {
            throw new Exception("Error al ejecutar la consulta: " . $this->connection->error);
        }
        
        return $result;
    }
    
    /**
     * Obtener el ID del último registro insertado
     * @return int
     */
    public function insert_id() {
        return $this->connection->insert_id;
    }
    
    /**
     * Obtener el número de filas afectadas
     * @return int
     */
    public function affected_rows() {
        return $this->connection->affected_rows;
    }
    
    /**
     * Escapar una cadena para prevenir SQL injection
     * @param string $string Cadena a escapar
     * @return string
     */
    public function escape_string($string) {
        return $this->connection->real_escape_string($string);
    }
    
    /**
     * Iniciar una transacción
     */
    public function begin_transaction() {
        $this->connection->begin_transaction();
    }
    
    /**
     * Confirmar una transacción
     */
    public function commit() {
        $this->connection->commit();
    }
    
    /**
     * Revertir una transacción
     */
    public function rollback() {
        $this->connection->rollback();
    }
    
    /**
     * Cerrar la conexión
     */
    public function close() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
    
    /**
     * Destructor para cerrar la conexión automáticamente
     */
    public function __destruct() {
        $this->close();
    }
    
    /**
     * Verificar si la conexión está activa
     * @return bool
     */
    public function is_connected() {
        return $this->connection && !$this->connection->connect_error;
    }
    
    /**
     * Obtener la conexión mysqli
     * @return mysqli
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Obtener información de la conexión
     * @return array
     */
    public function get_connection_info() {
        return [
            'host' => $this->host,
            'database' => $this->database,
            'connected' => $this->is_connected(),
            'error' => $this->connection ? $this->connection->error : null
        ];
    }
} 