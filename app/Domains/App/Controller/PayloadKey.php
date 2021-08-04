<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

use Illuminate\Http\JsonResponse;
use App\Domains\App\Model\App as Model;

class PayloadKey extends ControllerAbstract
{
    /**
     * @var string
     */
    protected string $key;

    /**
     * @param int $id
     * @param string $key
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id, string $key): JsonResponse
    {
        $this->check($key);
        $this->row($id);

        $this->actionCall('viewKey');

        return $this->json(['value' => $this->value()]);
    }

    /**
     * @param string $key
     *
     * @return void
     */
    protected function check(string $key): void
    {
        if (in_array($key, Model::PAYLOAD) === false) {
            helper()->notFound();
        }

        $this->key = $key;
    }

    /**
     * @return string
     */
    protected function value(): string
    {
        return base64_encode(strval($this->row->payload($this->key)));
    }

    /**
     * @return void
     */
    protected function viewKey(): void
    {
        $this->action(null, ['key' => $this->key])->viewKey();
    }
}
