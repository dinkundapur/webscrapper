<table class="table table-bordered">
    <thead>
        <tr>
            <th><h4>Total News : {{$totalNews}}</h4></th>
</tr>
</thead>
<tbody>
    @foreach($latestNews as $news)
    <tr>
        <td> 
            <a href="news/{{$news['web_contents_id']}}">{{$news['title']}}</a>
        </td>
    </tr>
    @endforeach
</tbody>
</table>
<div class="pull-left table_footer">
    {!! $paginationString !!}
</div>

<div class="row dataTables_wrapper">
    <div class="pull-right">
        {!! $pagination->links() !!}

    </div>
</div>