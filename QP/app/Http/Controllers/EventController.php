<?php

namespace App\Http\Controllers;

use App\Models\Appetizer;
use App\Models\Meat;
use App\Models\Fish;
use App\Models\Soup;
use App\Models\Dessert;
use App\Models\EventType;
use App\Models\Event;
use App\Models\Status;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        $appetizers = Appetizer::all();
        $soups = Soup::all();
        $meats = Meat::all();
        $fishs = Fish::all();
        $desserts = Dessert::all();
        $eventTypes = EventType::all();
        $statuses = Status::all();


        $dishes = ['appetizer' => $appetizers, 'soup' => $soups, 'fish' => $fishs, 'meat' => $meats, 'dessert' => $desserts];
        return view('events.create', compact('dishes', 'eventTypes', 'statuses'));
    }

    public function store(Request $request)
    {
        $event = new Event($request->all());
        $event->save();

        $collisionEventIds = [];
        $rooms = ['room_dinis', 'room_isabel', 'room_joaoiii', 'room_leonor', 'room_espelhos', 'room_atrium', 'lago', 'auditorio', 'jardim'];
        foreach ($rooms as $room) {
            if ($event->$room == "on") {
                $collidingEvents = Event::where('id', '!=', $event->id)->where('deleted', false)->where(function ($query) use ($event) {
                    $query->where('event_date_start', '>=', now())
                        ->where(function ($query) use ($event) {
                            $query->whereBetween('event_date_start', [$event->event_date_start, $event->event_date_end])
                                ->orWhereBetween('event_date_end', [$event->event_date_start, $event->event_date_end])
                                ->orWhere(function ($query) use ($event) {
                                    $query->where('event_date_start', '<=', $event->event_date_start)
                                        ->where('event_date_end', '>=', $event->event_date_end);
                                });
                        });
                })->where($room, true)->get();

                foreach ($collidingEvents as $collidingEvent) {
                    $collisionEventIds[] = $collidingEvent->id;
                    $existingCollisionIds = json_decode($collidingEvent->collision_ids, true) ?? [];
                    $existingCollisionIds[] = $event->id;
                    $collidingEvent->collision_ids = json_encode(array_unique($existingCollisionIds));
                    $collidingEvent->save();
                }
            }
        }
        $collisionEventIds = array_unique($collisionEventIds);
        $event->collision_ids = json_encode($collisionEventIds);
        $event->save();
        return redirect()->route('events.getAll');
    }

    public function home()
    {
        return view('events.index');
    }
    public function index(Request $request)
    {
        $statuses = Status::all();
        $eventTypes = EventType::all();

        $query = Event::query();

        if ($request->has('event_name') && !empty($request->event_name)) {
            $query->where('name', 'like', '%' . $request->event_name . '%');
        }
        if ($request->has('event_date') && $request->event_date) {
            $query->whereDate('event_date_start', $request->event_date);
        }

        if ($request->has('status') && $request->status) {
            $query->where('current_status', $request->status);
        }
        if ($request->has('event_type') && $request->event_type) {
            $query->where('event_type', $request->event_type);
        }
        $events = $query->where('deleted', false)->with(['event_type_value', 'status_value'])->get();

        return view('events.index', compact('events', 'statuses', 'eventTypes'));
    }

    public function editEvent($id)
    {
        $appetizers = Appetizer::all();
        $soups = Soup::all();
        $meats = Meat::all();
        $fishs = Fish::all();
        $desserts = Dessert::all();
        $eventTypes = EventType::all();
        $statuses = Status::all();
        $event = Event::find($id);

        $dishes = ['appetizer' => $appetizers, 'soup' => $soups, 'fish' => $fishs, 'meat' => $meats, 'dessert' => $desserts];

        return view('events.edit', compact('event', 'eventTypes', 'dishes', 'statuses'));
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        $collisionIds = json_decode($event->collision_ids, true);

        if (is_array($collisionIds) && !empty($collisionIds)) {
            foreach ($collisionIds as $collisionEventId) {
                $eventEdit = Event::findOrFail($collisionEventId);
                $relatedCollisionIds = json_decode($eventEdit->collision_ids, true);
                $eventEdit->collision_ids = json_encode(array_filter($relatedCollisionIds, function ($singleId) use ($id) {
                    return $singleId != $id;
                }));

                $eventEdit->save();
            }
        }

        $event->deleted = true;
        $event->save();
        return redirect()->route('events.getAll')->with('success', "{$event->name} event deleted successfully.");
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'num_person' => 'required|integer',
            'num_children' => 'required|integer',
            'num_free_children' => 'required|integer',
            'event_date_start' => 'required|date',
            'event_date_end' => 'required|date',
            'event_type' => 'required|integer',
            'appetizer' => 'required|integer',
            'soup' => 'required|integer',
            'fish' => 'required|integer',
            'meat' => 'required|integer',
            'dessert' => 'required|integer',
            'decoration' => 'required|string|max:255',
            'entertainment' => 'nullable|string',
            'extras' => 'nullable|string',
            'qp_resp_name' => 'required|string|max:255',
            'qp_resp_contact' => 'required|string|max:255',
            'client_resp_name' => 'required|string|max:255',
            'client_resp_contact' => 'required|string|max:255',
            'client_resp_email' => 'required|email|max:255',
            'current_status' => 'required|integer',
            'lago_extras' => 'nullable|string',
            'auditorio_extras' => 'nullable|string',
            'jardim_extras' => 'nullable|string',
        ]);
        $event = Event::findOrFail($id);
        $event->update([
            'name' => $validated['name'],
            'num_person' => $validated['num_person'],
            'num_children' => $validated['num_children'],
            'num_free_children' => $validated['num_free_children'],
            'event_date_start' => $validated['event_date_start'],
            'event_date_end' => $validated['event_date_end'],
            'event_type' => $validated['event_type'],
            'appetizer' => $validated['appetizer'],
            'soup' => $validated['soup'],
            'fish' => $validated['fish'],
            'meat' => $validated['meat'],
            'dessert' => $validated['dessert'],
            'decoration' => $validated['decoration'],
            'entertainment' => $validated['entertainment'],
            'extras' => $validated['extras'],
            'qp_resp_name' => $validated['qp_resp_name'],
            'qp_resp_contact' => $validated['qp_resp_contact'],
            'client_resp_name' => $validated['client_resp_name'],
            'client_resp_contact' => $validated['client_resp_contact'],
            'client_resp_email' => $validated['client_resp_email'],
            'current_status' => $validated['current_status'],
            'lago_extras' => $request['lago_extras'],
            'auditorio_extras' => $request['auditorio_extras'],
            'jardim_extras' => $request['jardim_extras'],
            'room_dinis' => $request['room_dinis'],
            'room_isabel' =>  $request['room_isabel'],
            'room_joaoiii' =>  $request['room_joaoiii'],
            'room_leonor' =>  $request['room_leonor'],
            'room_espelhos' => $request['room_espelhos'],
            'room_atrium' =>  $request['room_atrium'],
            'lago' => $request['lago'],
            'auditorio' => $request['auditorio'],
            'jardim' => $request['jardim'],
        ]);

        $collisionIds = json_decode($event->collision_ids, true);

        if (is_array($collisionIds) && !empty($collisionIds)) {
            foreach ($collisionIds as $collisionEventId) {
                $eventEdit = Event::findOrFail($collisionEventId);
                $relatedCollisionIds = json_decode($eventEdit->collision_ids, true);
                $eventEdit->collision_ids = json_encode(array_filter($relatedCollisionIds, function ($singleId) use ($id) {
                    return $singleId != $id;
                }));

                $eventEdit->save();
            }
        }

        $collisionEventIds = [];
        $rooms = ['room_dinis', 'room_isabel', 'room_joaoiii', 'room_leonor', 'room_espelhos', 'room_atrium', 'lago', 'auditorio', 'jardim'];
        foreach ($rooms as $room) {
            if ($event->$room == "on") {
                $collidingEvents = Event::where('id', '!=', $event->id)->where('deleted', false)->where(function ($query) use ($event) {
                    $query->where('event_date_start', '>=', now())
                        ->where(function ($query) use ($event) {
                            $query->whereBetween('event_date_start', [$event->event_date_start, $event->event_date_end])
                                ->orWhereBetween('event_date_end', [$event->event_date_start, $event->event_date_end])
                                ->orWhere(function ($query) use ($event) {
                                    $query->where('event_date_start', '<=', $event->event_date_start)
                                        ->where('event_date_end', '>=', $event->event_date_end);
                                });
                        });
                })->where($room, true)->get();

                foreach ($collidingEvents as $collidingEvent) {
                    $collisionEventIds[] = $collidingEvent->id;
                    $existingCollisionIds = json_decode($collidingEvent->collision_ids, true) ?? [];
                    $existingCollisionIds[] = $event->id;
                    $collidingEvent->collision_ids = json_encode(array_unique($existingCollisionIds));
                    $collidingEvent->save();
                }
            }
        }
        $collisionEventIds = array_unique($collisionEventIds);
        $event->collision_ids = json_encode($collisionEventIds);
        $event->save();

        return redirect()->route('events.getAll')->with('success', "$event->name event was updated successfully.");
    }
}
