<?php

namespace App\Http\Models;

use App\Mail\MeetingUpdate;
use App\User;
use marcusvbda\vstack\Models\DefaultModel;
use marcusvbda\vstack\Models\Scopes\TenantScope;
use marcusvbda\vstack\Models\Observers\TenantObserver;
use Auth;
use Spatie\CalendarLinks\Link;
use Spatie\GoogleCalendar\Event;

class Meeting extends DefaultModel
{
    protected $table = "meetings";
    protected $dates = ["created_at", "updated_at", "starts_at", "ends_at"];
    public static function boot()
    {
        $user = Auth::user();
        parent::boot();
        if (Auth::check()) {
            if (Auth::user()->hasRole(["admin", "user"])) {
                static::observe(new TenantObserver());
                static::addGlobalScope(new TenantScope());
            }
        }
        self::creating(function ($model) use ($user) {
            $model->user_id = $user->id;
        });

        self::created(function ($model) {
            $model->customer->appendToTimeline(...$model->makeHistoryText("created"));
        });
    }

    public function makeHistoryText($type)
    {
        if ($type == "created") {

            if ($this->google_event_id) {
                return ["Reunião Criada", "A reunião criada, iniciando "  . $this->getMeetingTimeText()];
            }
            return ["Reunião Criada", "A reunião foi criada passada para o status " . $this->status->name . "."];
        }
    }

    public function responsible()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function updateCustomerTimeline($text)
    {
        $model = $this;
        $model->customer->appendToTimeline(
            "Reunião Atualizada",
            "Status: " . $model->status->name .
                ".</br></br>Descrição da atualização: </br>" .
                '<blockquote>
                <p><em>"' . $text . '"</em></p>
            </blockquote>'
        );
    }

    public function getMeetingTimeText()
    {
        return $this->starts_at->format("d/m/Y, \d\\e H:i") . " até " .  $this->ends_at->format("H:i");
    }

    public function status()
    {
        return $this->belongsTo(MeetingStatus::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public static function hasTenant()
    {
        return true;
    }

    public function room()
    {
        return $this->belongsTo(MeetingRoom::class, "meeting_room_id");
    }

    public function getEventAttribute()
    {
        return Event::find($this->google_event_id);
    }

    public function createEvent()
    {
        $model = $this;
        if ($model->google_event_id) return $model->event;
        $event = Event::create([
            'name' => $model->subject,
            'startDateTime' => $model->starts_at,
            'endDateTime' => $model->ends_at,
            'location' => $model->room->f_address,
            'visibility' => "public"
            //"attendees" => [["email" => $model->customer->email]],
        ]);
        $model->google_event_id = $event->id;
        $model->saveOrFail();
        return $event;
    }

    public function getFMeetingDurationAttribute()
    {
        $date = $this->ends_at->createMidnightDate();
        return [$this->starts_at->diffInMinutes($date) / 60, $this->ends_at->diffInMinutes($date) / 60];
    }

    public function sendUpdateEmail($subject,$appendBody){
        if(!trim($subject)){
            $subject = "Reunião: ".$this->subject;
        }
        return \Mail::to($this->customer->email)->send(new MeetingUpdate($this,$subject,$appendBody));
    }

    public function makeEventLink(){
        $link = Link::create($this->subject, $this->starts_at, $this->ends_at)
        //->description('Cookies & cocktails!')
        ->address($this->room->f_address);

        return $link->google();
    }
}
