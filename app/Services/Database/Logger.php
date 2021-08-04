<?php declare(strict_types=1);

namespace App\Services\Database;

use DateTime;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Logger
{
    /**
     * @var array
     */
    protected static array $file = [];

    /**
     * @return void
     */
    public static function listen(): void
    {
        if (config('logging.channels.database.enabled') !== true) {
            return;
        }

        foreach (config('database.connections') as $name => $config) {
            static::listenConnection($name, $config);
        }
    }

    /**
     * @param string $name
     * @param array $config
     *
     * @return void
     */
    protected static function listenConnection(string $name, array $config): void
    {
        if (static::listenConnectionLogEnabled($name, $config) === false) {
            return;
        }

        static::listenConnectionLoad($name);
        static::listenConnectionWrite($name, '['.date('Y-m-d H:i:s').'] ['.Request::method().'] '.Request::fullUrl());

        DB::connection($name)->listen(static function ($sql) use ($name) {
            static::listenConnectionLog($name, $sql);
        });
    }

    /**
     * @param string $name
     * @param array $config
     *
     * @return bool
     */
    protected static function listenConnectionLogEnabled(string $name, array $config): bool
    {
        return empty(static::$file[$name]) && (($config['log'] ?? false) === true);
    }

    /**
     * @param string $name
     * @param \Illuminate\Database\Events\QueryExecuted $sql
     *
     * @return void
     */
    protected static function listenConnectionLog(string $name, QueryExecuted $sql): void
    {
        $query = $sql->sql;
        $bindings = $sql->bindings;

        foreach ($bindings as $i => $binding) {
            if ($binding instanceof DateTime) {
                $bindings[$i] = $binding->format('Y-m-d H:i:s');
            } elseif (is_string($binding)) {
                $bindings[$i] = "'${binding}'";
            } elseif (is_bool($binding)) {
                $bindings[$i] = $binding ? 'true' : 'false';
            }

            if (is_string($i)) {
                $query = str_replace(':'.$i, $bindings[$i], $query);
            }
        }

        static::listenConnectionWrite($name, vsprintf(str_replace(['%', '?'], ['%%', '%s'], $query), $bindings));
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected static function listenConnectionLoad(string $name): void
    {
        static::file($name);

        $dir = dirname(static::$file[$name]);

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }
    }

    /**
     * @param string $name
     *
     * @return void
     */
    protected static function file(string $name): void
    {
        $file = array_filter(explode('-', preg_replace('/[^a-z0-9]+/i', '-', Request::path())));
        $file = implode('-', array_map(static fn ($value) => substr($value, 0, 20), $file)) ?: '-';

        static::$file[$name] = storage_path('logs/query/'.$name.'/'.date('Y-m-d').'/'.substr($file, 0, 150).'.log');
    }

    /**
     * @param string $name
     * @param string $message
     *
     * @return void
     */
    protected static function listenConnectionWrite(string $name, string $message): void
    {
        file_put_contents(static::$file[$name], "\n\n".$message, FILE_APPEND | LOCK_EX);
    }
}
