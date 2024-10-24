<?

namespace App\Model;

interface Table {

    public function insert(): int;
    public function update(int $id): bool;
    public function delete(int $id): bool;
}

?>