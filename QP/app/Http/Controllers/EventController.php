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
use App\Exports\EventExport;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Imports\EventImport;
use App\Mail\ExportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
 
protected $rooms;

    public function __construct()
    {
      $this->rooms = ['room_dinis', 'room_isabel', 'room_joaoiii', 'room_leonor', 'room_espelhos', 'room_atrium', 'lago', 'auditorio', 'jardim', 'vip' , 'vip2' ];
    }

    public function create()
    {
        $appetizers = Appetizer::all();
        $soups = Soup::all();
        $meats = Meat::all();
        $fishs = Fish::all();
        $desserts = Dessert::all();
        $eventTypes = EventType::all();
        $statuses = Status::all();

        $rooms = $this->rooms;

        $dishes = [['Entradas','appetizer' => $appetizers], ['Sopa','soup' => $soups], ['Peixe','fish' => $fishs], ['Carne','meat' => $meats], ['Sobremesas','dessert' => $desserts]];
        return view('events.create', compact('dishes', 'eventTypes', 'statuses','rooms'));
    }

    public function store(Request $request)
    {
        $event = new Event($request->all());
        $event->save();

        $collisionEventIds = [];
        foreach ($this->rooms as $room) {
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
        return redirect()->route('events.getAll')->with('success', "-- $event->name -- gravado com sucesso.");
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

         if ($request->has('show_deleted')) {
            $query->where('deleted', true);
        } else {
            $query->where('deleted', false); 
        }

        $events = $query->with(['event_type_value', 'status_value'])->orderBy('event_date_start','asc')->get();

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

        
        $dishes = [['Entradas','appetizer' => $appetizers], ['Sopa','soup' => $soups], ['Peixe','fish' => $fishs], ['Carne','meat' => $meats], ['Sobremesas','dessert' => $desserts]];

        $rooms = $this->rooms;

        return view('events.edit', compact('event', 'eventTypes', 'dishes', 'statuses','rooms'));
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
        return redirect()->route('events.getAll')->with('success', "-- {$event->name} -- eliminado com sucesso.");
    }


    public function restore($id)
    {
        $event = Event::findOrFail($id);
        $event->deleted = false;
        $event->save();
        return redirect()->route('events.getAll')->with('success', 'Evento restaurado com sucesso!');
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update([
            'name' => $request['name'],
            'num_person' => $request['num_person'],
            'num_children' => $request['num_children'],
            'num_free_children' => $request['num_free_children'],
            'event_date_start' => $request['event_date_start'],
            'event_date_end' => $request['event_date_end'],
            'event_type' => $request['event_type'],
            'appetizer' => $request['appetizer'],
            'soup' => $request['soup'],
            'fish' => $request['fish'],
            'meat' => $request['meat'],
            'dessert' => $request['dessert'],
            'decoration' => $request['decoration'],
            'entertainment' => $request['entertainment'],
            'extras' => $request['extras'],
            'qp_resp_name' => $request['qp_resp_name'],
            'qp_resp_contact' => $request['qp_resp_contact'],
            'client_resp_name' => $request['client_resp_name'],
            'client_resp_contact' => $request['client_resp_contact'],
            'client_resp_email' => $request['client_resp_email'],
            'current_status' => $request['current_status'],
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
            'vip' => $request['vip'],
            'vip2' => $request['vip2'],
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
        foreach ($this->rooms as $room) {
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

        return redirect()->route('events.getAll')->with('success', "-- $event->name -- modificado com sucesso.");
    }

     public function data_management() {
        return view('database.database');
    }

    
    public function export() {
        $timestamp = Carbon::now()->format('Y_m_d_H:i');
        $fileName = 'events_backup_' . $timestamp . '.csv'; 
        $filePath = 'backup/' . $fileName;

        if (!Storage::exists('backup')) {
            Storage::makeDirectory('backup');
        }
      
        ExcelFacade::store(new EventExport, $filePath);
        return Storage::download($filePath);
    }



    public function import(Request $request)
        {
            $request->validate([
                'file' => 'required|mimes:csv,txt'
            ]);

            Excel::import(new EventImport, $request->file('file'));

            return back()->with('success', 'Events imported successfully.');
        }
        
    public function import_file()
        {
            $filePath = storage_path('app/public/events.csv');
            Excel::import(new EventImport, $filePath);

            return back()->with('success', 'Events imported successfully.');
        } 


    public function sendEmail(){
        $timestamp = Carbon::now()->format('Y_m_d_H:i');
        $fileName = 'events_backup_' . $timestamp . '.csv'; 
        $filePath = 'backup/' . $fileName;

        if (!Storage::exists('backup')) {
            Storage::makeDirectory('backup');
        }

        ExcelFacade::store(new EventExport, $filePath);
        Mail::to('pedrofprodrigues@gmail.com')->send(new ExportMail($fileName, $filePath));

        unlink($filePath);    
    }
         

}
