<table align="center" cellpadding="5" cellspacing="0" >
    <tr id="header">
        @foreach($header as $excelFileHead)
        <td><b>{{$excelFileHead}}</b></td>
        @endforeach
    </tr>
    @foreach($data as $news)
    <tr>       
        <td>{{$news['title']}}</td>
        <td>{{$news['content']}}</td>
        <td>{{$news['image_urls']}}</td>  

    </tr>
    @endforeach
</table>