<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(Request $request)
    {
        return Account::query()
            ->with(["borrower:id,name"])
            ->orderBy($request->post("sortBy") ?? "id", $request->post("sortDesc") ? "desc" : "asc")
            ->paginate($request->post("perPage") ?? 15);
    }

    public function search(Request $request)
    {
        $request->validate([
            "filter" => "string|nullable"
        ]);
        return Account::query()
            ->when($request->post("filter"), function (Builder $builder) use ($request) {
                $builder
                    ->where("account_name", "like", "%" . $request->post("filter") . "%")
                    ->orWhere("account_no", "like", "%" . $request->post("filter") . "%");
            })
            ->when($request->post("key"), function (Builder $builder) use ($request) {
                $builder->where($request->post("key"), "=", $request->post("value"));
            })
            ->select([
                DB::raw("id as value"),
                DB::raw("account_no as text")
            ])
            ->limit(20)
            ->get();
    }

    public function listByBorrowerId(Request $request)
    {
        $request->validate([
            "borrower_id" => "numeric|required"
        ]);
        return Account::query()
            ->where("borrower_id", "=", $request->post("borrower_id"))
            ->select([
                "id",
                "account_no",
                "account_name"
            ])
            ->get();
    }

}
