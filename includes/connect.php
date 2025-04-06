<?php
class JsonDB {
    private $dataFile;
    private $data;

    public function __construct() {
        $this->dataFile = __DIR__ . '/data.json';
        $this->loadData();
    }

    private function loadData() {
        if (file_exists($this->dataFile)) {
            $jsonContent = file_get_contents($this->dataFile);
            $this->data = json_decode($jsonContent, true) ?? [
                'categories' => [],
                'products' => [],
                'users' => [],
                'chat_logs' => [],
                'cart' => [],
                'wishlist' => []
            ];
        } else {
            $this->data = [
                'categories' => [],
                'products' => [],
                'users' => [],
                'chat_logs' => [],
                'cart' => [],
                'wishlist' => []
            ];
            $this->saveData();
        }
    }

    private function saveData() {
        file_put_contents($this->dataFile, json_encode($this->data, JSON_PRETTY_PRINT));
    }

    public function query($collection, $conditions = []) {
        if (!isset($this->data[$collection])) {
            return [];
        }

        $result = $this->data[$collection];

        foreach ($conditions as $key => $value) {
            $result = array_filter($result, function($item) use ($key, $value) {
                return isset($item[$key]) && $item[$key] == $value;
            });
        }

        return array_values($result);
    }

    public function insert($collection, $data) {
        if (!isset($this->data[$collection])) {
            $this->data[$collection] = [];
        }

        // Auto-increment ID
        $id = 1;
        if (!empty($this->data[$collection])) {
            $maxId = max(array_column($this->data[$collection], 'id'));
            $id = $maxId + 1;
        }
        $data['id'] = $id;
        $data['created_at'] = date('Y-m-d H:i:s');

        $this->data[$collection][] = $data;
        $this->saveData();

        return $id;
    }

    public function update($collection, $id, $data) {
        if (!isset($this->data[$collection])) {
            return false;
        }

        foreach ($this->data[$collection] as $key => $item) {
            if ($item['id'] == $id) {
                $this->data[$collection][$key] = array_merge($item, $data);
                $this->saveData();
                return true;
            }
        }

        return false;
    }

    public function delete($collection, $id) {
        if (!isset($this->data[$collection])) {
            return false;
        }

        foreach ($this->data[$collection] as $key => $item) {
            if ($item['id'] == $id) {
                unset($this->data[$collection][$key]);
                $this->data[$collection] = array_values($this->data[$collection]);
                $this->saveData();
                return true;
            }
        }

        return false;
    }

    public function count($collection, $conditions = []) {
        return count($this->query($collection, $conditions));
    }

    // New method to reset a collection
    public function resetCollection($collection) {
        if (isset($this->data[$collection])) {
            $this->data[$collection] = [];
            $this->saveData();
            return true;
        }
        return false;
    }
}

try {
    $con = new JsonDB();
} catch(Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
