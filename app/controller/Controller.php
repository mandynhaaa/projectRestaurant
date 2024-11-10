<?

namespace App\Controller;

abstract class Controller {

    protected $container;

    public function render(string $view, array $data = []): void
    {
        extract($data);

        ob_start();
        require __DIR__ . "/../view/{$view}.php";
        $content = ob_get_clean();

        require __DIR__ . '/../view/layout.php';
    }
}