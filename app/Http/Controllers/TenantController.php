<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Stancl\Tenancy\TenantManager;
use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Artisan;
use App\Events\RegisterTenantEvent;
use App\Listeners\RegisterTenantListener;
class TenantController extends Controller
{
    public function showRegistrationForm()
    {
        return view('tenant.register');
    }

    public function register(Request $request)
    {
       
        $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:domains',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|max:255'
        ]);

        // Create a new tenant
        $tenant = Tenant::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Attach the domain to the tenant
        $tenant->domains()->create([
            'domain' => $request->domain,
        ]);

       

        // Run migrations for the tenant
        tenancy()->initialize($tenant);
        Artisan::call('tenants:migrate');

        // Run the tenant's context
        $tenant->run(function () use ($request, $tenant) {
            // Create the tenant's admin user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'tenant_id' => $tenant->id
            ]);
        });
        event(new RegisterTenantEvent($tenant));

        

        

        // Optionally, create a tenant owner user here

        return redirect()->route('tenant.showRegistrationForm')->with('success', 'Tenant registered successfully!');
    }

    public function show(Request $request)
    {
        $url = $request->input('tenant');
        
        return Redirect::to($url);
    }
}