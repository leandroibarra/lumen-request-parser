# Lumen request parser

## Description
A request query parameter parser for REST-APIs based on [ngabor84/lumen-api-query-parser](https://github.com/ngabor84/lumen-api-query-parser) and for Laravel's Lumen framework.

## Requirements
- PHP >=8.1
- Lumen framework >= 10.0
- Mockery >= 1.4.4 (dev)
- PHPUnit >= 10.0 (dev)

## Installation
- Add leandroibarra/lumen-request-parser to your composer.json and make composer update, or just execute:
    ```
    composer require leandroibarra/lumen-request-parser
    ```
- Setup the service provider:
    in bootstrap/app.php add the following line:
    ```php
    $app->register(LumenRequestParser\Providers\RequestParserProvider::class);
    ```
    
## Usage
```php
    // app/Http/Controllers/UserController.php
    namespace App\Http\Controllers;
    
    use App\Models\User;

    use LumenRequestParser\Traits\RequestParserTrait;
    use LumenRequestParser\Traits\RequestBuilderApplierTrait;
    
    class UserController extends Controller
    {
        use RequestParserTrait;
        use RequestBuilderApplierTrait;
                
        public function index(Request $request)
        {
            /**
             * I suggest to make a first level request validation. For example:
             * $this->validate($request, [
             *      'page' => 'nullable|integer|min:1',
             *      'limit' => 'nullable|integer|min:1|max:100',
             *      'filter' => [
             *          'nullable',
             *              'regex:/^([a-zA-Z]+:(ct|nct|sw|ew|eq|ne|gt|ge|lt|le|in|nin)+:[^,]+,)*([a-zA-Z]+:(ct|nct|sw|ew|eq|ne|gt|ge|lt|le|in|nin)+:[^,]+)$/i',
             *      ],
             *      'sort' => [
             *          'nullable',
             *          'regex:/^([-+]?[a-zA-Z]+(,[-+]?[a-zA-Z]+)*)?$/i'
             *      ]
             * ]);
             */

            $params = $this->parseQueryParams($request);
            /**
             * Or even you can set sorting or page size (limit) options. For example:
             * $options = ['sort' => 'email', 'limit' => 50];
             * $params = $this->parseQueryParams($request, $options);
             */

            $query = User::query();
            $userPaginator = $this->applyParams($query, $params);

            return response()->json($userPaginator);
        }
    }
```

## Query syntax

### Filtering
Request: /users?filter=first_name:ct:admin
Response: Will return the collection of the users whose first names contains the admin string.

__Available filter options__    

| Operator      | Description           | Example |
| ------------- | --------------------- | ------- |
| ct            | String contains       | name:ct:Peter |
| nct           | String NOT contains   | name:nct:Peter |
| sw	        | String starts with    | username:sw:admin |
| ew	        | String ends with      | email:ew:gmail.com |
| eq	        | Equals                | level:eq:3 |
| ne	        | Not equals            | level:ne:4 |
| gt	        | Greater than          | level:gt:2 |
| ge	        | Greater than or equal | level:ge:3 |
| lt	        | Lesser than           | level:lt:4 |
| le	        | Lesser than or equal  | level:le:3 |
| in	        | In array              | level:in:1&#124;2&#124;3 |

### Ordering
Request: /users?sort=name,-email
Response: Will return the collection of the users sort by their names ascending and by their email descending.

### Pagination
Request: /users?page=3
Response: Will return the third page of the collection of users.

### Pagination with page size (limit)
Request: /users?limit=50&page=2
Response: Will return a part of the collection of the users (from the 51st to 100th).