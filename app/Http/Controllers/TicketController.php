<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $myTickets = Ticket::where('userOne',$user->id)->where('active',1)->get();
        $otherTickets = Ticket::where('userTwo',$user->id)->where('active',1)->get();
        $closed = Ticket::orWhere('userTwo',$user->id)->orWhere('userOne',$user->id)->where('active',0)->get();
        $activeTicket = null;
        if ($request->ticket) $activeTicket = Ticket::where('id',$request->ticket)->with('chats')->first();
        return view('admin.ticket.index', compact('myTickets','otherTickets', 'activeTicket', 'closed', 'user'));
    }
    public function create()
    {
        $users = [];
        $user = auth()->user();
        $myTickets = Ticket::where('userOne',$user->id)->where('active',1)->get();
        $otherTickets = Ticket::where('userTwo',$user->id)->where('active',1)->get();
        $closed = Ticket::orWhere('userTwo',$user->id)->orWhere('userOne',$user->id)->where('active',0)->get();

        if ($user->can('all user')) $users = User::with('convene')->get();
        if ($user->can('some user')) $users = User::whereHas('conveneB', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return view('admin.ticket.create',compact('users','user','myTickets','otherTickets', 'closed'));
    }
    public function store(Request $request)
    {
        Ticket::create([
            'userOne' => auth()->user()->id,
            'userTwo' => $request->user_id,
            'title' => $request->title,
            'active' => 1,
            'startTS' => time(),
        ]);
        return redirect()->route('tickets.index')->with('success','تیکت با موفقیت ایجاد شد.');
    }
    public function update(Request $request ,Ticket $ticket)
    {
        Chat::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->user()->id,
            'text' => $request->text,
            'TS' => time(),
        ]);
        return redirect()->route('tickets.index',['ticket'=>$ticket->id])->with('success','تیکت با موفقیت ارسال شد.');
    }
    public function destroy(Ticket $ticket)
    {
        $ticket->update(['active'=>0]);
        Chat::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->user()->id,
            'text' => '--end--',
            'TS' => time(),
        ]);
        return redirect()->route('tickets.index')->with('success','تیکت با موفقیت بسته شد.');
    }
    public function manage(Request $request)
    {
        if (auth()->user()->can('manage ticket')) {
            $tickets = Ticket::with('chats','userTwo2','userOne1')->get();
            $user = auth()->user();
            $activeTicket = null;
            if ($request->ticket) $activeTicket = Ticket::where('id',$request->ticket)->with('chats')->first();
            return view('admin.ticket.ticket-manage',compact('tickets', 'user','activeTicket'));
        }
        return redirect()->route('dashboard')->with('failed','شما به این بخش دسترسی ندارید!');

    }

}
