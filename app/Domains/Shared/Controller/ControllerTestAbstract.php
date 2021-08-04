<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use Illuminate\Mail\Mailable;
use Faker\Factory as FactoryFaker;
use Faker\Generator as GeneratorFaker;

abstract class ControllerTestAbstract extends ControllerAbstract
{
    /**
     * @var \Faker\Generator
     */
    protected GeneratorFaker $faker;

    /**
     * @return \Faker\Generator
     */
    final protected function faker(): GeneratorFaker
    {
        return $this->faker ??= FactoryFaker::create('es_ES');
    }

    /**
     * @param \Illuminate\Mail\Mailable $mail
     *
     * @return \Illuminate\Http\Response
     */
    final protected function responseMail(Mailable $mail): Response
    {
        return response($mail->render());
    }
}
