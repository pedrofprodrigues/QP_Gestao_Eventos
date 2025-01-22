<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Appetizer;
use App\Models\Meat;
use App\Models\Fish;
use App\Models\Soup;
use App\Models\Dessert;
use App\Models\EventType;
use App\Models\Status;

class EditInfoController extends Controller
{
    public function show()
    {
        $food_options = ['Entradas', 'Sopas', 'Peixes', 'Carnes', 'Sobremesas'];
        $other_options = ['Tipos de evento', 'Estados da reserva'];
        return view('editInfo.index', compact('food_options', 'other_options'));
    }


    public function createFood($option, Request $request)
    {
        $classToMatch = match ($option) {
            'Entradas' => Appetizer::class,
            'Sopas' => Soup::class,
            'Peixes' => Fish::class,
            'Carnes' => Meat::class,
            'Sobremesas' => Dessert::class,
            default => 'default result',
        };
        if (!$classToMatch) {
            return redirect()->back()->with('error', 'Invalid option selected.');
        }
        $newInfo = $classToMatch::create($request->only(['name', 'details', 'price', 'photo']));
        $newInfo->save();
        return redirect()->route('editTables')->with('success', "{$newInfo->name} criado com sucesso.");
    }


    public function createOther($option, Request $request)
    {
        $classToMatch = match ($option) {
            'Tipos de evento' => EventType::class,
            'Estados da reserva' => Status::class,
            default => 'default result',
        };
        if (!$classToMatch) {
            return redirect()->back()->with('error', 'Invalid option selected.');
        }
        $newInfo = $classToMatch::create($request->only(['option']));
        $newInfo->save();
        return redirect()->route('editTables')->with('success', "{$newInfo->option} criado com sucesso.");
    }

    public function editFoods($option)
    {
        $classToMatch = match ($option) {
            'Entradas' => Appetizer::class,
            'Sopas' => Soup::class,
            'Peixes' => Fish::class,
            'Carnes' => Meat::class,
            'Sobremesas' => Dessert::class,
            default => 'default result',
        };
        $completeInfo = $classToMatch::orderBy('id')->get();
        return view('editInfo.foodInfo', ['option' => $option], compact('completeInfo'));
    }
    public function editOtherOptions($option)
    {
        $classToMatch = match ($option) {
            'Tipos de evento' => EventType::class,
            'Estados da reserva' => Status::class,
            default => 'default result',
        };
        $completeInfo = $classToMatch::orderBy('id')->get();
        return view('editInfo.otherInfo', ['option' => $option], compact('completeInfo'));
    }

    public function saveEditFoods($option, Request $request)
    {
        $classToMatch = match ($option) {
            'Entradas' => Appetizer::class,
            'Sopas' => Soup::class,
            'Peixes' => Fish::class,
            'Carnes' => Meat::class,
            'Sobremesas' => Dessert::class,
            default => null,
        };

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/', 
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'galery' => 'nullable|image|mimes:jpeg,png,jpg,gif'
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $file->storeAs('uploads/photos', $filename, 'public');
            $validated['photo'] = $filename;
            $classToMatch::where('id', $request->id)->update([
                'photo' => $validated['photo']
            ]);
        }
         if ($request->hasFile('galery')) {
            $file = $request->file('galery');
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $file->storeAs('uploads/photos', $filename, 'public');
            $validated['galery'] = $filename;
            $currentGalery = $classToMatch::where('id', $request->id)->value('galery');
            $newGalery = $currentGalery . ',' . $validated['galery'];
            $classToMatch::where('id', $request->id)->update([
                'galery' => $newGalery,
            ]);
        }

        $classToMatch::where('id', $request->id)->update([
            'name' => $validated['name'],
            'details' => $validated['details'],
            'price' => $validated['price'],
        ]);

        return redirect()->route('editTables')->with('success', "{$validated['name']} modificado com sucesso.");
    }



    public function saveEditOthers($option, Request $request)
    {

        $classToMatch = match ($option) {
            'Event types' => EventType::class,
            'Statuses' => Status::class,
            default => 'default result',
        };

        $classToMatch::where('id', $request->id)
            ->update([
                'option' => $request->option,
            ]);
        return redirect()->route('editTables')->with('success', "{$request->option} modificado com sucesso.");
    }

    public function deleteOption($option, Request $request)
    {

        $classToMatch = match ($option) {
            'Appetizers' => Appetizer::class,
            'Soups' => Soup::class,
            'Fishes' => Fish::class,
            'Meats' => Meat::class,
            'Desserts' => Dessert::class,
            'Event types' => EventType::class,
            'Statuses' => Status::class,
            default => 'default result',
        };
        $classToMatch::where('id', $request->id)->delete();
        return redirect()->route('editTables')->with('success', "{$request->option} foi eliminado com sucesso.");
    }
}
