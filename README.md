## Requirements

## Installation
- Setup the service provider:
    in bootstrap/app.php add the following line:
    ```php
    $app->register(LumenRequestParser\Providers\RequestParserProvider::class);
    ```
    
## Usage
```php
    // app/API/V1/Models/UserController.php
    namespace App\Api\V1\Http\Controllers;
    
    use App\Api\V1\Models\User;

    use LumenRequestParser\Traits\RequestParserTrait;
    use LumenRequestParser\Traits\RequestBuilderApplierTrait;
    
    class UserController extends Controller
    {
        use RequestParserTrait;
        use RequestBuilderApplierTrait;
                
        public function index(Request $request)
        {
            $params = $this->parseQueryParams($request);
            $query = User::query();
            $userPaginator = $this->applyParams($query, $params);

            return response()->json($userPaginator);
        }
    }
```