<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Journal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public $journal;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // if(isset($request->journal)){
        //     if(!Str::isUuid($request->journal)){
        //         abort(404);
        //     }
            
        //     $this->journal = Journal::where('uuid', $request->journal)->first();
        //     if(empty($this->journal)){
        //         abort(404);
        //     }

        //     $permissions = Auth::user()->journal_us()->where('journal_id', $this->journal->id)->first();

        //     dd($permissions->permissions);
        // }else{
        //     if (Auth::check() && Auth::user()->hasPermissionTo($permission)) {
        //         return $next($request);
        //     }
        // }
        
        // if (Auth::check() && Auth::user()->hasPermissionTo($permission)) {
        //     return $next($request);
        // }

        // abort(403, 'Unauthorized Action.');

        return $next($request);
    }
}
