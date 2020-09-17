<center>
    {{ date('M d, Y',strtotime($start)) }} - {{ date('M d, Y',strtotime($end)) }}
</center>

<table style="width: 100%" border="1" cellpadding="0" cellspacing="0">
    <tr>
        <td rowspan="2">Form No.</td>
        <td rowspan="2">Service</td>
        <td rowspan="2">Service By</td>
        <td rowspan="2">Requested By</td>
        <td rowspan="2">Section</td>
        <td colspan="2">Acted Upon</td>
        <td colspan="2">Completed</td>
    </tr>
    <tr>
        <td>Date</td>
        <td>Time</td>
        <td>Date</td>
        <td>Time</td>
        <td>Date</td>
        <td>Time</td>
    </tr>
    @foreach($data as $row)
    <tr>
        <td>{{ $row->form_no }}</td>
        <td>
            <?php $service = \App\JobService::leftJoin('services','services.id','=','job_services.service_id')->where('job_id',$row->id)->get(); ?>
            @if($service)
                <ul>
                    @foreach($service as $s)
                        <li>{{ $s->name }}</li>
                    @endforeach

                    @if($row->others)
                        <li class="text-green">Ohers: {{ $row->others }}</li>
                    @endif
                </ul>
            @endif
        </td>
        <td>
            {{ ($row->service_by) ? $row->service_by: '--' }}
        </td>
        <td>
            {{ $row->request_by }}
        </td>
        <td>
            {{ $row->request_office }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($row->request_date)->format('Y M d') }}
        </td>
        <td>
            {{ \Carbon\Carbon::parse($row->request_date)->format('h:i A') }}
        </td>
        <td>
            @if($row->acted_date)
                {{ \Carbon\Carbon::parse($row->acted_date)->format('Y M d') }}
            @else
                --
            @endif
        </td>
        <td>
            @if($row->acted_date)
                {{ \Carbon\Carbon::parse($row->acted_date)->format('h:i A') }}
            @else
                --
            @endif
        </td>
        <td>
            @if($row->completed_date)
                {{ \Carbon\Carbon::parse($row->completed_date)->format('Y M d') }}
            @else
                --
            @endif
        </td>
        <td>
            @if($row->completed_date)
                {{ \Carbon\Carbon::parse($row->completed_date)->format('h:i A') }}
            @else
                --
            @endif
        </td>
    </tr>
    @endforeach
</table>

form #
serves
end user
section
serviceby
date requested
time requeset
Acted upon
