<?php

namespace App\Providers;

use App\Settings\GeneralSettings;
use Godruoyi\Snowflake\RandomSequenceResolver;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('snowflake', function () {
            return (new Snowflake(
                config('snowflake.data_center'),
                config('snowflake.worker_node')
            )
            )
                ->setStartTimeStamp(strtotime('2022-01-25') * 1000)
                ->setSequenceResolver(new RandomSequenceResolver);
        });
    }

    public function boot(): void
    {
        Model::preventLazyLoading();

        Model::unguard();

        JsonResource::withoutWrapping();
    }
}
