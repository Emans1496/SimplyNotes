<?php
class DBSessionHandler implements SessionHandlerInterface {
    private $conn;
    private $table = 'sessions';

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function open(string $savePath, string $sessionName): bool {
        // Nessuna azione necessaria poiché la connessione è già disponibile
        return true;
    }

    public function close(): bool {
        // Chiudi la connessione al database se necessario
        // $this->conn = null; // Se desideri chiudere la connessione
        return true;
    }

    public function read(string $id): string {
        $stmt = $this->conn->prepare("SELECT data FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $row['data'];
        }
        return '';
    }

    public function write(string $id, string $data): bool {
        $currentTime = date('Y-m-d H:i:s');
        $stmt = $this->conn->prepare("INSERT INTO {$this->table} (id, data, last_access) VALUES (:id, :data, :last_access)
            ON CONFLICT (id) DO UPDATE SET data = :data, last_access = :last_access");
        return $stmt->execute([
            'id' => $id,
            'data' => $data,
            'last_access' => $currentTime
        ]);
    }

    public function destroy(string $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function gc(int $maxLifetime): int|false {
        $past = date('Y-m-d H:i:s', time() - $maxLifetime);
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE last_access < :past");
        return $stmt->execute(['past' => $past]);
    }
}
?>
