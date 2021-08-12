<?php declare(strict_types=1);

namespace App\Domains\App\ControllerApi;

use Illuminate\Http\JsonResponse;
use App\Domains\App\Model\App as Model;

class PayloadKey extends ControllerAbstract
{
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

        $this->action(null, ['key' => $key])->viewKey();

        return $this->json(['value' => $this->value($key)]);
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
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function value(string $key): string
    {
        return base64_encode(strval($this->row->payload($key)));
    }
}
