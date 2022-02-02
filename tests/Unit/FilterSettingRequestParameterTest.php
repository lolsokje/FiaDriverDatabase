<?php

use App\Http\Middleware\FilterSettingRequestParameters;

it('filters invalid settings from the settings store request', function () {
    $request = new \Illuminate\Http\Request();

    $request->merge([
        'year' => 2015,
        'not allowed key' => 'some value',
    ]);

    $middleware = new FilterSettingRequestParameters();

    $middleware->handle($request, function (\Illuminate\Http\Request $request) {
        $params = $request->all();

        expect($params)->toHaveKey('year')->not()->toHaveKey('not allowed key');
    });
});
