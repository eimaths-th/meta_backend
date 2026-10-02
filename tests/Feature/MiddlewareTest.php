<?php

namespace Tests\Feature;

use App\Http\Middleware\Admin;
use App\Http\Middleware\AuthenticateApiKey;
use App\Http\Middleware\CheckUserId;
use App\Http\Middleware\Godeye;
use App\Http\Middleware\Outhome;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\switchhome;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class MiddlewareTest extends TestCase
{
    public function test_api_key_middleware_accepts_known_keys(): void
    {
        $request = Request::create('/api-test', 'GET', [], [], [], ['HTTP_X_AUTH_KEY' => 'infinite@2022']);

        $response = (new AuthenticateApiKey())->handle($request, fn () => response('ok'));

        $this->assertSame('ok', $response->getContent());
    }

    public function test_api_key_middleware_rejects_unknown_keys(): void
    {
        $request = Request::create('/api-test', 'GET', [], [], [], ['HTTP_X_AUTH_KEY' => 'wrong']);

        $response = (new AuthenticateApiKey())->handle($request, fn () => response('ok'));

        $this->assertSame(401, $response->getStatusCode());
        $this->assertSame(['message' => 'Unauthorized.'], $response->getData(true));
    }

    public function test_admin_middleware_allows_authenticated_users(): void
    {
        $this->actingAs($this->user(10, 1));

        $response = (new Admin())->handle(Request::create('/admin-test'), fn () => response('ok'));

        $this->assertSame('ok', $response->getContent());
    }

    public function test_admin_middleware_aborts_guests(): void
    {
        $this->expectException(HttpException::class);

        (new Admin())->handle(Request::create('/admin-test'), fn () => response('ok'));
    }

    public function test_godeye_middleware_only_allows_user_id_four(): void
    {
        $this->actingAs($this->user(4, 1));

        $allowed = (new Godeye())->handle(Request::create('/godeye'), fn () => response('ok'));

        $this->assertSame('ok', $allowed->getContent());
    }

    public function test_godeye_middleware_redirects_other_users_home(): void
    {
        $this->actingAs($this->user(5, 1));

        $response = (new Godeye())->handle(Request::create('/godeye'), fn () => response('ok'));

        $this->assertSame(url('/home'), $response->headers->get('Location'));
    }

    public function test_check_user_id_middleware_allows_expected_admin_ids(): void
    {
        $middleware = new CheckUserId();

        $this->actingAs($this->user(4, 1));
        $firstAllowed = $middleware->handle(Request::create('/protected'), fn () => response('ok'));
        $this->assertSame('ok', $firstAllowed->getContent());

        $this->actingAs($this->user(16, 1));
        $secondAllowed = $middleware->handle(Request::create('/protected'), fn () => response('ok'));
        $this->assertSame('ok', $secondAllowed->getContent());
    }

    public function test_check_user_id_middleware_redirects_other_users_home(): void
    {
        $this->actingAs($this->user(5, 1));

        $response = (new CheckUserId())->handle(Request::create('/protected'), fn () => response('ok'));

        $this->assertSame(url('/home'), $response->headers->get('Location'));
    }

    public function test_switchhome_routes_all_users_to_forms_control(): void
    {
        $middleware = new switchhome();

        $this->actingAs($this->user(1, 2));
        $levelTwo = $middleware->handle(Request::create('/'), fn () => response('ok'));
        $this->assertTrue($levelTwo->isRedirect(route('formsControl')));

        $this->actingAs($this->user(2, 3));
        $levelThree = $middleware->handle(Request::create('/'), fn () => response('ok'));
        $this->assertTrue($levelThree->isRedirect(route('formsControl')));

        $this->actingAs($this->user(3, 9));
        $other = $middleware->handle(Request::create('/'), fn () => response('ok'));
        $this->assertTrue($other->isRedirect(route('formsControl')));
    }

    public function test_outhome_redirects_level_three_users(): void
    {
        $middleware = new Outhome();

        $this->actingAs($this->user(7, 3));
        $response = $middleware->handle(Request::create('/home'), fn () => response('ok'));
        $this->assertTrue($response->isRedirect(route('formsControl')));

        $this->actingAs($this->user(8, 1));
        $allowed = $middleware->handle(Request::create('/home'), fn () => response('ok'));
        $this->assertSame('ok', $allowed->getContent());
    }

    public function test_redirect_if_authenticated_keeps_current_custom_behavior(): void
    {
        $this->actingAs($this->user(1, 1));

        $response = (new RedirectIfAuthenticated())->handle(Request::create('/login'), fn () => response('ok'));

        $this->assertSame('ok', $response->getContent());
    }

    private function user(int $id, int $level): User
    {
        $user = new User([
            'name' => 'Test User',
            'email' => "user{$id}@example.com",
            'level' => $level,
        ]);
        $user->id = $id;
        $user->exists = true;

        return $user;
    }
}
