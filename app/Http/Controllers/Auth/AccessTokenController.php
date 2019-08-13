<?php
namespace App\Http\Controllers\Auth;

use Exception;
use App\User;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use League\OAuth2\Server\Exception\OAuthServerException;

use function GuzzleHttp\json_encode;

class AccessTokenController extends \Laravel\Passport\Http\Controllers\AccessTokenController
{
     /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected const ATTEMPT_LOGIN_FAIL = 'ATTEMPT_LOGIN_FAIL';
    protected const ATTEMPT_LOGIN_SUCCESS = 'ATTEMPT_LOGIN_SUCCESS';

    private function parseAttemptLog(ServerRequestInterface $request, bool $success = true, string $message = '')
    {
        $parseHeaders = json_encode($request->getHeaders());
        $parseBody = json_encode(array_except($request->getParsedBody(), ['password']));
        $parseTime = Carbon::now()->format('Y-m-d H:i:s');

        $logTxt = $success ? self::ATTEMPT_LOGIN_SUCCESS : self::ATTEMPT_LOGIN_FAIL . 
            " :: Headers: {$parseHeaders} :: Body: {$parseBody} :: Time: {$parseTime}";
        
        $logTxt .= empty($message) ? '' : " :: Message: {$message}";

        $type = $success ? 'notice' : 'warning';
        Log::{$type}($logTxt);
    }
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            $username = $request->getParsedBody()['username'];

            $user = new User();
            $data = $user->findForPassport($username)->toArray();
            $data['oauth'] = json_decode(parent::issueToken($request)->getContent(), true);
            if(isset($data['oauth']["error"])) {
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);
            }
            
            $this->parseAttemptLog($request);
            return response()->json($data);
        }
        catch (ModelNotFoundException $e) {
            $message = 'User not found';
            $this->parseAttemptLog($request, false, $message);
            return response()->json(['message' => $message], 401);
        }
        catch (OAuthServerException $e) {
            $message = 'The password is not correct';
            $this->parseAttemptLog($request, false, $message);
            return response()->json(['message' => $message], 401);
        }
        catch (Exception $e) {
            $message = 'An error occurred. Please, try again later';
            $this->parseAttemptLog($request, false, $message);
            return response()->json(['message' => $message], 500);
        }
    }
}