<?php declare(strict_types=1);

namespace App\Domains\App\Controller;

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

        $this->actionCall('viewKey', null, $key);

        return $this->json(['value' => $this->row->payloadEncoded($key)]);
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
     * @return void
     */
    protected function viewKey(string $key): void
    {
        $this->action(null, ['key' => $key])->viewKey();
    }
}
