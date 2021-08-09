<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Model\User as Model;
use App\Domains\User\Service\Certificate\Check as CertificateCheck;
use App\Exceptions\ValidatorException;

class ProfileCertificate extends ActionAbstract
{
    /**
     * @var ?string
     */
    protected ?string $certificate;

    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->certificate();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function certificate(): void
    {
        $this->certificate = CertificateCheck::fromServer($this->request->server());
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkCertificate();
        $this->checkExists();
    }

    /**
     * @return void
     */
    protected function checkCertificate(): void
    {
        if (empty($this->certificate)) {
            throw new ValidatorException(__('user-profile-certificate.error.not-loaded'));
        }
    }

    /**
     * @return void
     */
    protected function checkExists(): void
    {
        if (Model::byIdNot($this->row->id)->byCertificate($this->certificate)->count()) {
            throw new ValidatorException(__('user-profile-certificate.error.exists'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->certificate = $this->certificate;
        $this->row->save();
    }
}
