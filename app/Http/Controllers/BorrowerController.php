<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowerController extends Controller
{
    public function index(Request $request)
    {
        return Borrower::query()
            ->orderBy($request->post("sortBy") ?? "id", $request->post("sortDesc") ? "desc" : "asc")
            ->paginate($request->post("perPage") ?? 15);
    }

    public function search(Request $request)
    {
        $request->validate([
            "filter" => "string|nullable"
        ]);
        return Borrower::query()
            ->when($request->post("filter"), function (Builder $builder) use ($request) {
                $builder->where("name", "like", "%" . $request->post("filter") . "%");
            })
            ->when($request->post("key"), function (Builder $builder) use ($request) {
                $builder->where($request->post("key"), "=", $request->post("value"));
            })
            ->select([
                DB::raw("id as value"),
                DB::raw("CONCAT(id,' # ',name) as text")
            ])
            ->limit(20)
            ->get();
    }
}
