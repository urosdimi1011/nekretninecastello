<?php

namespace App\Http\Controllers;

use App\Http\Requests\MestaRequest;
use App\Models\Mesto;
use App\Services\Form\MestaFormServices;
use App\Services\Table\MestaTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MestaController extends Controller
{
    protected $tableService;
    protected $formService;

    public function __construct(
        MestaTableService $tableService,
        MestaFormServices $formService
    ) {
        $this->tableService = $tableService;
        $this->formService  = $formService;
    }

    public function index(Request $request)
    {
        $query = Mesto::query()
            ->withCount('nekretnine')
            ->orderBy('naziv');

        if ($request->filled('keywords')) {
            $keywords = $request->input('keywords');
            $query->where(function ($q) use ($keywords) {
                $q->where('naziv', 'like', "%{$keywords}%")
                    ->orWhere('slug', 'like', "%{$keywords}%");
            });
        }

        if ($request->has('status')) {
            if ($request->input('status') === 'aktivni') {
                $query->aktivni();
            } elseif ($request->input('status') === 'neaktivni') {
                $query->where('aktivan', false);
            }
        }

        $mesta = $query->paginate(12)->withQueryString();

        $mesta->getCollection()->transform(function ($mesto) {
            $mesto->broj_nekretnina = $mesto->nekretnine_count;
            return $mesto;
        });

        return view("tableView", [
            "column"   => $this->tableService->getColumn(),
            "data"     => $mesta,
            "tip"      => "mesta",
            "keywords" => $request->keywords,
        ]);
    }

    public function create()
    {
        return $this->formService->formForInsert([]);
    }

    public function store(MestaRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->only(['naziv', 'aktivan']);

            if ($request->filled('slug')) {
                $data['slug'] = $request->input('slug');
            } else {
                $data['slug'] = Str::slug($request->input('naziv'));
            }

            $originalSlug = $data['slug'];
            $counter = 1;
            while (Mesto::where('slug', $data['slug'])->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data['aktivan'] = $request->boolean('aktivan');

            Mesto::create($data);

            DB::commit();
            return response()->json(["uspeh" => "Uspešno ste dodali mesto."]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["neuspeh" => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $mesto = Mesto::findOrFail($id);
        return $this->formService->initializeForm(['mesto' => $mesto]);
    }

    public function update(MestaRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $mesto = Mesto::findOrFail($id);

            $data = $request->only(['naziv']);

            if ($request->filled('slug')) {
                $data['slug'] = $request->input('slug');
            } else {
                $data['slug'] = Str::slug($request->input('naziv'));
            }

            $originalSlug = $data['slug'];
            $counter = 1;
            while (Mesto::where('slug', $data['slug'])->where('id', '!=', $id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }

            $data['aktivan'] = $request->boolean('aktivan');

            $mesto->update($data);

            DB::commit();
            return response()->json(["uspeh" => "Uspešno ste ažurirali mesto."]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(["neuspeh" => $e->getMessage()], 500);
        }
    }

    public function destroy($id, Request $request)
    {
        $mesto = Mesto::withCount('nekretnine')->findOrFail($id);

        if (isset($request->prikaziFormu)) {
            $poruka = $mesto->nekretnine_count > 0
                ? "Ovo mesto ima {$mesto->nekretnine_count} nekretnina. "
                : "";
            $poruka .= "Da li ste sigurni da želite da obrišete mesto \"{$mesto->naziv}\"?";

            return view('confirm-delete', [
                "tip"    => "mesto",
                "poruka" => $poruka,
                "putanjaZaBrisanje" => "/admin/mesta/{$id}",
            ]);
        }

        try {
            DB::beginTransaction();
            if ($mesto->nekretnine_count > 0) {
                $mesto->nekretnine()->update(['mesto_id' => null]);
            }
            $mesto->delete();
            DB::commit();

            return redirect()
                ->route('tabelarniPrikazMesta')
                ->with('success', 'Mesto je uspešno obrisano.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()
                ->route('tabelarniPrikazMesta')
                ->with('error', 'Došlo je do greške: ' . $e->getMessage());
        }
    }
}
