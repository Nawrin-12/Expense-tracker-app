<?php
namespace App\Http\Controllers;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ForgetPassRequest;
use App\Http\Requests\ResetPassRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Traits\ApiResponses;

class AuthController extends Controller
{
    use ApiResponses;
    public function loginUser()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): JsonResponse
    {
        // Retrieve Validated Data
        $validated = $request->validated();

        try {
            $user = User::query()->where('email', $validated['email'])->first();

            // Return If User Not Found
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ]);
            }

            // Check Credentials
            if (Hash::check($validated['password'], $user->password)) {
                $user->tokens()->delete();
                return response()->json([
                    'message' => 'Login Successful.',
                    $user->createToken('authToken')->accessToken,
//                    'redirect_to' => route('expenses.index')
                ]);

            } else {
                return response()->json([
                    'message' => 'Login Failed. Wrong Password Given.'
                ]);
            }
        } catch (\Exception $exception) {
            // Log Error
            Log::error('Full Error: ' . $exception->getMessage());
//            Log::error($exception->getMessage() . ' File: ' . $exception->getFile() . ' Line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Something Went Wrong. Please try later.',
                'error' => $exception->getMessage()
            ]);
        }
    }

    public function registerUser()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'number' => $validated['number'],
                'password' => Hash::make($validated['password']),

            ]);
            return response()->json([
                'message' => 'Registration Successful',
                'user' => $user,
            ]);


        } catch (\Exception $exception) {
            Log::error($exception->getMessage() . ' File: ' . $exception->getFile() . ' Line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Registration Failed. Please try again.'
            ]);
        }

    }

//    public function forgetPass(){
//        return view('auth.forgetpass');
//    }

    public function forgetPassword(ForgetPassRequest $request): JsonResponse
    {
        $validated = $request->validated();
//        $request->validate([
//            'email' => 'required|email|exists:users,email',
//        ]);

        try {
            $user = User::query()->where('email', $validated['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ]);
            }
            $token = str::random(20);

            DB::table('password_reset')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
//            Log::info("password reset token is {$request->email}: $token");
            Mail::raw("password reset token is: $token", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Reset Password');
            });
//            Mail::to({$request->email}, ['token' => $token], function ($message) use ($request) {
//                $message->to($request->email);
//                $message->subject('Reset Password');
//            });
            return response()->json([
                'message' => 'Password token has been sent to your email'
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage() . ' File: ' . $exception->getFile() . ' Line: ' . $exception->getLine());
//            return $this->ErrorMessage();
            return response()->json([
                'message' => 'Something Went Wrong. Please try again'
            ]);

        }
    }

    public function resetPassword(ResetPassRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            $user = User::query()->where('email', $validated['email'])->first();
            if (!$user) {
                return response()->json([
                    'message' => 'User not found'
                ]);
            } else {
                $reset = DB::table('password_reset')
                    ->where('email', $request->email)
                    ->where('token', $request->token)
                    ->first();
                if (!$reset) {
                    return response()->json([
                        'message' => 'Reset Password Failed'
                    ]);
                }

                $user->password = Hash::make($request->password);
                $user->save();

                DB::table('password_reset')
                    ->where('email', $request->email)->delete();

                return response()->json([
                    'message' => 'Password Reset Successful'
                ]);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage() . ' File: ' . $exception->getFile() . ' Line: ' . $exception->getLine());
            return response()->json([
                'message' => 'Something went wrong. Please try again'
            ]);

        }
    }
}
