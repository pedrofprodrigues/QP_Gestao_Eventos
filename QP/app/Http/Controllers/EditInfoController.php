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
        $food_options = ['Appetizers', 'Soups', 'Fishes', 'Meats', 'Desserts'];
        $other_options = ['Event types', 'Statuses'];
        return view('editInfo.index', compact('food_options', 'other_options'));
    }


    public function createFood($option, Request $request)
    {
        $classToMatch = match ($option) {
            'Appetizers' => Appetizer::class,
            'Soups' => Soup::class,
            'Fishes' => Fish::class,
            'Meats' => Meat::class,
            'Desserts' => Dessert::class,
            default => 'default result',
        };
        if (!$classToMatch) {
            return redirect()->back()->with('error', 'Invalid option selected.');
        }
        $newInfo = $classToMatch::create($request->only(['name', 'details', 'price', 'photo']));
        $newInfo->save();
        return redirect()->route('editTables')->with('success', "{$newInfo->name} has been created successfully.");
    }


    public function createOther($option, Request $request)
    {
        $classToMatch = match ($option) {
            'Event types' => EventType::class,
            'Statuses' => Status::class,
            default => 'default result',
        };
        if (!$classToMatch) {
            return redirect()->back()->with('error', 'Invalid option selected.');
        }
        $newInfo = $classToMatch::create($request->only(['option']));
        $newInfo->save();
        return redirect()->route('editTables')->with('success', "{$newInfo->option} has been created successfully.");
    }

    public function editFoods($option)
    {
        $classToMatch = match ($option) {
            'Appetizers' => Appetizer::class,
            'Soups' => Soup::class,
            'Fishes' => Fish::class,
            'Meats' => Meat::class,
            'Desserts' => Dessert::class,
            default => 'default result',
        };
        $completeInfo = $classToMatch::orderBy('id')->get();
        return view('editInfo.foodInfo', ['option' => $option], compact('completeInfo'));
    }
    public function editOtherOptions($option)
    {
        $classToMatch = match ($option) {
            'Event types' => EventType::class,
            'Statuses' => Status::class,
            default => 'default result',
        };
        $completeInfo = $classToMatch::orderBy('id')->get();
        return view('editInfo.otherInfo', ['option' => $option], compact('completeInfo'));
    }

    public function saveEditFoods($option, Request $request)
    {
        // Match the model class based on the option
        $classToMatch = match ($option) {
            'Appetizers' => Appetizer::class,
            'Soups' => Soup::class,
            'Fishes' => Fish::class,
            'Meats' => Meat::class,
            'Desserts' => Dessert::class,
            default => null,
        };


        // Validate the input fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'details' => 'required|string',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/', // Ensure price is a valid decimal
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            // Append timestamp to the original file name to ensure uniqueness
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . $originalName;

            // Store the file in the `uploads/photos` directory
            $file->storeAs('uploads/photos', $filename, 'public');

            // Update the validated data with the stored file name
            $validated['photo'] = $filename;
        }

        // Update the database record
        $classToMatch::where('id', $request->id)->update([
            'name' => $validated['name'],
            'details' => $validated['details'],
            'price' => $validated['price'],
            'photo' => $validated['photo'] ?? $request->photo, // Keep existing photo if no new file is uploaded
        ]);

        return redirect()->route('editTables')->with('success', "{$validated['name']} has been changed successfully.");
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
        return redirect()->route('editTables')->with('success', "{$request->option} has been changed successfully.");
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
        return redirect()->route('editTables')->with('success', "{$request->option} has been deleted.");
    }
}
