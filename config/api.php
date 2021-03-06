<?php

return [

    /*
     * API_STANDARDS_TREE 有是三个值可选
     *
     * x 本地开发的或私有环境的
     * prs 未对外发布的，提供给公司 app，单页应用，桌面应用等
     * vnd 对外发布的，开放给所有用户
     */

    'standardsTree' => env('API_STANDARDS_TREE', 'x'),

    /*
     * API_SUBTYPE 一般情况下是我们项目的简称
     */
    'subtype' => env('API_SUBTYPE', ''),


    /*
     * 默认的 API 版本
     */

    'version' => env('API_VERSION', 'v1'),

    //---------------------------------------------------------------------------

    /*
     * 为 API 设置一个前缀来访问 例如 dozhan.cn/api
     */

    'prefix' => env('API_PREFIX', null),

    /*
    |--------------------------------------------------------------------------|
    |---------------- API_PREFIX 和 API_DOMAIN 两者有且只有一个 -----------------|
    |--------------------------------------------------------------------------|
    */

    /*
     * 为 API 设置一个 子域名 来访问 例如 api.dozhan.cn
     */

    'domain' => env('API_DOMAIN', null),

    //---------------------------------------------------------------------------

    /*
    |--------------------------------------------------------------------------
    | Name
    |--------------------------------------------------------------------------
    |
    | When documenting your API using the API Blueprint syntax you can
    | configure a default name to avoid having to manually specify
    | one when using the command.
    |
    */

    'name' => env('API_NAME', null),

    /*
    |--------------------------------------------------------------------------
    | Conditional Requests
    |--------------------------------------------------------------------------
    |
    | Globally enable conditional requests so that an ETag header is added to
    | any successful response. Subsequent requests will perform a check and
    | will return a 304 Not Modified. This can also be enabled or disabled
    | on certain groups or routes.
    |
    */

    'conditionalRequest' => env('API_CONDITIONAL_REQUEST', true),


    /*
     * 是否开启严格模式，如果开启，则必须使用 Accept 头才可以访问 API，也就是说直接通过浏览器，访问某个 GET 调用的接口将会报错.可以根据需求开启，默认情况下为 false。
     */

    'strict' => env('API_STRICT', false),


    /*
     * 测试环境，打开 debug，方便我们看到错误信息，定位错误。
     */

    'debug' => env('API_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Generic Error Format
    |--------------------------------------------------------------------------
    |
    | When some HTTP exceptions are not caught and dealt with the API will
    | generate a generic error response in the format provided. Any
    | keys that aren't replaced with corresponding values will be
    | removed from the final response.
    |
    */

    'errorFormat' => [
        'message' => ':message',
        'errors' => ':errors',
        'code' => ':code',
        'status_code' => ':status_code',
        'debug' => ':debug',
    ],

    /*
    |--------------------------------------------------------------------------
    | API Middleware
    |--------------------------------------------------------------------------
    |
    | Middleware that will be applied globally to all API requests.
    |
    */

    'middleware' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Providers
    |--------------------------------------------------------------------------
    |
    | The authentication providers that should be used when attempting to
    | authenticate an incoming API request.
    |
    */

    'auth' => [
        'jwt' => 'Dingo\Api\Auth\Provider\JWT',
    ],

    /*
    |--------------------------------------------------------------------------
    | Throttling / Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Consumers of your API can be limited to the amount of requests they can
    | make. You can create your own throttles or simply change the default
    | throttles.
    |
    */

    'throttling' => [

    ],

    /*
    |--------------------------------------------------------------------------
    | Response Transformer
    |--------------------------------------------------------------------------
    |
    | Responses can be transformed so that they are easier to format. By
    | default a Fractal transformer will be used to transform any
    | responses prior to formatting. You can easily replace
    | this with your own transformer.
    |
    */

    'transformer' => env('API_TRANSFORMER', Dingo\Api\Transformer\Adapter\Fractal::class),

    /*
    |--------------------------------------------------------------------------
    | Response Formats
    |--------------------------------------------------------------------------
    |
    | Responses can be returned in multiple formats by registering different
    | response formatters. You can also customize an existing response
    | formatter with a number of options to configure its output.
    |
    */

    'defaultFormat' => env('API_DEFAULT_FORMAT', 'json'),

    'formats' => [

        'json' => Dingo\Api\Http\Response\Format\Json::class,

    ],

    'formatsOptions' => [

        'json' => [
            'pretty_print' => env('API_JSON_FORMAT_PRETTY_PRINT_ENABLED', false),
            'indent_style' => env('API_JSON_FORMAT_INDENT_STYLE', 'space'),
            'indent_size' => env('API_JSON_FORMAT_INDENT_SIZE', 2),
        ],

    ],

    /*
     * 接口频率限制
     */
    'rate_limits' => [
        // 访问频率限制，次数/分钟
        'access' => [
            'expires' => env('RATE_LIMITS_EXPIRES', 1),
            'limit'  => env('RATE_LIMITS', 60),
        ],
        // 登录相关，次数/分钟
        'sign' => [
            'expires' => env('SIGN_RATE_LIMITS_EXPIRES', 1),
            'limit'  => env('SIGN_RATE_LIMITS', 10),
        ],
    ],

];
